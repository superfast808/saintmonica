const fs = require('fs');
const path = require('path');

const uploadsRoot = path.join(__dirname, '..', 'wp-content', 'uploads');
let cache = { at: 0, images: [], bulletins: [] };

/*
 * This WordPress media library contains material carried over from older sites,
 * including several clearly-labelled St Columbkille/Rutherglen assets.
 * Curated paths below keep those from accidentally becoming St Monica hero imagery.
 */
const CURATED = {
  hero: [
    '2020/06/church-picture-124728-1.jpg',
    '2017/06/Church-renovated.jpg',
    '2017/06/Church-3.jpg'
  ],
  mission: [
    '2017/06/Altar-Picture-2.jpg',
    '2021/04/Altar-Picture-2.jpg'
  ],
  community: [
    '2015/03/parish-meeting-DS-900px-.jpg',
    '2021/07/Childrens-Church.jpg'
  ],
  hall: [
    '2017/08/Hall_IMG_0002.jpg',
    '2017/08/Hall_IMG_0011.jpg',
    '2014/12/Parish_hall.jpg'
  ],
  priest: [
    '2017/06/Fr_Ghis.jpg',
    '2017/06/clergy_fr_mulumanzi.jpg'
  ],
  saint: [
    '2022/03/monica.jpg'
  ]
};

const EXCLUDED_MEDIA = /(?:st[_-]?col(?:umbkille|_ps)|columbkille|rutherglen|trinity[_-]?high|patron_saint_columbkille|carfin[_-](?:church|parish)|first_st_columbkille)/i;
const NON_PHOTO_MEDIA = /(?:logo|icon|schedule|bulletin|pdf|screenshot|screen-shot|word-cloud|clipart|poster|rota|alert|raffle|gift-aid|weather|cancelled|facebook|social-media|twitter)/i;

const APPROVED_HALL_PHOTOS = [
  '/images/hall/main-room.jpg',
  '/images/hall/celebration-setup.jpg',
  '/images/hall/bouncy-castle-wide.jpg',
  '/images/hall/bouncy-castle-room.jpg',
  '/images/hall/bouncy-castle.jpg'
];

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

function fileFor(relativePath) {
  return path.join(uploadsRoot, ...String(relativePath).split('/'));
}

function webPath(file) {
  return '/wp-content/uploads/' + rel(file).split('/').map(encodeURIComponent).join('/');
}

function webPathForRelative(relativePath) {
  const file = fileFor(relativePath);
  return fs.existsSync(file) ? webPath(file) : '';
}

function firstExisting(paths) {
  for (const relativePath of paths || []) {
    const url = webPathForRelative(relativePath);
    if (url) return url;
  }
  return '';
}

function imageScore(file) {
  const name = rel(file).toLowerCase();
  let size = 0;
  try { size = fs.statSync(file).size; } catch {}

  let score = Math.min(size / 100000, 40);
  if (/monica|church|altar|sanctuary|parish|mass|chapel|hall|ghislain|ghis|mulumanzi|priest|father|community/.test(name)) score += 28;
  if (/2024|2023|2022|2021|2020/.test(name)) score += 4;
  if (NON_PHOTO_MEDIA.test(name)) score -= 30;
  if (EXCLUDED_MEDIA.test(name)) score -= 100;
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
    .filter(file => !/\/(?:thumb|\.original)\//i.test(file))
    .filter(file => !EXCLUDED_MEDIA.test(rel(file)))
    .filter(file => !NON_PHOTO_MEDIA.test(rel(file)))
    .filter(file => {
      try { return fs.statSync(file).size >= 60000; } catch { return false; }
    })
    .map(file => ({ file, url: webPath(file), name: prettyFileName(file), score: imageScore(file) }))
    .sort((a, b) => b.score - a.score || a.url.localeCompare(b.url));

  const seenBulletins = new Set();
  const bulletins = files
    .filter(file => /bulletin/i.test(path.basename(file)) && /\.pdf$/i.test(file))
    .map(file => {
      const relative = rel(file);
      const folderDate = relative.match(/(^|\/)(20\d{2})\/(0?[1-9]|1[0-2])\//);
      const year = folderDate ? Number(folderDate[2]) : Number((relative.match(/20\d{2}/) || [])[0] || 0);
      const month = folderDate ? Number(folderDate[3]) : 0;
      const monthLabel = month
        ? new Intl.DateTimeFormat('en-GB', { month: 'short', timeZone: 'UTC' }).format(new Date(Date.UTC(2024, month - 1, 1)))
        : '';

      return {
        file,
        url: webPath(file),
        title: prettyFileName(file)
          .replace(/\s+\d+$/,'')
          .replace(/\bFacebook\b/ig,'')
          .replace(/\s+/g,' ')
          .trim(),
        dateKey: bulletinDateKey(file),
        year,
        month,
        monthLabel
      };
    })
    .filter(item => {
      const key = item.title.toLowerCase().replace(/\s+/g,' ').trim();
      if (seenBulletins.has(key)) return false;
      seenBulletins.add(key);
      return true;
    })
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

function markUsed(used, url) {
  if (url) used.add(url);
  return url;
}

function mediaSet() {
  const images = refresh().images;
  const used = new Set();

  const hero = markUsed(used, firstExisting(CURATED.hero))
    || choose(images, /monica|church|parish/, used);

  const mission = markUsed(used, firstExisting(CURATED.mission))
    || choose(images, /altar|sanctuary|mass|church/, used);

  const community = markUsed(used, firstExisting(CURATED.community))
    || choose(images, /community|parish|group|event/, used);

  const hall = APPROVED_HALL_PHOTOS[0];

  const priest = markUsed(used, firstExisting(CURATED.priest))
    || choose(images, /ghislain|ghis|mulumanzi|priest|father|clergy/, used);

  const saint = markUsed(used, firstExisting(CURATED.saint));
  const sacraments = choose(images, /bapt|communion|confirm|wedding|sacrament|mass|altar/, used) || mission;

  const curatedGallery = [
    hero,
    mission,
    community,
    hall,
    priest,
    saint,
    webPathForRelative('2019/04/IMG_2709.jpg'),
    webPathForRelative('2019/08/IMG_3101.jpg'),
    webPathForRelative('2017/06/20170517_DSC6797.jpg'),
    webPathForRelative('2017/06/20170517_DSC6808.jpg')
  ].filter(Boolean);

  const gallery = [...new Set([
    ...curatedGallery,
    ...images.filter(item => !used.has(item.url)).map(item => item.url)
  ])].slice(0, 12);

  return { hero, mission, sacraments, community, hall, hallGallery: APPROVED_HALL_PHOTOS, priest, saint, gallery };
}

function bulletins(limit) {
  const list = refresh().bulletins;
  return Number.isFinite(limit) ? list.slice(0, limit) : list;
}

function gallery(limit = 12) {
  const urls = mediaSet().gallery.slice(0, limit);
  const byUrl = new Map(refresh().images.map(item => [item.url, item]));
  return urls.map(url => byUrl.get(url) || {
    url,
    name: prettyFileName(fileFor(decodeURIComponent(url.replace('/wp-content/uploads/',''))))
  });
}

module.exports = { uploadsRoot, mediaSet, bulletins, gallery, refresh };
