const crypto = require('crypto');
const jwt = require('jsonwebtoken');

const COOKIE_NAME = 'saintmonica_admin';

function secret() {
  return String(process.env.SESSION_SECRET || 'development-only-secret-change-me');
}

function signAdmin(admin) {
  const csrf = crypto.randomBytes(24).toString('hex');
  const token = jwt.sign(
    { id: admin.id, email: admin.email, csrf },
    secret(),
    { expiresIn: '12h', issuer: 'saint-monica-parish' }
  );
  return { token, csrf };
}

function readAdmin(req) {
  const token = req.cookies && req.cookies[COOKIE_NAME];
  if (!token) return null;
  try {
    return jwt.verify(token, secret(), { issuer: 'saint-monica-parish' });
  } catch {
    return null;
  }
}

function setAdminCookie(res, token) {
  res.cookie(COOKIE_NAME, token, {
    httpOnly: true,
    secure: process.env.NODE_ENV === 'production',
    sameSite: 'lax',
    maxAge: 12 * 60 * 60 * 1000,
    path: '/'
  });
}

function clearAdminCookie(res) {
  res.clearCookie(COOKIE_NAME, { path: '/' });
}

function requireAdmin(req, res, next) {
  const admin = readAdmin(req);
  if (!admin) return res.redirect('/admin/login');
  req.admin = admin;
  next();
}

function requireCsrf(req, res, next) {
  const admin = req.admin || readAdmin(req);
  const supplied = String((req.body && req.body.csrf) || req.get('x-csrf-token') || '');
  if (!admin || !supplied || supplied !== admin.csrf) return res.status(403).send('Invalid security token.');
  req.admin = admin;
  next();
}

module.exports = { signAdmin, readAdmin, setAdminCookie, clearAdminCookie, requireAdmin, requireCsrf };
