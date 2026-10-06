require('dotenv/config');

const path = require('path');
const express = require('express');
const helmet = require('helmet');
const compression = require('compression');
const cookieParser = require('cookie-parser');
const rateLimit = require('express-rate-limit');
const bcrypt = require('bcryptjs');
const sanitizeHtml = require('sanitize-html');
const nodemailer = require('nodemailer');

const { version } = require('./package.json');
const { db, settingsObject, updateSettings, ensureInitialAdmin } = require('./src/db');
const { uploadsRoot, mediaSet, bulletins, gallery } = require('./src/media');
const {
  signAdmin,
  readAdmin,
  setAdminCookie,
  clearAdminCookie,
  requireAdmin,
  requireCsrf
} = require('./src/auth');

const app = express();
const PORT = Number(process.env.PORT || 8080);
const isProd = process.env.NODE_ENV === 'production';
const configuredBaseUrl = String(process.env.BASE_URL || ('http://localhost:' + PORT)).replace(/\/$/, '');

if (isProd) {
  const sessionSecret = String(process.env.SESSION_SECRET || '');
  if (sessionSecret.length < 32 || sessionSecret === 'replace-with-at-least-32-random-characters') {
    throw new Error('SESSION_SECRET must be a unique value of at least 32 characters in production.');
  }

  let parsedBase;
  try { parsedBase = new URL(configuredBaseUrl); } catch { throw new Error('BASE_URL must be a valid absolute URL.'); }
  if (parsedBase.protocol !== 'https:') throw new Error('BASE_URL must use https:// in production.');
}

if (process.env.TRUST_PROXY) app.set('trust proxy', Number(process.env.TRUST_PROXY) || 1);
app.set('view engine', 'ejs');
app.set('views', path.join(__dirname, 'views'));

app.use(helmet({
  contentSecurityPolicy: {
    directives: {
      defaultSrc: ["'self'"],
      imgSrc: ["'self'", 'data:'],
      styleSrc: ["'self'", "'unsafe-inline'"],
      scriptSrc: ["'self'"],
      connectSrc: ["'self'"],
      fontSrc: ["'self'", 'data:'],
      objectSrc: ["'none'"],
      frameAncestors: ["'none'"],
      baseUri: ["'self'"],
      formAction: ["'self'"]
    }
  },
  crossOriginResourcePolicy: { policy: 'cross-origin' },
  strictTransportSecurity: isProd ? { maxAge: 15552000, includeSubDomains: false, preload: false } : false
}));
app.use(compression());
app.use(cookieParser());
app.use(express.urlencoded({ extended: false, limit: '256kb' }));
app.use(express.json({ limit: '256kb' }));
app.use(express.static(path.join(__dirname, 'public'), { maxAge: isProd ? '1h' : 0, immutable: false }));
app.use('/wp-content/uploads', express.static(uploadsRoot, { maxAge: isProd ? '7d' : 0, immutable: false }));

app.use((req, res, next) => {
  res.setHeader('Permissions-Policy', 'camera=(), microphone=(), geolocation=(), payment=()');
  if (req.path.startsWith('/admin')) {
    res.setHeader('X-Robots-Tag', 'noindex, nofollow, noarchive');
    res.setHeader('Cache-Control', 'no-store');
  }
  next();
});

function requestBaseUrl(req) {
  const rawHost = String(req.get('host') || '').trim();
  if (!rawHost || /[\r\n]/.test(rawHost)) return configuredBaseUrl;
  try {
    const candidate = new URL(req.protocol + '://' + rawHost);
    return candidate.origin;
  } catch {
    return configuredBaseUrl;
  }
}

function configuredHostname() {
  try { return new URL(configuredBaseUrl).hostname.replace(/^www\./, '').toLowerCase(); } catch { return ''; }
}

function canonicalFor(req) {
  const current = String(req.hostname || '').replace(/^www\./, '').toLowerCase();
  return current && current === configuredHostname() ? configuredBaseUrl : requestBaseUrl(req);
}

