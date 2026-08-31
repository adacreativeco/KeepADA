<div align="center">

# 🛠️ KeepADA CMMS
### Industrielles Instandhaltungs- & Anlagenmanagementsystem der nächsten Generation

**Eine moderne, mandantenfähige Plattform für Instandhaltungsplanung, vorausschauende Wartung und Arbeitsauftragssteuerung auf Basis von Laravel 12 & Tailwind CSS.**

---

[![Lizenz: Apache 2.0](https://img.shields.io/badge/Lizenz-Apache%202.0-blue.svg?style=flat-square)](LICENSE)
[![Laravel Version](https://img.shields.io/badge/Laravel-12.x-FF2D20?style=flat-square&logo=laravel&logoColor=white)](https://laravel.com)
[![PHP Version](https://img.shields.io/badge/PHP-8.2%20%7C%208.3%20%7C%208.4-777BB4?style=flat-square&logo=php&logoColor=white)](https://php.net)
[![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-3.x-38B2AC?style=flat-square&logo=tailwind-css&logoColor=white)](https://tailwindcss.com)
[![CI Tests](https://img.shields.io/github/actions/workflow/status/adacreativeco/KeepADA/ci.yml?branch=main&label=CI%20Build&style=flat-square)](https://github.com/adacreativeco/KeepADA/actions)

<br/>

[ 🇩🇪 Deutsch ](README.de.md) &nbsp;•&nbsp; [ 🇬🇧 English ](README.md) &nbsp;•&nbsp; [ 🇹🇷 Türkçe ](README.tr.md)

</div>

---

<p align="center">
  <img src="docs/screenshots/dashboard.png" alt="KeepADA CMMS Haupt-Dashboard" width="100%" style="border-radius: 12px; box-shadow: 0 20px 40px rgba(0,0,0,0.4);" />
</p>

---

## ⚡ Warum KeepADA CMMS?

Herkömmliche Instandhaltungssysteme sind oft langsam, überladen und im Produktionsalltag schwer zu bedienen. **KeepADA CMMS** wurde von Grund auf für maximale Effizienz in industriellen Betrieben entwickelt:

- 🚀 **100% Maßgeschneiderte Architektur:** Keine trägen Administrationspakete. Pures, ultraschnelles Laravel 12 + Alpine.js + Tailwind CSS.
- 🏢 **Echte Mandantenfähigkeit (Multi-Tenancy):** Verwalten Sie mehrere Produktionsstandorte oder Betriebe unter isolierten URLs (`/panel/{company:slug}/...`).
- 🧠 **KI-gestützte vorausschauende Wartung (Predictive Maintenance):** Automatische Ausfallprognosen basierend auf Betriebsstunden, Zählerständen und Fehlerhistorie.
- 📷 **Integrierte QR-Workflows:** Live-Kamera-QR-Scanner + Öffentlicher Maschinenpass ohne Login (`/e/{code}`) + druckbare Industrie-Typenschilder.
- 📊 **Management-Kennzahlen:** Echtzeit-Berechnung von **MTTR** (Mean Time to Repair), **MTBF** (Mean Time Between Failures), SLA-Treue und Kostenanalysen.
- 🌍 **Dreisprachig:** Nahtloser Wechsel zwischen Deutsch 🇩🇪, Englisch 🇬🇧 und Türkisch 🇹🇷.

---

## 🧭 Systemmodule & Funktionsübersicht

### 1. ⚙️ Anlagen- & Maschinenlebenszyklus
- **Zentrales Anlagenregister:** Erfassung von Seriennummern, Marken, Modellen, Gewährleistungsfristen und Standorten.
- **Intelligente Betriebsstundenzähler:** Überwachung von Betriebsstunden, Zyklen oder Kilometern mit automatischen Wartungsschwellen.
- **Druckbare Thermo-Typenschilder:** Automatisch generierte QR-Etiketten, optimiert für Standard-Thermodrucker.

<p align="center">
  <img src="docs/screenshots/equipment_detail.png" alt="Anlage und vorausschauende Wartung" width="95%" />
</p>

---

### 2. 📋 Arbeitsaufträge & Instandhaltungsprozesse
- **Interaktives Kanban-Board & Daten-Tabelle:** Durchgängige Auftragsabwicklung über `Ausstehend`, `In Bearbeitung`, `Abgeschlossen` und `Storniert`.
- **SLA- & Termintreueüberwachung:** Visuelle Warnungen und Restzeitanzeigen bei Fristüberschreitungen.
- **Kosten- & Materialerfassung:** Arbeitszeitaufwand, Fremdleistungen und automatische Bestandsabbuchung verwendeter Ersatzteile.

<p align="center">
  <img src="docs/screenshots/tasks_kanban.png" alt="Arbeitsaufträge Kanban-Board" width="95%" />
</p>

---

### 3. 📊 Erweiterte Analytik, MTTR / MTBF & Kostenberichte
- **Zuverlässigkeitskennzahlen:** Automatische Berechnung von **MTTR** (mittlere Reparaturdauer in Stunden) und **MTBF** (störungsfreie Betriebszeit).
- **Kostenauswertungen:** Interaktive Chart.js Diagramme (Eigenleistung vs. Fremdleistung vs. Ersatzteilverbrauch).
- **Techniker-Leistungsübersicht:** Kennzahlen zur Termintreue und Auftragsabschlussquote.
- **CSV-Exportfunktion:** Schneller Download von Anlagen-, Auftrags- und Lagerbestandslisten für Excel.

<p align="center">
  <img src="docs/screenshots/reports_analytics.png" alt="Erweiterte Berichte und MTTR MTBF Analytik" width="95%" />
</p>

---

### 4. 🗓️ Interaktiver Wartungskalender
- **FullCalendar v6 Integration:** Monats-, Wochen- und Tagesansicht aller anstehenden Instandhaltungs- und Inspektionsaufträge.

<p align="center">
  <img src="docs/screenshots/calendar.png" alt="Wartungskalender" width="95%" />
</p>

---

### 5. 🌐 Öffentlicher QR-Maschinenpass (`/e/{code}`)
- Techniker oder Maschinenbediener können das Typenschild an der Maschine scannen, um ohne vorherige Anmeldung technische Daten einzusehen und Störungen direkt zu melden.

<p align="center">
  <img src="docs/screenshots/public_qr_passport.png" alt="Öffentlicher digitaler Maschinenpass" width="95%" />
</p>

---

## 🛠️ Technologie-Stack

| Ebene | Technologie |
|---|---|
| **Backend-Kern** | PHP 8.2+ / 8.3 / 8.4, Laravel 12.x |
| **Datenbank** | SQLite (Standard Dev), MySQL 8+, PostgreSQL |
| **Frontend UI** | Blade, Tailwind CSS, Alpine.js, Lucide Icons |
| **Diagramme & Kalender** | Chart.js, FullCalendar v6 |
| **QR & Scanning** | HTML5-QRCode, QR Server API |
| **Rollen & Sicherheit** | Spatie Laravel Permission, Custom Multi-Tenant Middleware |

---

## 🚀 Schnellstart & Installationsanleitung

### 1. Voraussetzungen
- **PHP** `>= 8.2` (Erweiterungen: `pdo`, `mbstring`, `openssl`, `tokenizer`, `xml`, `ctype`, `json`, `curl`, `fileinfo`)
- **Composer** `>= 2.2`
- **Node.js & NPM** (Optional)

### 2. Installationsschritte

```bash
# 1. Repository klonen
git clone https://github.com/adacreativeco/KeepADA.git
cd KeepADA

# 2. PHP-Abhängigkeiten installieren
composer install

# 3. Umgebungskonfiguration erstellen
cp .env.example .env
php artisan key:generate

# 4. Datenbank migrieren & Beispieldaten laden
php artisan migrate --seed

# 5. Entwicklungsserver starten
php -S 127.0.0.1:8090 -t public
```

---

## 🔑 Standard-Zugangsdaten (Demo)

Nach dem Starten des Servers unter **[http://127.0.0.1:8090](http://127.0.0.1:8090)**:

| Parameter | Wert |
|---|---|
| **Login-URL** | [http://127.0.0.1:8090/login](http://127.0.0.1:8090/login) |
| **E-Mail** | `admin@admin.com` |
| **Passwort** | `password` |
| **Standard-Mandanten-Dashboard** | `/panel/keepada-demo/dashboard` |
| **Beispiel-QR-Maschinenpass** | `/e/HK-001` |

---

## ⚙️ Cronjob-Einrichtung

Fügen Sie folgenden Cronjob auf Ihrem Server ein, um wiederkehrende Wartungsaufträge automatisch zu generieren:

```bash
* * * * * cd /pfad-zum-projekt && php artisan schedule:run >> /dev/null 2>&1
```

---

## 📄 Lizenz

Dieses Projekt ist unter der **[Apache License 2.0](LICENSE)** als Open-Source-Software lizenziert.

Copyright © 2026 **[ADA Creative Co.](https://adacreative.co)** - Alle Rechte vorbehalten.
