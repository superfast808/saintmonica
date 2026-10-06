const fs = require('fs');
const path = require('path');
const Database = require('better-sqlite3');
const bcrypt = require('bcryptjs');

const dataDir = path.join(__dirname, '..', 'data');
fs.mkdirSync(dataDir, { recursive: true });

const db = new Database(path.join(dataDir, 'site.db'));
db.pragma('journal_mode = WAL');
db.pragma('foreign_keys = ON');

db.exec([
  'CREATE TABLE IF NOT EXISTS settings (key TEXT PRIMARY KEY, value TEXT NOT NULL DEFAULT \'\')',
  'CREATE TABLE IF NOT EXISTS admins (id INTEGER PRIMARY KEY AUTOINCREMENT, email TEXT NOT NULL UNIQUE, password_hash TEXT NOT NULL, created_at TEXT NOT NULL DEFAULT CURRENT_TIMESTAMP)',
  'CREATE TABLE IF NOT EXISTS posts (id INTEGER PRIMARY KEY AUTOINCREMENT, title TEXT NOT NULL, slug TEXT NOT NULL UNIQUE, excerpt TEXT NOT NULL DEFAULT \'\', body_html TEXT NOT NULL DEFAULT \'\', published INTEGER NOT NULL DEFAULT 1, created_at TEXT NOT NULL DEFAULT CURRENT_TIMESTAMP, updated_at TEXT NOT NULL DEFAULT CURRENT_TIMESTAMP)',
  'CREATE TABLE IF NOT EXISTS enquiries (id INTEGER PRIMARY KEY AUTOINCREMENT, name TEXT NOT NULL, email TEXT NOT NULL, phone TEXT NOT NULL DEFAULT \'\', message TEXT NOT NULL, created_at TEXT NOT NULL DEFAULT CURRENT_TIMESTAMP, read_at TEXT)'
].join(';'));

const defaults = {
  site_name: "St Monica's Parish",
  site_strapline: 'Catholic Church · Coatbridge',
  hero_title: 'Welcome to St Monica’s.',
  hero_text: 'A Catholic parish in Coatbridge, gathering for Mass, prayer and the Sacraments, and serving our community with faith, hope and welcome.',
  address: 'Sharp Avenue, Coatbridge ML5 5RP, Scotland',
  phone: '01236 421750',
  email: 'stmonica@rcdom.org.uk',
  parish_priest: 'Rev. Fr. Ghislain Bakulikire Mulumanzi',
  hall_phone: '07549 042450',
  hall_email: 'stmonicashall@outlook.com',
  charity_number: 'SC011041',
  diocese_name: 'Diocese of Motherwell',
  diocese_url: 'https://www.rcdom.org.uk/st-monicas-coatbridge',
  facebook_url: '',
  youtube_url: '',
  x_url: '',
  sunday_masses: 'Saturday Vigil 4:00pm · Sunday 10:00am, 12 noon & 5:00pm',
  weekday_masses: 'Monday–Saturday 10:00am',
  holyday_masses: '8:00am · 10:00am · 7:00pm',
  confession_times: 'Saturday after 10:00am Mass · upon request at any time',
  adoration_times: 'Monday–Saturday 9:00am–9:55am',
  footer_text: 'St Monica’s is a Roman Catholic parish in the Diocese of Motherwell, serving the community of Coatbridge and welcoming all who wish to pray with us.',
  hero_image_path: '',
  contact_intro: 'For parish enquiries, Sacraments, certificates or pastoral matters, please contact the parish office.'
};

const insertSetting = db.prepare('INSERT OR IGNORE INTO settings(key,value) VALUES(?,?)');
const seed = db.transaction(() => {
  for (const [key, value] of Object.entries(defaults)) insertSetting.run(key, String(value));
});
seed();

/* Refine first-release copy without overwriting anything the parish has edited. */
db.prepare("UPDATE settings SET value=? WHERE key='hero_title' AND value=?").run(
  'Welcome to St Monica’s.',
  'A parish rooted in faith, welcome and community.'
);
db.prepare("UPDATE settings SET value=? WHERE key='hero_text' AND value=?").run(
  'A Catholic parish in Coatbridge, gathering for Mass, prayer and the Sacraments, and serving our community with faith, hope and welcome.',
  'Welcome to St Monica’s Catholic Church in Coatbridge. Join us for Mass, prayer, the Sacraments and the life of our parish community.'
);

function settingsObject() {
  const rows = db.prepare('SELECT key,value FROM settings').all();
  return Object.fromEntries(rows.map(row => [row.key, row.value]));
}

function updateSettings(values, allowedKeys) {
  const stmt = db.prepare('INSERT INTO settings(key,value) VALUES(?,?) ON CONFLICT(key) DO UPDATE SET value=excluded.value');
  const tx = db.transaction(() => {
    for (const key of allowedKeys) {
      if (Object.prototype.hasOwnProperty.call(values, key)) stmt.run(key, String(values[key] || '').trim());
    }
  });
  tx();
}

function ensureInitialAdmin() {
  const count = db.prepare('SELECT COUNT(*) AS c FROM admins').get().c;
  if (count) return;

  const email = String(process.env.ADMIN_EMAIL || '').trim().toLowerCase();
  const password = String(process.env.ADMIN_PASSWORD || '');
  if (!email || password.length < 12) {
    if (process.env.NODE_ENV === 'production') {
      throw new Error('ADMIN_EMAIL and a strong ADMIN_PASSWORD of at least 12 characters are required for first startup.');
    }
    return;
  }

  const hash = bcrypt.hashSync(password, 12);
  db.prepare('INSERT INTO admins(email,password_hash) VALUES(?,?)').run(email, hash);
  console.log('Created initial Saint Monica administrator:', email);
}

module.exports = { db, defaults, settingsObject, updateSettings, ensureInitialAdmin };