app.use((req, res, next) => {
  res.locals.settings = settingsObject();
  res.locals.path = req.path;
  res.locals.media = mediaSet();
  res.locals.currentYear = new Date().getFullYear();
  res.locals.assetVersion = version;
  res.locals.baseUrl = canonicalFor(req);
  res.locals.admin = readAdmin(req);
  if (isProd && String(req.hostname || '').replace(/^www\./, '').toLowerCase() !== configuredHostname()) {
    res.setHeader('X-Robots-Tag', 'noindex, nofollow, noarchive');
  }
  next();
});

ensureInitialAdmin();

const loginLimiter = rateLimit({ windowMs: 15 * 60 * 1000, limit: 10, standardHeaders: true, legacyHeaders: false });
const contactLimiter = rateLimit({ windowMs: 15 * 60 * 1000, limit: 6, standardHeaders: true, legacyHeaders: false });

function meta(title, description, image) {
  return { title, description, image: image || mediaSet().hero || '' };
}

function cleanText(value, max = 4000) {
  return String(value || '').replace(/\0/g, '').trim().slice(0, max);
}

function slugify(value) {
  return cleanText(value, 120).toLowerCase().normalize('NFKD').replace(/[\u0300-\u036f]/g, '')
    .replace(/[^a-z0-9]+/g, '-').replace(/^-+|-+$/g, '').slice(0, 90) || ('news-' + Date.now());
}

function smtpConfig() {
  return {
    host: String(process.env.SMTP_HOST || '').trim(),
    port: Math.max(1, Math.min(65535, Number(process.env.SMTP_PORT || 587) || 587)),
    secure: String(process.env.SMTP_SECURE || '').toLowerCase() === 'true',
    user: String(process.env.SMTP_USER || '').trim(),
    pass: String(process.env.SMTP_PASS || ''),
    from: String(process.env.SMTP_FROM || "St Monica's Parish Website <website@saint-monica.org.uk>"),
    to: String(process.env.CONTACT_TO || settingsObject().email || '').trim()
  };
}

async function emailEnquiry(enquiry) {
  const cfg = smtpConfig();
  if (!cfg.host || !cfg.to || (cfg.user && !cfg.pass)) return;
  const transport = nodemailer.createTransport({
    host: cfg.host,
    port: cfg.port,
    secure: cfg.secure,
    auth: cfg.user ? { user: cfg.user, pass: cfg.pass } : undefined
  });
  await transport.sendMail({
    from: cfg.from,
    to: cfg.to,
    replyTo: enquiry.email,
    subject: 'St Monica website enquiry from ' + enquiry.name,
    text: [
      'New website enquiry',
      '',
      'Name: ' + enquiry.name,
      'Email: ' + enquiry.email,
      'Phone: ' + (enquiry.phone || '-'),
      '',
      enquiry.message
    ].join('\n')
  });
}

function latestPosts(limit = 6) {
  return db.prepare('SELECT * FROM posts WHERE published=1 ORDER BY created_at DESC,id DESC LIMIT ?').all(limit);
}

app.get('/health', (req, res) => {
  try {
    db.prepare('SELECT 1').get();
    res.setHeader('Cache-Control', 'no-store');
    res.json({ ok: true, service: 'saint-monica-parish', version });
  } catch {
    res.status(503).json({ ok: false, service: 'saint-monica-parish', version });
  }
});

app.get('/', (req, res) => {
  const settings = settingsObject();
  const chosenMedia = mediaSet();
  if (settings.hero_image_path) chosenMedia.hero = settings.hero_image_path;
  res.render('home', {
    media: chosenMedia,
    latestNews: latestPosts(3),
    latestBulletins: bulletins(4),
    meta: meta(
      "St Monica's Catholic Church, Coatbridge",
      'Mass times, parish news, Sacraments, bulletins and contact information for St Monica’s Catholic Church in Coatbridge.',
      chosenMedia.hero
    )
  });
});

