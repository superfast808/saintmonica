# St Monica's Parish Website

Modern replacement website for St Monica's Catholic Church, Coatbridge.

## Stack

- Node.js 22
- Express + EJS
- SQLite for lightweight parish CMS data
- Docker / Docker Compose
- Existing WordPress media library reused from `wp-content/uploads`
- Secure admin area for parish information, news and enquiries

## Production deployment

The application listens internally on port 8080 and Docker publishes it on localhost only. The default host port is 8097.

```bash
cd /opt/saintmonica

git pull

cp -n .env.example .env
nano .env
```

Set at minimum:

```env
NODE_ENV=production
PORT=8080
HOST_PORT=8097
BASE_URL=https://saint-monica.org.uk
TRUST_PROXY=1

SESSION_SECRET=GENERATE_A_LONG_RANDOM_SECRET

ADMIN_EMAIL=YOUR_ADMIN_EMAIL
ADMIN_PASSWORD=YOUR_STRONG_INITIAL_PASSWORD
```

Generate a session secret with:

```bash
openssl rand -hex 48
```

Then build:

```bash
docker compose down
docker compose build --no-cache
docker compose up -d
docker compose ps
docker compose logs --tail=100 web
```

Health check:

```bash
curl -i http://127.0.0.1:8097/health
```

Expected response:

```json
{"ok":true,"service":"saint-monica-parish","version":"1.0.0"}
```

## Plesk proxy

Point the domain's reverse proxy to:

```
http://127.0.0.1:8097
```

The public site should remain HTTPS through Plesk/nginx.

## Admin

Admin login:

```
https://saint-monica.org.uk/admin/login
```

The first administrator is created from `ADMIN_EMAIL` and `ADMIN_PASSWORD` on first startup only.

## Persistent data

SQLite data lives in:

```
./data/
```

This directory is mounted into the container and is deliberately excluded from Git.

## Existing media

The original WordPress image and bulletin library remains in:

```
wp-content/uploads/
```

The new site automatically discovers suitable full-size images and bulletin PDFs from this directory, so the rebuild can reuse the existing parish photography without WordPress.

## Useful commands

```bash
cd /opt/saintmonica

git pull
docker compose up -d --build

docker compose ps
docker compose logs -f --tail=100 web

docker compose restart web
```
