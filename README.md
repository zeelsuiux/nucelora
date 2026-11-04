# Lymko E-Commerce: Production PHP 8.2+ Architecture & Admin Panel

A pixel-accurate recreation of [https://lymko.in/](https://lymko.in/) built with clean Core PHP 8.2+, MySQL / MariaDB (PDO), and vanilla JavaScript. Features a full customer storefront, interactive drawers, instant live search, routine quiz, end-to-end checkout with Razorpay and Cash on Delivery, and an independently developed administration panel.

---

## 1. Quick Localhost Setup (XAMPP)

1. **Place Project in XAMPP:**
   Ensure the project folder is placed in:
   `C:\xampp\htdocs\projects\lymko`

2. **Start Apache & MySQL:**
   - Open **XAMPP Control Panel**
   - Start **Apache** (Port 80)
   - Start **MySQL / MariaDB** (Port 3306)

3. **Import Database:**
   The schema and live seed data are located in `/database`:
   ```bash
   mysql -u root < database/schema.sql
   mysql -u root < database/seed.sql
   ```
   *Or import via phpMyAdmin: create `lymko_db` and import `database/schema.sql` then `database/seed.sql`.*

4. **Access the Website:**
   - **Frontend Store:** `http://localhost/projects/lymko/`
   - **Admin Control Panel:** `http://localhost/projects/lymko/admin/login`

---

## 2. Default Administrative Credentials

- **Admin Login URL:** `http://localhost/projects/lymko/admin/login`
- **Email:** `admin@lymko.in`
- **Password:** `admin123`
- **Role:** Super Administrator

---

## 3. Architecture & Directory Overview

```text
lymko/
├── app/
│   ├── Config/              # Database PDO & App URL auto-detection
│   ├── Controllers/         # Frontend MVC Controllers
│   │   ├── HomeController.php
│   │   ├── ShopController.php
│   │   ├── ProductController.php
│   │   ├── CartController.php
│   │   ├── CheckoutController.php
│   │   ├── AuthController.php
│   │   ├── AccountController.php
│   │   ├── PageController.php
│   │   ├── ApiController.php
│   │   └── Admin/           # 11 Dedicated Admin Modules
│   ├── Models/              # Relational models with PDO abstraction
│   ├── Middleware/          # Role and authentication guards
│   ├── Helpers/             # Escaper (XSS), Csrf, Session, Router, Format
│   └── Views/               # Semantic layouts, drawers, pages, admin panel
├── public/
│   ├── index.php            # Dedicated public webroot front controller
│   ├── assets/
│   │   ├── css/             # lymko.css, admin.css
│   │   ├── js/              # lymko-core.js, lymko-home.js, lymko-search.js
│   │   └── images/          # Official SVG brand logo and media
│   └── uploads/
├── database/
│   ├── schema.sql           # 32 normalized relational tables
│   └── seed.sql             # 27 scraped products, categories, reviews, CMS
├── routes/
│   └── web.php              # Centralized route definitions
├── index.php                # Root front controller with auto-routing
├── .htaccess                # Apache rewrite rules & security headers
└── README.md
```

---

## 4. Key Storefront Capabilities

- **Header & Announcement:** Rotating banner ticker, SVG logo vector, customer account link, wishlist counter, and cart drawer trigger with item badge.
- **Hero Spotlight Carousel:** Auto-rotating 4.8s slider with dynamic background color tints, touch swipe, active ingredient chips, and quick buy buttons.
- **Skin Concern Tabs:** 5 targeted skin concern panels (Acne, Pigmentation, Aging, Dryness, Glow) with animated transitions.
- **Four Steps Daily Routine:** Cleanse, Treat, Moisturize, Protect framework.
- **Curated Rituals Rail:** Horizontal scroll snap rail for bundle purchases.
- **Sliding Drawers:**
  - `#dcart`: Slide-in cart with line items, quantity steppers, free shipping indicator, and live subtotal.
  - `#dmenu`: Left slide-in mobile navigation.
  - `#dsearch`: Fullscreen instant live search modal querying MySQL.
- **Routine Finder Quiz:** Interactive consultation wizard delivering targeted product recommendations.
- **Checkout & Gateways:**
  - Online payment via Razorpay (UPI, GPay, PhonePe, Cards, NetBanking).
  - Cash on Delivery (COD) with automatic stock deduction.
- **Customer Portal:** Registration, login, profile dashboard, order status history, and receipt details.

---

## 5. Administrative Modules (`/admin/`)

1. **Dashboard:** Live revenue metrics, today's sales, pending fulfillment counters, low-stock alerts, and recent orders.
2. **Product Catalog:** Add, edit, archive products, set sale prices, manage variants, upload images, and toggle visibility.
3. **Category Management:** Manage category slugs, banners, and navigational hierarchy.
4. **Order Management:** Lifecycle status pipeline (Pending &rarr; Confirmed &rarr; Processing &rarr; Shipped &rarr; Delivered &rarr; Cancelled), printable invoices, and shipment tracking.
5. **Inventory Control:** SKU-wise stock tracking and quick quantity adjustment.
6. **Customer Management:** Customer profile details and order records.
7. **Coupon Manager:** Flat and percentage discount codes with minimum order constraints.
8. **Homepage Banners:** Manage spotlight carousel slides without editing code.
9. **CMS Pages:** Rich text / HTML page editor for About Us, Shipping, Returns, Privacy, Terms, and Ingredients.
10. **Review Moderation:** Approve, hide, or delete customer reviews.
11. **Settings:** Razorpay test/live API credentials, helpline phone, support email, and free shipping threshold.

---

## 6. Hostinger Shared Hosting Deployment

1. Compress the project folder into `lymko.zip` (exclude scratch files).
2. Upload and extract to `public_html` via Hostinger File Manager.
3. In Hostinger **MySQL Databases**, create a new database (e.g. `u123456_lymko`) and user.
4. Import `database/schema.sql` and `database/seed.sql` using phpMyAdmin.
5. Update `app/Config/Database.php` or set environment variables:
   ```php
   $host = 'localhost';
   $dbname = 'u123456_lymko';
   $user = 'u123456_admin';
   $pass = 'your_hostinger_db_password';
   ```
6. The application will automatically detect your domain and route all requests cleanly with SSL.