app.get('/mass-times', (req, res) => {
  res.render('page', {
    page: {
      eyebrow: 'Prayer & worship',
      title: 'Mass times',
      intro: 'You are warmly welcome to join us for the celebration of Mass and prayer at St Monica’s.',
      sections: [
        { title: 'Sunday Masses', body: settingsObject().sunday_masses },
        { title: 'Weekday Masses', body: settingsObject().weekday_masses },
        { title: 'Eucharistic Adoration', body: settingsObject().adoration_times },
        { title: 'Holidays of Obligation', body: settingsObject().holyday_masses },
        { title: 'Reconciliation', body: settingsObject().confession_times }
      ],
      note: 'Times can occasionally change for funerals, holidays and parish events. Please check the latest bulletin for this week’s notices.'
    },
    meta: meta('Mass Times | St Monica’s Parish', 'Sunday and weekday Mass times, Adoration and Confession at St Monica’s Catholic Church, Coatbridge.', mediaSet().mission)
  });
});

app.get('/sacraments', (req, res) => {
  res.render('page', {
    page: {
      eyebrow: 'Faith & life',
      title: 'The Sacraments',
      intro: 'The Sacraments mark and sustain the life of the Church. St Monica’s is here to help parishioners prepare prayerfully for each celebration.',
      sections: [
        { title: 'Baptism', body: 'To arrange a Baptism, please contact the parish priest. Preparation and suitable dates can then be discussed with you.' },
        { title: 'First Reconciliation & First Holy Communion', body: 'Children normally prepare through the parish and school community. Please contact the parish if you have a child approaching these Sacraments.' },
        { title: 'Confirmation', body: 'Preparation is offered in partnership with families, schools and the wider parish community.' },
        { title: 'Marriage', body: 'Couples wishing to marry at St Monica’s should contact the parish priest well in advance so that preparation and paperwork can be arranged.' },
        { title: 'Reconciliation', body: settingsObject().confession_times },
        { title: 'Anointing of the Sick', body: 'Please contact the parish directly if you or a family member would like the Sacrament of the Sick or a pastoral visit.' }
      ],
      note: 'For Sacramental enquiries, call ' + settingsObject().phone + ' or email ' + settingsObject().email + '.'
    },
    meta: meta('Sacraments | St Monica’s Parish', 'Baptism, First Communion, Confirmation, Marriage, Reconciliation and Anointing of the Sick at St Monica’s, Coatbridge.', mediaSet().sacraments)
  });
});

app.get('/parish', (req, res) => {
  res.render('parish', {
    meta: meta('Our Parish | St Monica’s, Coatbridge', 'Meet the parish priest and learn about the mission and community of St Monica’s Catholic Church in Coatbridge.', mediaSet().priest || mediaSet().community)
  });
});

app.get('/parish-hall', (req, res) => {
  res.render('hall', {
    meta: meta('Parish Hall | St Monica’s Parish', 'St Monica’s Parish Hall in Coatbridge is available for functions, with two licensed rooms, parking and accessible entry.', mediaSet().hall)
  });
});

app.get('/bulletins', (req, res) => {
  res.render('bulletins', {
    bulletins: bulletins(),
    meta: meta('Parish Bulletins | St Monica’s', 'Read and download parish bulletins from St Monica’s Catholic Church, Coatbridge.', mediaSet().mission)
  });
});

app.get('/news', (req, res) => {
  res.render('news', {
    posts: latestPosts(100),
    meta: meta('Parish News | St Monica’s', 'Latest news and notices from St Monica’s Parish, Coatbridge.', mediaSet().community)
  });
});

app.get('/news/:slug', (req, res) => {
  const post = db.prepare('SELECT * FROM posts WHERE slug=? AND published=1').get(req.params.slug);
  if (!post) return res.status(404).render('404', { meta: meta('Page not found | St Monica’s', 'The requested page could not be found.') });
  res.render('article', {
    post,
    meta: meta(post.title + ' | St Monica’s Parish', post.excerpt || 'Parish news from St Monica’s Catholic Church, Coatbridge.', mediaSet().community)
  });
});

