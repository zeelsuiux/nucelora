<?php
use App\Config\App;
use App\Helpers\Esc;
use App\Helpers\Auth;
use App\Models\Cart;
use App\Helpers\Session;

Session::start();
$cartTotals = Cart::getTotals(Cart::getOrCreate()['id']);
$cartCount = $cartTotals['item_count'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
  <title><?= Esc::html($meta_title ?? 'Nucelora Skincare — Botanical Intelligence for Visible Skin Health') ?></title>
  <meta name="description" content="<?= Esc::attr($meta_description ?? 'Shop Nucelora bio-active skincare products online: 20% Vitamin C, 10% Niacinamide & Retinol serums, barrier repair moisturizers and broad spectrum sunscreen. Free shipping across India.') ?>">
  <link rel="canonical" href="<?= Esc::attr($canonical_url ?? App::baseUrl()) ?>">
  
  <!-- Preconnect and Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Instrument+Serif:ital@0;1&family=Inter+Tight:wght@300;400;500;600;700&family=Poppins:wght@500;600&display=swap" rel="stylesheet">

  <!-- Core Stylesheets -->
  <link rel="stylesheet" href="<?= App::asset('css/lymko.css') ?>">
  <link rel="stylesheet" href="<?= App::asset('css/lymko-patch.css') ?>">
  <link rel="stylesheet" href="<?= App::asset('css/lymko-v5-fixes.css') ?>">
  <link rel="stylesheet" href="<?= App::asset('css/lymko-ios-fixes.css') ?>">

  <script>
    window.LYMKO = {
      routes: {
        root: '<?= App::baseUrl() ?>',
        cart: '<?= App::baseUrl('cart/json') ?>',
        cartAdd: '<?= App::baseUrl('cart/add') ?>',
        cartChange: '<?= App::baseUrl('cart/change') ?>',
        search: '<?= App::baseUrl('search') ?>',
        predictive: '<?= App::baseUrl('api/search') ?>'
      },
      moneyFormat: "Rs. {{amount_no_decimals}}",
      maxQty: 20
    };
  </script>
</head>
<body class="lymko-theme">
  <!-- Announcement Auto-Scrolling Marquee Bar -->
  <div class="ann" role="region" aria-label="Announcements">
    <div class="ann-t">
      <span><b>Free shipping</b> on every order across India</span>
      <span><a href="<?= App::baseUrl('collections/rituals') ?>"><b>Curated rituals</b> — your whole routine in one bag</a></span>
      <span><b>Clean by design</b> — paraben, sulphate &amp; cruelty free</span>
      <span><a href="<?= App::baseUrl('pages/routine-finder') ?>"><b>Find your routine</b> in a few taps</a></span>
      <span><b>Korean-inspired</b> formulas for every skin type</span>
      <span><em>Good skin, better you.</em></span>
      
      <!-- Infinite loop duplicate items -->
      <span aria-hidden="true"><b>Free shipping</b> on every order across India</span>
      <span aria-hidden="true"><a href="<?= App::baseUrl('collections/rituals') ?>" tabindex="-1"><b>Curated rituals</b> — your whole routine in one bag</a></span>
      <span aria-hidden="true"><b>Clean by design</b> — paraben, sulphate &amp; cruelty free</span>
      <span aria-hidden="true"><a href="<?= App::baseUrl('pages/routine-finder') ?>" tabindex="-1"><b>Find your routine</b> in a few taps</a></span>
      <span aria-hidden="true"><b>Korean-inspired</b> formulas for every skin type</span>
      <span aria-hidden="true"><em>Good skin, better you.</em></span>
    </div>
  </div>

  <!-- Header -->
  <header id="hdr">
    <div class="w nav">
      <button type="button" class="ib m-only" data-open="menu" aria-label="Open menu" aria-controls="dmenu">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><path d="M4 8h16M4 16h11"/></svg>
      </button>

      <nav id="mainnav" aria-label="Main">
        <a href="<?= App::baseUrl('collections/all') ?>">Shop</a>
        <a href="<?= App::baseUrl('collections/face-serums') ?>">Serums</a>
        <a href="<?= App::baseUrl('collections/rituals') ?>">Rituals</a>
        <a href="<?= App::baseUrl('pages/routine-finder') ?>">Routine finder</a>
        <a href="<?= App::baseUrl('pages/skincare-guide') ?>">Journal</a>
      </nav>

      <a href="<?= App::baseUrl() ?>" class="logo" aria-label="Nucelora home">
        <img src="<?= App::asset('images/nucelora-logo-cropped.png') ?>" class="lk-logo" alt="Nucelora Logo" style="height: 52px; width: auto; max-width: 240px; object-fit: contain;">
      </a>

      <div class="tools">
        <button type="button" class="ib d-only" data-open="search" aria-label="Search">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><circle cx="11" cy="11" r="7"/><path d="m20 20-3.5-3.5"/></svg>
        </button>

        <a href="<?= Auth::check() ? App::baseUrl('account') : App::baseUrl('account/login') ?>" class="ib d-only" aria-label="Account">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><circle cx="12" cy="8" r="4"/><path d="M4 21c1.5-4 4.5-6 8-6s6.5 2 8 6"/></svg>
        </a>

        <a href="<?= App::baseUrl('pages/wishlist') ?>" class="ib d-only" aria-label="Wishlist">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true"><path d="M12 20s-7.5-4.6-9.2-9.3C1.6 7.2 4 4 7.3 4c2 0 3.6 1.1 4.7 2.7C13.1 5.1 14.7 4 16.7 4 20 4 22.4 7.2 21.2 10.7 19.5 15.4 12 20 12 20Z"/></svg>
          <span class="cnt" data-wc>0</span>
        </a>

        <button type="button" class="ib" data-open="cart" aria-label="Open bag, <?= $cartCount ?> items">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><path d="M5 8h14l-1.2 11.2a2 2 0 0 1-2 1.8H8.2a2 2 0 0 1-2-1.8L5 8Z"/><path d="M9 8V6a3 3 0 0 1 6 0v2"/></svg>
          <span class="cnt" data-cc><?= $cartCount ?></span>
        </button>
      </div>
    </div>
  </header>

  <!-- Main Content Slot -->
  <main id="MainContent" tabindex="-1">
    <?= $content ?>
  </main>

  <!-- Trust & Value Props Bar -->
  <section class="nucelora-trust-bar">
    <div class="w">
      <div class="nucelora-trust-grid">
        <div class="nucelora-trust-item">
          <div class="nucelora-trust-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" style="width:22px; height:22px;"><rect x="1" y="3" width="15" height="13" rx="2"/><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/></svg>
          </div>
          <div>
            <b>Free Delivery Across India</b>
            <span>Express doorstep delivery on all orders</span>
          </div>
        </div>
        <div class="nucelora-trust-item">
          <div class="nucelora-trust-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" style="width:22px; height:22px;"><path d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10z"/><path d="m9 12 2 2 4-4"/></svg>
          </div>
          <div>
            <b>100% Clean &amp; Cruelty-Free</b>
            <span>No parabens, sulphates, or toxins</span>
          </div>
        </div>
        <div class="nucelora-trust-item">
          <div class="nucelora-trust-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" style="width:22px; height:22px;"><path d="M10 2v7.5L4.5 20a1 1 0 0 0 .9 1.5h13.2a1 1 0 0 0 .9-1.5L14 9.5V2"/><path d="M8.5 2h7"/></svg>
          </div>
          <div>
            <b>Dermatologically Tested</b>
            <span>Clinically tested for Indian skin types</span>
          </div>
        </div>
        <div class="nucelora-trust-item">
          <div class="nucelora-trust-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" style="width:22px; height:22px;"><rect x="2" y="5" width="20" height="14" rx="2"/><line x1="2" y1="10" x2="22" y2="10"/></svg>
          </div>
          <div>
            <b>COD &amp; Instant UPI</b>
            <span>Safe payments &middot; Cash on Delivery available</span>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Newsletter Bar -->
  <section class="nucelora-newsletter">
    <div class="w" style="max-width: 680px; text-align: center;">
      <span class="lab o" style="background: var(--orsoft); color: var(--or); padding: 5px 14px; border-radius: 99px; font-size: 12px; font-weight: 700; letter-spacing: 0.08em; text-transform: uppercase;">Join our inner circle</span>
      <h2 style="font-size: 28px; font-weight: 700; margin: 14px 0 8px; color: var(--ink);">Exclusive skincare offers, first.</h2>
      <p style="margin: 0 0 24px; color: var(--muted); font-size: 15px; line-height: 1.5;">Subscribe for science-backed skin tips, seasonal routine drops, and 10% off your first order.</p>
      <form action="<?= App::baseUrl('api/newsletter') ?>" method="POST" style="display: flex; gap: 10px; justify-content: center; max-width: 460px; margin: 0 auto; flex-wrap: wrap;">
        <input type="email" name="email" placeholder="Enter your email address" required style="flex: 1; min-width: 220px; height: 48px; padding: 0 16px; border: 1px solid var(--line); border-radius: 99px; font-family: var(--sans); font-size: 14.5px; outline: none; background: #faf9f6;">
        <button type="submit" class="btn btn-k" style="height: 48px; padding: 0 24px; border-radius: 99px; white-space: nowrap; font-size: 14px; font-weight: 600; cursor: pointer;">Subscribe</button>
      </form>
    </div>
  </section>

  <!-- Luxury Nucelora Main Footer -->
  <footer class="nucelora-footer">
    <div class="w">
      <div class="nucelora-footer-grid">
        
        <!-- Brand Info & Mission -->
        <div class="nucelora-footer-brand">
          <a href="<?= App::baseUrl() ?>" aria-label="Nucelora Home">
            <img src="<?= App::asset('images/nucelora-logo-cropped.png') ?>" class="lk-logo" alt="Nucelora Skincare">
          </a>
          <p>
            Botanical intelligence meets cellular science. Crafted for visible glow, barrier restoration, and lasting skin confidence. 100% cruelty-free and dermatologically tested.
          </p>
          <div class="nucelora-socials">
            <a href="https://instagram.com" target="_blank" rel="noopener" aria-label="Instagram">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:18px;height:18px;"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/></svg>
            </a>
            <a href="https://facebook.com" target="_blank" rel="noopener" aria-label="Facebook">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:18px;height:18px;"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/></svg>
            </a>
            <a href="https://wa.me/918866611621" target="_blank" rel="noopener" aria-label="WhatsApp">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:18px;height:18px;"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/></svg>
            </a>
          </div>
        </div>

        <!-- Shop Formulations -->
        <div class="nucelora-fcol">
          <h4>Shop Formulations</h4>
          <ul>
            <li><a href="<?= App::baseUrl('collections/all') ?>">All Products</a></li>
            <li><a href="<?= App::baseUrl('collections/best-selling') ?>">Best Sellers</a></li>
            <li><a href="<?= App::baseUrl('collections/face-serums') ?>">Face Serums</a></li>
            <li><a href="<?= App::baseUrl('collections/face-wash') ?>">Cleansers &amp; Face Wash</a></li>
            <li><a href="<?= App::baseUrl('collections/moisturizer') ?>">Barrier Moisturizers</a></li>
            <li><a href="<?= App::baseUrl('collections/sunscreen') ?>">Sun Protection SPF 50+</a></li>
            <li><a href="<?= App::baseUrl('collections/hair-care') ?>">Hair Care Rituals</a></li>
            <li><a href="<?= App::baseUrl('collections/rituals') ?>">Curated Daily Rituals</a></li>
          </ul>
        </div>

        <!-- Skin Science & Discovery -->
        <div class="nucelora-fcol">
          <h4>Skin Science</h4>
          <ul>
            <li><a href="<?= App::baseUrl('pages/routine-finder') ?>">AI Routine Finder</a></li>
            <li><a href="<?= App::baseUrl('pages/about-us') ?>">Our Philosophy</a></li>
            <li><a href="<?= App::baseUrl('pages/ingredients') ?>">Active Ingredients Glossary</a></li>
            <li><a href="<?= App::baseUrl('pages/skincare-guide') ?>">Skincare Journal</a></li>
            <li><a href="<?= App::baseUrl('pages/sustainability') ?>">Clean Beauty Standards</a></li>
            <li><a href="<?= App::baseUrl('pages/faq') ?>">Frequently Asked Questions</a></li>
            <li><a href="<?= App::baseUrl('account/login') ?>">Customer Account Sign In</a></li>
          </ul>
        </div>

        <!-- Customer Support & Policies -->
        <div class="nucelora-fcol">
          <h4>Customer Care</h4>
          <div class="nucelora-fcontact-item">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
            <div>
              <a href="tel:+918866611621" style="font-weight:600; color:var(--ink);">+91 88666 11621</a>
              <div style="font-size:12px; color:var(--muted);">Mon - Sat: 10:00 AM - 7:00 PM</div>
            </div>
          </div>
          <div class="nucelora-fcontact-item">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
            <div>
              <a href="mailto:care@nucelora.com" style="font-weight:600; color:var(--or);">care@nucelora.com</a>
              <div style="font-size:12px; color:var(--muted);">Dedicated email support</div>
            </div>
          </div>
          <ul style="margin-top:14px; border-top:1px solid #eae5dc; padding-top:12px;">
            <li><a href="<?= App::baseUrl('pages/shipping') ?>">Shipping &amp; Delivery Policy</a></li>
            <li><a href="<?= App::baseUrl('pages/returns') ?>">Returns, Exchanges &amp; Refunds</a></li>
            <li><a href="<?= App::baseUrl('pages/privacy') ?>">Privacy Policy</a></li>
            <li><a href="<?= App::baseUrl('pages/terms') ?>">Terms &amp; Conditions</a></li>
            <li><a href="<?= App::baseUrl('pages/contact') ?>">Contact Help Desk</a></li>
          </ul>
        </div>

      </div>

      <!-- Legal & Payments Bar -->
      <div class="nucelora-footer-bottom">
        <div>
          &copy; <?= date('Y') ?> <b>Nucelora Skincare India</b>. All rights reserved. &middot; Crafted for visible skin health.
        </div>
        <div class="nucelora-payments-rail">
          <span class="nucelora-pay-badge">UPI &middot; GPay &middot; PhonePe</span>
          <span class="nucelora-pay-badge">Cash on Delivery</span>
          <span class="nucelora-pay-badge">Visa &middot; Mastercard &middot; RuPay</span>
          <span class="nucelora-pay-badge">NetBanking</span>
          <span class="nucelora-pay-badge" style="display:inline-flex; align-items:center; gap:5px;"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:12px; height:12px;"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg> 256-bit SSL Secured</span>
        </div>
      </div>
    </div>
  </footer>

  <!-- Slide-in Cart Drawer (#dcart) -->
  <aside class="drawer" id="dcart" role="dialog" aria-modal="true" aria-label="Your bag" aria-hidden="true">
    <div class="dr-h">
      <h2>Your bag<sup data-cc2><?= $cartCount ?></sup></h2>
      <button type="button" class="ib" data-close aria-label="Close bag">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true"><path d="M6 6l12 12M18 6 6 18"/></svg>
      </button>
    </div>
    <div id="dcartin" style="display:flex; flex-direction:column; flex:1; min-height:0;">
      <!-- Dynamic cart drawer content loaded by Lymko.renderCart() -->
      <div class="dr-b">
        <div class="empty" style="padding:60px 0; text-align:center;">
          <h3 class="h3">Your bag is empty.</h3>
          <p style="margin-top:10px; color:var(--muted);">Let's find something your skin will love.</p>
          <div class="oact" style="margin-top:24px; display:flex; gap:10px; justify-content:center;">
            <a href="<?= App::baseUrl('collections/all') ?>" class="btn btn-k sm" data-close>Start shopping</a>
            <a href="<?= App::baseUrl('pages/routine-finder') ?>" class="btn btn-l sm" data-close>Find my routine</a>
          </div>
        </div>
      </div>
    </div>
  </aside>

  <!-- Left Slide-in Navigation Drawer (#dmenu) -->
  <aside class="drawer left" id="dmenu" role="dialog" aria-modal="true" aria-label="Menu" aria-hidden="true">
    <div class="dr-h">
      <a href="<?= App::baseUrl() ?>" class="logo" aria-label="Nucelora home">
        <img src="<?= App::asset('images/nucelora-logo-cropped.png') ?>" class="lk-logo" alt="Nucelora Logo" style="height:46px; width:auto; max-width:200px; object-fit: contain;">
      </a>
      <button type="button" class="ib" data-close aria-label="Close menu">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true"><path d="M6 6l12 12M18 6 6 18"/></svg>
      </button>
    </div>
    <div class="dr-b" style="padding:24px;">
      <nav class="mnav" style="display:flex; flex-direction:column; gap:18px; font-size:18px; font-weight:500;">
        <a href="<?= App::baseUrl('collections/all') ?>">Shop All</a>
        <a href="<?= App::baseUrl('collections/best-selling') ?>">Best Sellers</a>
        <a href="<?= App::baseUrl('collections/face-serums') ?>">Face Serums</a>
        <a href="<?= App::baseUrl('collections/rituals') ?>">Rituals & Bundles</a>
        <a href="<?= App::baseUrl('collections/face-wash') ?>">Face Wash</a>
        <a href="<?= App::baseUrl('collections/moisturizer') ?>">Moisturizers</a>
        <a href="<?= App::baseUrl('collections/sunscreen') ?>">Sunscreen</a>
        <a href="<?= App::baseUrl('collections/hair-care') ?>">Hair Care</a>
        <a href="<?= App::baseUrl('pages/routine-finder') ?>" style="color:var(--or);">Routine Finder &rarr;</a>
        <a href="<?= App::baseUrl('pages/skincare-guide') ?>">Skincare Journal</a>
      </nav>
      <div style="margin-top:36px; padding-top:24px; border-top:1px solid var(--line); display:flex; flex-direction:column; gap:12px; font-size:14px;">
        <a href="<?= Auth::check() ? App::baseUrl('account') : App::baseUrl('account/login') ?>">
          <?= Auth::check() ? 'My Account (' . Esc::html(Auth::user()['first_name']) . ')' : 'Customer Sign In' ?>
        </a>
        <a href="<?= App::baseUrl('pages/wishlist') ?>">My Wishlist (<span data-wc>0</span>)</a>
        <a href="<?= App::baseUrl('pages/shipping') ?>">Free Shipping Across India</a>
        <a href="<?= App::baseUrl('pages/contact') ?>">Helpline: +91 88666 11621</a>
      </div>
    </div>
  </aside>

  <!-- Search Modal Overlay (#dsearch) -->
  <div class="sov" id="dsearch" role="dialog" aria-modal="true" aria-label="Search" aria-hidden="true">
    <div class="w" style="max-width:800px; padding-top:40px;">
      <div class="top" style="display:flex; justify-content:space-between; align-items:center; margin-bottom:24px;">
        <a href="<?= App::baseUrl() ?>" class="logo"><img src="<?= App::asset('images/nucelora-logo-cropped.png') ?>" style="height:44px; width:auto; max-width:200px; object-fit:contain;" alt="Nucelora"></a>
        <button type="button" class="ib" data-close aria-label="Close search"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M6 6l12 12M18 6 6 18"/></svg></button>
      </div>
      <form action="<?= App::baseUrl('search') ?>" method="GET" class="sin" style="position:relative; margin-bottom:20px;">
        <input type="search" name="q" id="oq" placeholder="Search by skin concern, serum, SPF, or routine..." autofocus autocomplete="off" style="width:100%; height:56px; padding:0 24px; font-size:17px; border:1px solid var(--line); border-radius:99px; font-family:var(--sans); outline:none; background:#fff; box-shadow:0 2px 10px rgba(0,0,0,0.03);">
        <button type="submit" style="position:absolute; right:12px; top:8px; height:40px; padding:0 20px; border-radius:99px; background:var(--or); color:#fff; border:none; font-weight:600; font-size:13px; cursor:pointer;">Search</button>
      </form>
      <div id="ores" style="max-height:60vh; overflow-y:auto; padding-bottom:20px;">
        <!-- Live search results rendered dynamically -->
      </div>
    </div>
  </div>

  <div class="scrim" id="scrim" data-close></div>
  <div id="toast" role="status" aria-live="polite"></div>

  <!-- Floating WhatsApp Assistance Button -->
  <a href="https://wa.me/918866611621?text=Hello%20Nucelora!%20I%20need%20help%20with%20my%20skincare%20ritual." target="_blank" rel="noopener" class="nucelora-wa-float" aria-label="Chat with Nucelora Skincare on WhatsApp">
    <svg viewBox="0 0 24 24" fill="currentColor" style="width:26px; height:26px;"><path d="M12.04 2c-5.46 0-9.91 4.45-9.91 9.91 0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38c1.45.79 3.08 1.21 4.74 1.21 5.46 0 9.91-4.45 9.91-9.91 0-2.65-1.03-5.14-2.9-7.01A9.816 9.816 0 0 0 12.04 2m.01 1.67c2.2 0 4.26.86 5.82 2.42a8.225 8.225 0 0 1 2.41 5.83c0 4.54-3.7 8.24-8.24 8.24-1.48 0-2.93-.4-4.2-1.15l-.3-.18-3.12.82.83-3.04-.2-.31a8.196 8.196 0 0 1-1.26-4.38c0-4.54 3.7-8.24 8.24-8.24m4.52 11.66c-.25-.13-1.47-.72-1.7-.81-.23-.08-.39-.13-.56.13-.17.25-.64.81-.79.97-.14.17-.29.19-.54.06-.25-.13-1.06-.39-2.01-1.24-.74-.66-1.24-1.48-1.39-1.73-.14-.25-.02-.39.11-.51.11-.11.25-.29.37-.43.13-.15.17-.25.25-.42.08-.17.04-.31-.02-.44-.06-.13-.56-1.34-.76-1.84-.2-.48-.4-.42-.56-.43h-.48c-.17 0-.44.06-.67.31-.23.25-.88.86-.88 2.1 0 1.24.9 2.44 1.03 2.61.13.17 1.77 2.7 4.29 3.79.6.26 1.07.41 1.43.53.6.19 1.15.16 1.58.1.48-.07 1.47-.6 1.68-1.18.21-.58.21-1.07.15-1.18-.06-.11-.23-.18-.48-.3"/></svg>
    <span class="nucelora-wa-tooltip">Skin Consultation &amp; Help</span>
  </a>

  <!-- Client Application Scripts -->
  <script src="<?= App::asset('js/lymko-core.js') ?>"></script>
  <script src="<?= App::asset('js/lymko-search.js') ?>"></script>
  <script src="<?= App::asset('js/lymko-home.js') ?>" defer></script>
  <script src="<?= App::asset('js/lymko-v5-fixes.js') ?>" defer></script>
  <script src="<?= App::asset('js/nucelora-cart.js') ?>" defer></script>
</body>
</html>
