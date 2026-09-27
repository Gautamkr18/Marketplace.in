# 🛒 Marketplace Web Application

[![Live Demo](https://img.shields.io/badge/Live%20Demo-Railway-0B0D0E?style=for-the-badge&logo=railway&logoColor=white)](https://marketplacein-production.up.railway.app)
[![Laravel](https://img.shields.io/badge/Laravel-12-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)](https://laravel.com)
[![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-v4-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white)](https://tailwindcss.com)

A modern, fast, and responsive classifieds marketplace web application built with **Laravel 12**, **MySQL**, and **Tailwind CSS**.

🔗 **Live Deployment:** [https://marketplacein-production.up.railway.app](https://marketplacein-production.up.railway.app)
  

  **DEMO VIDEO:** [https://drive.google.com/file/d/1hPRGuqO3L_4cEE39HrvTGIGiGUXCFLxP/view?usp=drive_link]
---

## ✨ Features

- 🔍 **Browse & Filter Listings**: Filter ads by category, subcategory, city, price range, and item condition.
- ⚡ **Live Search Suggestions**: Instant AJAX autocomplete for quick ad discovery.
- 👤 **User Authentication**: Secure user registration, login, and session management.
- 📝 **Ad Management**:
  - Post classified ads with image upload, location, pricing, condition, and category.
  - Manage personal ads via "My Listings" (view status, edit, update, delete).
- 🏷️ **Hierarchical Categories**: Multi-level categories and subcategories.
- 📱 **Modern & Responsive UI**: Clean, mobile-friendly interface styled with Tailwind CSS.

---

## 🛠️ Tech Stack

- **Framework:** [Laravel 12](https://laravel.com/)
- **Language:** PHP 8.2+
- **Frontend:** Blade Templates, [Tailwind CSS v4](https://tailwindcss.com/), [Vite](https://vitejs.dev/)
- **Database:** SQLite (default) / MySQL

---

## 🚀 Getting Started

### Prerequisites

Ensure you have the following installed on your machine:
- PHP >= 8.2 (with SQLite / PDO extensions)
- [Composer](https://getcomposer.org/)
- [Node.js](https://nodejs.org/) (v18+) & npm

### Installation & Setup

1. **Clone the repository:**
   ```bash
   git clone https://github.com/<your-username>/<repo-name>.git
   cd marketplace-app
   ```

2. **Install dependencies:**
   ```bash
   composer install
   npm install
   ```

3. **Configure Environment:**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Prepare Database & Storage:**
   ```bash
   # For SQLite (default):
   touch database/database.sqlite

   # Run migrations and seed sample data
   php artisan migrate --seed

   # Create symlink for uploaded images
   php artisan storage:link
   ```

5. **Start Development Server:**
   ```bash
   # Option A: Run concurrently (server + vite + queue)
   composer run dev

   # Option B: Run separately
   php artisan serve
   npm run dev
   ```

6. **Access Application:**
   Open [http://localhost:8000](http://localhost:8000) in your browser.

---

## 📂 Project Structure

```
marketplace-app/
├── app/
│   ├── Http/Controllers/   # Application controllers (Auth, Listing, Page)
│   ├── Models/             # Eloquent Models (User, Listing, Category, Subcategory)
├── database/
│   ├── migrations/         # Database schema migrations
│   └── seeders/            # Sample categories, users, and listings
├── resources/
│   ├── css/                # Tailwind styles
│   ├── js/                 # Frontend JavaScript & AJAX scripts
│   └── views/              # Blade templates (layouts, listings, categories, auth)
├── routes/
│   └── web.php             # Web routes definition
└── public/                 # Entry point & static assets
```

---

## 📄 License

This project is open-source and available under the [MIT License](LICENSE).