app.get('/contact', (req, res) => {
  res.render('contact', {
    sent: req.query.sent === '1',
    error: null,
    form: {},
    meta: meta('Contact St Monica’s Parish', 'Contact St Monica’s Catholic Church, Sharp Avenue, Coatbridge ML5 5RP.', mediaSet().hero)
  });
});

app.post('/contact', contactLimiter, async (req, res) => {
  const form = {
    name: cleanText(req.body.name, 120),
    email: cleanText(req.body.email, 180).toLowerCase(),
    phone: cleanText(req.body.phone, 60),
    message: cleanText(req.body.message, 4000)
  };

  if (!form.name || !/^\S+@\S+\.\S+$/.test(form.email) || form.message.length < 10) {
    return res.status(400).render('contact', {
      sent: false,
      error: 'Please enter your name, a valid email address and a little more detail in your message.',
      form,
      meta: meta('Contact St Monica’s Parish', 'Contact St Monica’s Catholic Church, Coatbridge.', mediaSet().hero)
    });
  }

  db.prepare('INSERT INTO enquiries(name,email,phone,message) VALUES(?,?,?,?)').run(form.name, form.email, form.phone, form.message);
  emailEnquiry(form).catch(err => console.error('Contact email failed:', err.message));
  res.redirect('/contact?sent=1');
});

app.get('/privacy', (req, res) => {
  res.render('page', {
    page: {
      eyebrow: 'Your privacy',
      title: 'Privacy notice',
      intro: 'This website collects only the information needed to respond to parish enquiries and administer the website.',
      sections: [
        { title: 'Contact enquiries', body: 'If you use the contact form we store the name, email address, optional phone number and message you provide so that the parish can respond.' },
        { title: 'Website administration', body: 'Administrator access uses a secure sign-in cookie. Public visitors are not tracked by this website and no advertising cookies are set by the site itself.' },
        { title: 'Third-party links', body: 'Links to the Diocese and other external services open websites operated by those organisations, whose own privacy policies apply.' },
        { title: 'Your rights', body: 'For questions about information submitted through this website, contact the parish using the details shown on the Contact page.' }
      ]
    },
    meta: meta('Privacy Notice | St Monica’s Parish', 'Privacy information for the St Monica’s Parish website.')
  });
});

app.get('/gallery', (req, res) => {
  res.render('gallery', {
    images: gallery(30),
    meta: meta('Parish Gallery | St Monica’s', 'Images from the life and history of St Monica’s Parish, Coatbridge.', mediaSet().community)
  });
});

/* Preserve common legacy WordPress links after cutover. */
app.get('/contact-us', (req, res) => res.redirect(301, '/contact'));
app.get('/people/rev-fr-ghislain-bakulikire-mulumanzi', (req, res) => res.redirect(301, '/parish'));
app.get(/^\/bulletin-/i, (req, res) => res.redirect(301, '/bulletins'));

app.get('/robots.txt', (req, res) => {
  res.type('text/plain').send('User-agent: *\nAllow: /\nDisallow: /admin\nSitemap: ' + configuredBaseUrl + '/sitemap.xml\n');
});

app.get('/sitemap.xml', (req, res) => {
  const fixed = ['/', '/mass-times', '/sacraments', '/parish', '/parish-hall', '/bulletins', '/news', '/gallery', '/contact', '/privacy'];
  const news = db.prepare('SELECT slug FROM posts WHERE published=1 ORDER BY id').all().map(row => '/news/' + encodeURIComponent(row.slug));
  const urls = fixed.concat(news).map(route => '<url><loc>' + configuredBaseUrl + route + '</loc></url>').join('');
  res.type('application/xml').send('<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' + urls + '</urlset>');
});

