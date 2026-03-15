# 🇸🇳 DocuSen — Plateforme de gestion des documents administratifs

[![Laravel](https://img.shields.io/badge/Laravel-11-red?style=flat-square&logo=laravel)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.3-blue?style=flat-square&logo=php)](https://php.net)
[![TailwindCSS](https://img.shields.io/badge/TailwindCSS-3-38bdf8?style=flat-square&logo=tailwindcss)](https://tailwindcss.com)
[![MySQL](https://img.shields.io/badge/MySQL-8-orange?style=flat-square&logo=mysql)](https://mysql.com)

> Plateforme web permettant aux citoyens sénégalais de soumettre et suivre leurs demandes de documents administratifs en ligne.

---

## ✨ Fonctionnalités

### 👤 Espace Citoyen
- Inscription / Connexion / Réinitialisation mot de passe
- Soumettre une demande de document avec pièces justificatives
- Suivre le statut en temps réel (en attente, en traitement, approuvé, rejeté)
- Recevoir des notifications email à chaque changement de statut
- Historique complet des demandes

### 🛡️ Espace Admin
- Dashboard avec statistiques et graphiques Chart.js
- Traiter les demandes (approuver / rejeter / mettre en traitement)
- Gérer les types de documents
- Filtrer et rechercher les demandes

---

## 🛠️ Stack technique

| Technologie | Usage |
|-------------|-------|
| Laravel 11 | Framework PHP backend |
| PHP 8.3 | Langage backend |
| Tailwind CSS | Framework CSS |
| MySQL | Base de données |
| Chart.js | Graphiques dashboard |
| Alpine.js | Interactions UI |
| Twilio | Notifications SMS |
| SMTP Gmail | Notifications Email |

---

## 🚀 Installation

### Prérequis
- PHP 8.3+
- Composer
- Node.js & NPM
- MySQL

### Étapes
```bash
# 1. Cloner le projet
git clone https://github.com/papembaye25/docusen.git
cd docusen

# 2. Installer les dépendances PHP
composer install

# 3. Installer les dépendances JS
npm install && npm run build

# 4. Configurer l'environnement
cp .env.example .env
php artisan key:generate

# 5. Configurer la base de données dans .env
DB_DATABASE=docusen
DB_USERNAME=root
DB_PASSWORD=

# 6. Lancer les migrations et seeders
php artisan migrate --seed

# 7. Lier le storage
php artisan storage:link
```

---

## 👥 Comptes de démonstration

| Rôle | Email | Mot de passe |
|------|-------|--------------|
| Super Admin | superadmin@docusen.sn | SuperAdmin@2026 |
| Admin | admin@docusen.sn | Admin@2026 |
| Citoyen | citoyen@test.sn | Citoyen@2026 |

---

## 📸 Captures d'écran

> Screenshots à venir

---

## 👨‍💻 Auteur

**Pape Mbaye** — Développeur Web Full Stack
- GitHub : [@papembaye25](https://github.com/papembaye25)
- LinkedIn : [Pape Mbaye Gaye](https://linkedin.com/in/papembaye)

---

## 📄 Licence

Ce projet est sous licence MIT.