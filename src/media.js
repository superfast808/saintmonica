const fs = require('fs');
const path = require('path');

const uploadsRoot = path.join(__dirname, '..', 'wp-content', 'uploads');
let cache = { at: 0, images: [], bulletins: [] };

function walk(dir, results = []) {
  if (!fs.existsSync(dir)) return results;
  for (const entry of fs.readdirSync(dir, { withFileTypes: true })) {
    const full = path.join(dir, entry.name);
    if (entry.isDirectory()) walk(full, results);
    else results.push(full);
  }
  return results;
}

function rel(file) {
  return path.relative(uploadsRoot, file).split(path.sep).join('/');
}

function webPath(file) {
  return '/wp-content/uploads/' + rel(file).split('/').map(encodeURIComponent).join('/');
}

function imageScore(file) {
  const name = rel(file).toLowerCase();
  let size = 0;
  try { size = fs.statSync(file).size; } catch {}
  let score = Math.min(size / 100000, 40);
  if (/church|monica|altar|sanctuary|parish|mass|chapel|hall|ghislain|priest|father|community/.test(name)) score += 28;
  if (/2024|2023|2022/.test(name)) score += 4;
  if (/logo|icon|avatar|cropped|header/.test(name)) score -= 8;
  return score;
}

function bulletinDateKey(file) {
  const p = rel(file);
  const folder = p.match(/(^|\/)(20\d{2})\/(0?[1-9]|1[0-2])\//);
  if (folder) return Number(folder[2]) * 100 + Number(folder[3]);
  const year = p.match(/20\d{2}/);
  return year ? Number(year[0]) * 100 : 0;
}

function prettyFileName(file) {
  return path.basename(file, path.extname(file))
    .replace(/[_-]+/g, ' ')
    .replace(/\s+/g, ' ')
    .trim();
}

function refresh() {
  const now = Date.now();
  if (now - cache.at < 60000) return cache;

  const files = walk(uploadsRoot);
  const images = files
    .filter(file => /\.(jpe?g|png|webp)$/i.test(file))
    .filter(file => !/-\d{2,4}x\d{2,4}\.(jpe?g|png|webp)$/i.test(file))
    .filter(file => {
      try { return fs.statSync(file).size >= 60000; } catch { return false; }
    })
    .map(file => ({ file, url: webPath(file), name: prettyFileName(file), score: imageScore(file) }))
    .sort((a, b) => b.score - a.score || a.url.localeCompare(b.url));

  const bulletins = files
    .filter(file => /bulletin/i.test(path.basename(file)) && /\.pdf$/i.test(file))
    .map(file => ({
      file,
      url: webPath(file),
      title: prettyFileName(file),
      dateKey: bulletinDateKey(file)
    }))
    .sort((a, b) => b.dateKey - a.dateKey || b.url.localeCompare(a.url));

  cache = { at: now, images, bulletins };
  return cache;
}

function choose(images, pattern, used) {
  const found = images.find(item => pattern.test(item.name.toLowerCase()) && !used.has(item.url))
    || images.find(item => !used.has(item.url))
    || null;
  if (found) used.add(found.url);
  return found ? found.url : '';
}

function mediaSet() {
  const images = refresh().images;
  const used = new Set();
  return {
    hero: choose(images, /church|monica|parish|altar|sanctuary/, used),
    mission: choose(images, /altar|sanctuary|mass|church/, used),
    sacraments: choose(images, /bapt|communion|confirm|wedding|sacrament|mass/, used),
    community: choose(images, /community|parish|group|event|church/, used),
    hall: choose(images, /hall|function|party/, used),
    priest: choose(images, /ghislain|priest|father|clergy/, used),
    gallery: images.filter(item => !used.has(item.url)).slice(0, 8).map(item => item.url)
  };
}

function bulletins(limit) {
  const list = refresh().bulletins;
  return Number.isFinite(limit) ? list.slice(0, limit) : list;
}

function gallery(limit = 12) {
  return refresh().images.slice(0, limit);
}

module.exports = { uploadsRoot, mediaSet, bulletins, gallery, refresh };