/* Admin */
app.get('/admin/login', (req, res) => {
  if (readAdmin(req)) return res.redirect('/admin');
  res.render('admin-login', { error: null, meta: { title: 'Admin sign in | St Monica’s', noindex: true } });
});

app.post('/admin/login', loginLimiter, (req, res) => {
  const email = cleanText(req.body.email, 180).toLowerCase();
  const password = String(req.body.password || '');
  const admin = db.prepare('SELECT * FROM admins WHERE email=?').get(email);
  if (!admin || !bcrypt.compareSync(password, admin.password_hash)) {
    return res.status(401).render('admin-login', { error: 'Email address or password not recognised.', meta: { title: 'Admin sign in | St Monica’s', noindex: true } });
  }

  const session = signAdmin(admin);
  setAdminCookie(res, session.token);
  res.redirect('/admin');
});

app.post('/admin/logout', requireAdmin, requireCsrf, (req, res) => {
  clearAdminCookie(res);
  res.redirect('/admin/login');
});

app.get('/admin', requireAdmin, (req, res) => {
  const posts = db.prepare('SELECT * FROM posts ORDER BY created_at DESC,id DESC LIMIT 30').all();
  const enquiries = db.prepare('SELECT * FROM enquiries ORDER BY created_at DESC,id DESC LIMIT 50').all();
  res.render('admin', {
    csrf: req.admin.csrf,
    posts,
    enquiries,
    mediaChoices: gallery(16),
    smtpReady: Boolean(smtpConfig().host && smtpConfig().to),
    meta: { title: 'Parish CMS | St Monica’s', noindex: true }
  });
});

const editableSettings = [
  'site_name','site_strapline','hero_title','hero_text','address','phone','email','parish_priest',
  'hall_phone','hall_email','charity_number','diocese_name','diocese_url','facebook_url','youtube_url',
  'x_url','sunday_masses','weekday_masses','holyday_masses','confession_times','adoration_times',
  'footer_text','hero_image_path','contact_intro'
];

app.post('/admin/settings', requireAdmin, requireCsrf, (req, res) => {
  updateSettings(req.body, editableSettings);
  res.redirect('/admin#settings');
});

app.post('/admin/news', requireAdmin, requireCsrf, (req, res) => {
  const title = cleanText(req.body.title, 160);
  const excerpt = cleanText(req.body.excerpt, 500);
  const body = sanitizeHtml(String(req.body.body || ''), {
    allowedTags: ['p','br','strong','em','ul','ol','li','h2','h3','a','blockquote'],
    allowedAttributes: { a: ['href','target','rel'] },
    allowedSchemes: ['http','https','mailto','tel']
  });
  if (!title || !body.trim()) return res.status(400).send('A title and body are required.');

  let slug = slugify(title);
  let suffix = 2;
  while (db.prepare('SELECT 1 FROM posts WHERE slug=?').get(slug)) {
    slug = slugify(title) + '-' + suffix++;
  }
  db.prepare('INSERT INTO posts(title,slug,excerpt,body_html,published) VALUES(?,?,?,?,?)')
    .run(title, slug, excerpt, body, req.body.published === '1' ? 1 : 0);
  res.redirect('/admin#news');
});

app.post('/admin/news/:id/delete', requireAdmin, requireCsrf, (req, res) => {
  db.prepare('DELETE FROM posts WHERE id=?').run(Number(req.params.id));
  res.redirect('/admin#news');
});

app.post('/admin/enquiries/:id/read', requireAdmin, requireCsrf, (req, res) => {
  db.prepare('UPDATE enquiries SET read_at=COALESCE(read_at,CURRENT_TIMESTAMP) WHERE id=?').run(Number(req.params.id));
  res.redirect('/admin#enquiries');
});

app.use((req, res) => {
  res.status(404).render('404', { meta: meta('Page not found | St Monica’s', 'The requested page could not be found.') });
});

app.listen(PORT, '0.0.0.0', () => {
  console.log('St Monica parish website listening on port ' + PORT);
});
