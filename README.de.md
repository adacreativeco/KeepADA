# KeepADA CMMS 🛠️⚡

<div align="center">

**Intelligente Instandhaltungsplanung, Anlagenverwaltung & Vorausschauende Wartung**

[![Sprache: Deutsch](https://img.shields.io/badge/Sprache-Deutsch-yellow?style=for-the-badge)](README.de.md)
[![Sprache: English](https://img.shields.io/badge/Language-English-blue?style=for-the-badge)](README.md)
[![Sprache: Türkisch](https://img.shields.io/badge/Dil-T%C3%BCrk%C3%A7e-red?style=for-the-badge)](README.tr.md)

[![Laravel](https://img.shields.io/badge/Laravel-12.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.2%2B-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://php.net)
[![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white)](https://tailwindcss.com)
[![Lizenz: Apache 2.0](https://img.shields.io/badge/Lizenz-Apache_2.0-blue.svg?style=for-the-badge)](LICENSE)

[ 🇩🇪 Deutsch ](README.de.md) • [ 🇬🇧 English ](README.md) • [ 🇹🇷 Türkçe ](README.tr.md)

</div>

---

![KeepADA CMMS Dashboard](docs/screenshots/dashboard.png)

## 📌 Übersicht

**KeepADA CMMS** ist ein modernes, mandantenfähiges (Multi-Tenant) Instandhaltungs- und Anlagenmanagementsystem (CMMS) für Produktionsbetriebe, Industrieanlagen und technische Außendienste. Entwickelt auf Basis von **Laravel 12**, überzeugt KeepADA durch blitzschnelle Performance, ein ansprechendes dunkles Industrie-Design und maximale Zuverlässigkeit ohne überflüssige Abhängigkeiten.

---

## ✨ Hauptfunktionen

### 1. ⚙️ Anlagen- & Maschinenverwaltung (Asset Management)
- **Digitales Anlagenverzeichnis:** Vollständige Lebenszyklusverfolgung mit Marke, Modell, Seriennummer, Kategorie und Garantiefristen.
- **🧠 KI-basierte vorausschauende Wartung (Predictive Maintenance):** Ausfallprognose-Algorithmus zur Berechnung des nächsten optimalen Wartungszeitpunkts.
- **⏱️ Betriebsstundenzähler & Zählerstandserfassung:** Erfassung von Betriebsstunden, Kilometern oder Zyklen mit automatischer Schwellenwertüberwachung.
- **🏷️ Druckbare Industrie-Typenschilder (`print-label`):** Hochkontrast-QR-Etiketten für Thermodrucker zur physischen Kennzeichnung von Maschinen.

### 2. 📋 Arbeitsaufträge & Wartungsaufgaben
- **Kanban-Board & Tabellenansicht:** Effiziente Auftragsabwicklung (`Ausstehend` ➔ `In Bearbeitung` ➔ `Abgeschlossen` ➔ `Storniert`).
- **⏱️ SLA-Überwachung:** Echtzeitüberwachung von Reaktions- und Lösungszeiten zur Vermeidung von Ausfallzeiten.
- **💰 Detaillierte Kostenaufstellung:** Separate Erfassung von Arbeitskosten, Fremddienstleistungen und Materialverbrauch.
- **📦 Automatische Bestandsabbuchung:** Automatische Lagerbestandsanpassung bei Ersatzteilverwendung im Arbeitsauftrag.

### 3. 📷 Live-Kamera QR-Scanner & Digitaler Maschinenpass
- **Integrierter QR-Scanner:** Techniker können QR-Codes direkt per Smartphone- oder Webcam-Kamera erfassen.
- **🌐 Öffentlicher digitaler Maschinenpass (`/e/{code}`):** Schneller Abruf technischer Daten und Störungsmeldung ohne vorherige Anmeldung direkt vor Ort.

### 4. 📅 Automatisierte Wartungsplanung (Cron-Engine)
- **Zeit- & Zählerstandsbasierte Pläne:** Wiederkehrende Wartungszyklen (täglich, wöchentlich, monatlich, jährlich oder nach X Betriebsstunden).
- **🤖 Automatische Auftragserstellung:** Hintergrundbefehl (`php artisan keepada:generate-maintenance-tasks`) generiert fällige Arbeitsaufträge automatisch.
- **Manuelle Auslösung mit einem Klick:** Direkte Planüberprüfung und Auftragsgenerierung über das Dashboard.

### 5. 📊 Erweiterte Analytik, MTTR / MTBF & CSV-Export
- **MTTR (Mean Time to Repair):** Durchschnittliche Reparaturdauer in Stunden.
- **MTBF (Mean Time Between Failures):** Zuverlässigkeitsindex für unterbrechungsfreien Betrieb.
- **📈 Kostenanalyse:** Interaktive Chart.js Donut-Diagramme (Arbeitszeit vs. Dienstleistungen vs. Ersatzteile).
- **🏆 Techniker-Leistungsübersicht:** Kennzahlen zur Teameffizienz und Termintreue.
- **📥 CSV-Export für Excel:** Direkter Export von Anlagen-, Auftrags- und Bestandsdaten.

### 6. 🌍 Mehrsprachigkeit (i18n)
- Nahtloser Wechsel zwischen **Deutsch (DE)**, **Englisch (EN)** und **Türkisch (TR)**.

---

## 📸 Bildschirmfotos

| Anlage & KI-Ausfallprognose | Wartungskalender |
|:---:|:---:|
| ![Equipment](docs/screenshots/equipment_detail.png) | ![Calendar](docs/screenshots/calendar.png) |

| Öffentlicher QR-Maschinenpass | Sicherer Login-Bildschirm |
|:---:|:---:|
| ![QR Passport](docs/screenshots/public_qr_passport.png) | ![Login](docs/screenshots/login.png) |

---

## 🛠️ Technologie-Stack

- **Backend:** Laravel 12, PHP 8.2+
- **Datenbank:** SQLite / MySQL / PostgreSQL
- **Frontend:** Blade, Tailwind CSS, Alpine.js, Lucide Icons
- **Visualisierung:** Chart.js, FullCalendar v6
- **QR-Integration:** HTML5-QRCode, QR Server API
- **Rechte & Mandanten:** Spatie Laravel Permission & Custom Tenant Middleware

---

## 🚀 Schnellstart & Installation

### 1. Voraussetzungen
- PHP `>= 8.2` (mit `pdo`, `mbstring`, `openssl`, `tokenizer`, `xml`, `ctype`, `json`, `curl`)
- Composer
- Node.js & NPM (optional)

### 2. Installationsschritte
```bash
# Repository klonen
git clone https://github.com/adacreativeco/KeepADA.git
cd KeepADA

# PHP-Abhängigkeiten installieren
composer install

# Umgebungskonfiguration
cp .env.example .env
php artisan key:generate

# Datenbank migrieren & Beispieldaten laden
php artisan migrate --seed

# Entwicklungsserver starten
php -S 127.0.0.1:8090 -t public
```

### 3. Standard-Zugangsdaten (Demo)
- **Login-URL:** [http://127.0.0.1:8090/login](http://127.0.0.1:8090/login)
- **E-Mail:** `admin@admin.com`
- **Passwort:** `password`
- **Demo-Mandant:** `/panel/keepada-demo/dashboard`

---

## ⚙️ Cronjob-Einrichtung

Fügen Sie folgenden Cronjob auf Ihrem Server ein, um wiederkehrende Wartungsaufträge automatisch zu generieren:

```bash
* * * * * cd /pfad-zum-projekt && php artisan schedule:run >> /dev/null 2>&1
```

---

## 📄 Lizenz

Dieses Projekt ist unter der **Apache License 2.0** lizenziert. Weitere Details finden Sie in der Datei [LICENSE](LICENSE).

Copyright © 2026 [ADA Creative Co.](https://adacreative.co)
