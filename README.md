# Shiv Aaradhana Private Limited — Enterprise B2B Export Platform

A production-grade, high-performance Laravel 12 application for international B2B agricultural and textile export commerce, catalog discovery, RFQ processing, and operations management.

---

## 🚀 Key Highlights & Architecture

- **100% Pure PHP Runtime:** Converted completely to pure PHP with zero Node.js, zero npm, and zero Vite dependencies in production.
- **Standalone Production Assets:** All compiled CSS (Tailwind with custom themes & fonts) and JavaScript (Alpine.js, GSAP, Axios, and RFQ Quotation Manager) are versioned and served statically from `public/css/app.css` and `public/js/app.js` with automatic cache busting.
- **Production-Grade Docker Setup:** Multi-stage Docker image featuring **PHP 8.3-FPM + Alpine + Nginx + Supervisord** with OPcache, gzip compression, client-side caching, and dynamic port binding (`$PORT`) compatible with Render, Fly.io, Cloud Run, AWS, and traditional VPS/cPanel.
- **End-to-End Enterprise RFQ Journey:** Multi-product RFQ quotation cart, honeypot spam protection, transactional email notifications, and comprehensive admin dashboard.

---

## 🛠️ Local Development

### Requirements
- **PHP 8.2+ or 8.3+** with extensions: `bcmath`, `curl`, `exif`, `gd`, `intl`, `mbstring`, `pdo_sqlite` / `pdo_mysql`, `zip`
- **Composer 2.x**

### Setup & Run
```bash
# 1. Install PHP dependencies
composer install

# 2. Setup environment & database
php artisan key:generate
php artisan migrate --force
php artisan storage:link --force

# 3. Start local development server
php artisan serve
```
*(Or use `composer run dev` to run the development server, queue listener, and pail logger concurrently).*

---

## 🐳 Production Deployment (Docker)

The production Docker image is 100% PHP-based and requires **zero Node.js or npm**:

### Build & Run Locally
```bash
docker build -t shiv-aaradhana .
docker run -p 8000:80 shiv-aaradhana
```

### Docker Compose
```bash
docker compose up -d
```
Access the application at `http://localhost:8000`.

### Cloud Deployments (Render / Fly.io / Railway / AWS ECS)
- The container dynamically detects the `$PORT` environment variable provided by cloud hosts (e.g. `PORT=10000` on Render) and automatically configures Nginx to bind to that port.
- Health check endpoint is available at `/health` and returns JSON status for database and storage writability.

---

## 🧪 Testing & Quality Assurance

Run the comprehensive automated test suite (52 tests / 322 assertions covering catalog, branding, RFQ workflow, security, and admin lifecycle):

```bash
php artisan test
```

---

## 🔒 Security & Performance Features

- **Nginx Security Headers:** `X-Frame-Options`, `X-Content-Type-Options`, `X-XSS-Protection`, `Referrer-Policy`.
- **Static Asset Caching:** 1-year browser cache headers with automatic timestamped query invalidation (`?v=<timestamp>`).
- **PHP OPcache:** Enabled for CLI and FPM with interned strings buffer and accelerated file mappings.
- **Route & Config Caching:** Fully compatible with `php artisan optimize` (`config:cache`, `route:cache`, `view:cache`).
