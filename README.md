# Emberwick Hearth Co. — Laravel 13 + Filament 3 Fireplace ERP

Production-ready website, ERP, and AI toolkit for a Denver / Front Range fireplace installation SME. Public marketing site, Filament admin, FAQ-trained chatbot, content generators, and a seeded knowledge base.

## ✨ Features

- 🔥 Public landing page with hero, services, about, ERP preview, and contact
- 🧱 Service detail pages for gas, wood, electric, mantels, and venting
- 📚 Blog + knowledge base with homeowner guides and admin manuals
- 💬 Floating WhatsApp button + AI chatbot (OpenAI / Gemini / demo FAQ)
- 🧾 Full Filament ERP: customers, install jobs, inventory, invoices, payments, appointments
- 👥 Roles: Admin, Manager, Staff (Spatie Permission)
- 📊 Dashboard widgets with job charts and revenue stats
- 🤖 Admin AI assistants: blog, service copy, automation ideas, troubleshooting
- ⚙️ Company settings page and realistic demo seeders

## 🛠️ Tech Stack

- Laravel 13
- Filament 3
- Tailwind CSS + Livewire + Alpine.js
- Spatie Laravel Permission
- SQLite (demo) / MySQL (production)
- OpenAI PHP-compatible HTTP + Gemini fallback config

## 🚀 Installation

```bash
git clone https://github.com/imranbru99/fireplace-installer.git
cd fireplace-installer
composer install
cp .env.example .env
php artisan key:generate
touch database/database.sqlite
php artisan migrate --seed
npm install && npm run build
php artisan serve
```

Admin panel: `http://localhost:8000/admin`  
Login: `admin@example.com` / `password`

Optional AI keys in `.env`:

```
OPENAI_API_KEY=
OPENAI_MODEL=gpt-4o-mini
GEMINI_API_KEY=
GEMINI_MODEL=gemini-1.5-flash
```

Without keys, the chatbot and generators use fireplace FAQ demo responses.

## 📸 Screenshots / Visual Dashboard

![Emberwick fireplace living room](https://images.unsplash.com/photo-1616046229478-9901c5536a45?auto=format&fit=crop&w=1200&q=80)

![Custom mantel and hearth](https://images.unsplash.com/photo-1615874959471-d2fa0e57ae8a?auto=format&fit=crop&w=1200&q=80)

![Modern fireplace seating area](https://images.unsplash.com/photo-1631679706909-1844bbd07221?auto=format&fit=crop&w=1200&q=80)

## 🌐 Live Demo

Placeholder — deploy to your preferred host (Forge, Vapor, shared Laravel hosting) and update this section with the public URL.

## 🔍 SEO-optimized repo description

```
Emberwick Hearth Co. — Laravel 13 + Filament 3 fireplace installation website & ERP with AI chatbot, invoices, scheduling, and Denver demo data.
```

---

## 🤝 Let's Connect & Collaborate
I am open to Senior Remote Full-Stack Roles, AI Platform Architecture Contracts, and Enterprise Technical Advisory.
Timezone: UTC+6 (Dhaka / Rangpur, Bangladesh) — Flexible overlap with US, UK, and European business hours.
Delivery Mode: Async-ready, Slack, Discord, Jira, GitHub, and production-first accountability.

| Channel | Address / Handle | Quick Action |
|---------|------------------|--------------|
| 🌐 Primary Portfolio | imrandev.bd | Visit Site ↗ |
| 📦 Packagist Packages | packagist.org/packages/imrandevbd/ | View Packages ↗ |
| 💼 LinkedIn Profile | linkedin.com/in/imranbru99 | Connect ↗ |
| 🐙 GitHub Profile | github.com/imranbru99 | Follow ↗ |
| 💬 WhatsApp Direct | +880 1576-918420 | Chat Now ↗ |
| 📧 Direct Email | me@imrandev.bd | Send Email ↗ |
| 🐦 X (Twitter) | @imrandev_bd | Follow ↗ |
| 📺 YouTube Tech | @ImranDevBD | Subscribe ↗ |
