<div align="center">

# 🛠️ KeepADA CMMS
### Next-Generation Industrial Computerized Maintenance Management System

**An ultra-modern, multi-tenant asset management, predictive maintenance, and work order orchestration platform built on Laravel 12 & Tailwind CSS.**

---

[![License: Apache 2.0](https://img.shields.io/badge/License-Apache%202.0-blue.svg?style=flat-square)](LICENSE)
[![Laravel Version](https://img.shields.io/badge/Laravel-12.x-FF2D20?style=flat-square&logo=laravel&logoColor=white)](https://laravel.com)
[![PHP Version](https://img.shields.io/badge/PHP-8.2%20%7C%208.3%20%7C%208.4-777BB4?style=flat-square&logo=php&logoColor=white)](https://php.net)
[![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-3.x-38B2AC?style=flat-square&logo=tailwind-css&logoColor=white)](https://tailwindcss.com)
[![CI Tests](https://img.shields.io/github/actions/workflow/status/adacreativeco/KeepADA/ci.yml?branch=main&label=CI%20Build&style=flat-square)](https://github.com/adacreativeco/KeepADA/actions)

<br/>

[ 🇬🇧 English ](README.md) &nbsp;•&nbsp; [ 🇹🇷 Türkçe ](README.tr.md) &nbsp;•&nbsp; [ 🇩🇪 Deutsch ](README.de.md)

</div>

---

<p align="center">
  <img src="docs/screenshots/dashboard.png" alt="KeepADA CMMS Main Dashboard" width="100%" style="border-radius: 12px; box-shadow: 0 20px 40px rgba(0,0,0,0.4);" />
</p>

---

## ⚡ Why KeepADA?

Traditional CMMS platforms are often sluggish, cluttered, or difficult to use on the factory floor. **KeepADA CMMS** is built from the ground up to solve these pain points:

- 🚀 **100% Bespoke Architecture:** Zero slow administrative wrappers or heavy boilerplate. Pure, blazing-fast Laravel 12 + Alpine.js + Tailwind CSS.
- 🏢 **Native Multi-Tenancy:** Manage multiple manufacturing facilities, plants, or clients under isolated sub-tenants (`/panel/{company:slug}/...`).
- 🧠 **AI-Assisted Predictive Maintenance:** Automatic time-to-failure forecasting calculated from runtime meters, operating velocity, and historical breakdowns.
- 📷 **Live QR Workflow:** Built-in camera QR scanner + zero-login Public Digital Asset Passports (`/e/{code}`) + printable adhesive industrial asset tags.
- 📊 **Executive Analytics:** Real-time MTTR (Mean Time to Repair), MTBF (Mean Time Between Failures), SLA compliance, and cost breakdown charts.
- 🌍 **Triple-Language Ready:** Instant switching between English 🇬🇧, Turkish 🇹🇷, and German 🇩🇪.

---

## 🧭 System Modules & Feature Tour

### 1. ⚙️ Asset & Equipment Lifecycle Management
- **Central Asset Registry:** Track critical equipment with serial numbers, brands, models, warranty terms, and assigned plant locations.
- **Smart Runtime Meters:** Log operating hours, cycles, or mileage with instant maintenance threshold triggers.
- **Printable Thermal QR Labels:** Generates ready-to-print adhesive stickers formatted for thermal label printers.

<p align="center">
  <img src="docs/screenshots/equipment_detail.png" alt="Equipment & Predictive Maintenance" width="95%" />
</p>

---

### 2. 📋 Work Orders & Maintenance Operations
- **Interactive Kanban Board & Data Table:** Fluid task lifecycle management across `Pending`, `In Progress`, `Done`, and `Cancelled`.
- **SLA & Target Resolution Tracking:** Real-time countdowns and visual indicators for overdue tasks.
- **Cost Accounting & Parts Consumption:** Track labor cost, technician work hours, contractor expenses, and automatically deduct consumed spare parts from inventory.

<p align="center">
  <img src="docs/screenshots/tasks_kanban.png" alt="Work Orders Kanban Board" width="95%" />
</p>

---

### 3. 📊 Advanced Analytics, MTTR / MTBF & Financial Reports
- **Reliability Metrics:** Automated computation of **MTTR** (Mean Time to Repair in hours) and **MTBF** (Mean Time Between Failures).
- **Cost Distribution Breakdown:** Interactive Chart.js charts detailing Labor vs Outside Services vs Spare Parts.
- **Technician Scorecard:** Comprehensive leaderboard tracking completion rates and on-time SLA percentages.
- **Direct CSV Exports:** Instant one-click CSV downloads for Work Orders, Equipment Inventory, and Stock Movement Ledgers.

<p align="center">
  <img src="docs/screenshots/reports_analytics.png" alt="Advanced Reports and MTTR MTBF Analytics" width="95%" />
</p>

---

### 4. 🗓️ Interactive Maintenance Calendar & Scheduling
- **FullCalendar v6 Integration:** Month, week, and day views of all upcoming preventive tasks and scheduled work orders with color-coded priority indicators.

<p align="center">
  <img src="docs/screenshots/calendar.png" alt="Maintenance Calendar" width="95%" />
</p>

---

### 5. 🌐 Public Digital QR Passport (`/e/{code}`)
- Technicians or operators on the factory floor can scan the physical machine sticker with any smartphone camera to view technical specifications, operating status, and submit an immediate breakdown ticket without requiring panel login.

<p align="center">
  <img src="docs/screenshots/public_qr_passport.png" alt="Public Digital Asset Passport" width="95%" />
</p>

---

## 🛠️ Technology Stack

| Layer | Technology |
|---|---|
| **Backend Core** | PHP 8.2+ / 8.3 / 8.4, Laravel 12.x |
| **Database** | SQLite (Default Dev), MySQL 8+, PostgreSQL |
| **Frontend UI** | Blade, Tailwind CSS, Alpine.js, Lucide Icons |
| **Charts & Calendar** | Chart.js, FullCalendar v6 |
| **QR & Scanning** | HTML5-QRCode, QR Server API |
| **Authentication & RBAC** | Spatie Laravel Permission, Custom Multi-Tenant Middleware |

---

## 🚀 Quick Start & Installation Guide

### 1. Requirements
- **PHP** `>= 8.2` (Extensions: `pdo`, `mbstring`, `openssl`, `tokenizer`, `xml`, `ctype`, `json`, `curl`, `fileinfo`)
- **Composer** `>= 2.2`
- **Node.js & NPM** (Optional)

### 2. Installation Steps

```bash
# 1. Clone the repository
git clone https://github.com/adacreativeco/KeepADA.git
cd KeepADA

# 2. Install PHP dependencies
composer install

# 3. Environment configuration
cp .env.example .env
php artisan key:generate

# 4. Run database migrations & seed demo data
php artisan migrate --seed

# 5. Start the development server
php -S 127.0.0.1:8090 -t public
```

---

## 🔑 Demo Access Credentials

Once the server is running, visit **[http://127.0.0.1:8090](http://127.0.0.1:8090)**:

| Parameter | Value |
|---|---|
| **Login URL** | [http://127.0.0.1:8090/login](http://127.0.0.1:8090/login) |
| **Email** | `admin@admin.com` |
| **Password** | `password` |
| **Default Tenant Panel** | `/panel/keepada-demo/dashboard` |
| **Sample Public QR Passport** | `/e/HK-001` |

---

## ⚙️ Automated Task Engine & Cron Configuration

To enable automated periodic maintenance task generation and SLA deadline monitoring, add the standard Laravel cron entry to your server:

```bash
* * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1
```

### Dedicated Artisan Commands:
```bash
# Scan maintenance plans and generate scheduled work orders
php artisan keepada:generate-maintenance-tasks

# Send automated email notifications for overdue SLA tasks
php artisan app:send-overdue-notifications
```

---

## 🤝 Contributing

Contributions are warmly welcome! Please read our [CONTRIBUTING.md](CONTRIBUTING.md) guide and [SECURITY.md](SECURITY.md) policy before opening pull requests.

---

## 📄 License

KeepADA CMMS is open-source software licensed under the **[Apache License 2.0](LICENSE)**.

Copyright © 2026 **[ADA Creative Co.](https://adacreative.co)** - All rights reserved.
