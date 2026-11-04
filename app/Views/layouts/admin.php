<?php
use App\Config\App;
use App\Helpers\Esc;
use App\Helpers\Auth;
use App\Helpers\Session;

$admin = Auth::admin();
$flashSuccess = Session::getFlash('admin_success');
$flashError = Session::getFlash('admin_error');
$currentUri = $_SERVER['REQUEST_URI'] ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= Esc::html($title ?? 'Admin Dashboard') ?> &mdash; Lymko E-commerce Control Panel</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter+Tight:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="<?= App::asset('css/admin.css') ?>">
</head>
<body class="admin-body">
  <!-- Admin Sidebar -->
  <aside class="admin-sidebar">
    <div class="admin-brand">
      <img src="<?= App::asset('images/nucelora-logo-cropped.png') ?>" alt="Nucelora" style="height:36px; width:auto; max-width:180px; filter:brightness(0) invert(1);">
      <span style="font-size:11px; background:rgba(255,255,255,0.15); padding:2px 6px; border-radius:4px;">Panel</span>
    </div>

    <nav class="admin-nav">
      <a href="<?= App::baseUrl('admin') ?>" class="<?= (str_ends_with($currentUri, '/admin') || str_ends_with($currentUri, '/admin/')) ? 'active' : '' ?>">
        <span>📊</span> Dashboard
      </a>
      <a href="<?= App::baseUrl('admin/orders') ?>" class="<?= str_contains($currentUri, '/admin/orders') ? 'active' : '' ?>">
        <span>📦</span> Orders
      </a>
      <a href="<?= App::baseUrl('admin/products') ?>" class="<?= str_contains($currentUri, '/admin/products') ? 'active' : '' ?>">
        <span>✨</span> Products
      </a>
      <a href="<?= App::baseUrl('admin/categories') ?>" class="<?= str_contains($currentUri, '/admin/categories') ? 'active' : '' ?>">
        <span>🏷️</span> Categories
      </a>
      <a href="<?= App::baseUrl('admin/inventory') ?>" class="<?= str_contains($currentUri, '/admin/inventory') ? 'active' : '' ?>">
        <span>📈</span> Inventory
      </a>
      <a href="<?= App::baseUrl('admin/customers') ?>" class="<?= str_contains($currentUri, '/admin/customers') ? 'active' : '' ?>">
        <span>👥</span> Customers
      </a>
      <a href="<?= App::baseUrl('admin/coupons') ?>" class="<?= str_contains($currentUri, '/admin/coupons') ? 'active' : '' ?>">
        <span>🎟️</span> Coupons
      </a>
      <a href="<?= App::baseUrl('admin/banners') ?>" class="<?= str_contains($currentUri, '/admin/banners') ? 'active' : '' ?>">
        <span>🖼️</span> Homepage Banners
      </a>
      <a href="<?= App::baseUrl('admin/cms') ?>" class="<?= str_contains($currentUri, '/admin/cms') ? 'active' : '' ?>">
        <span>📄</span> CMS Pages
      </a>
      <a href="<?= App::baseUrl('admin/reviews') ?>" class="<?= str_contains($currentUri, '/admin/reviews') ? 'active' : '' ?>">
        <span>⭐</span> Reviews
      </a>
      <a href="<?= App::baseUrl('admin/settings') ?>" class="<?= str_contains($currentUri, '/admin/settings') ? 'active' : '' ?>">
        <span>⚙️</span> Settings
      </a>
    </nav>

    <div style="padding:16px 20px; border-top:1px solid rgba(255,255,255,0.08); font-size:13px; color:var(--admin-sidebar-text);">
      <a href="<?= App::baseUrl() ?>" target="_blank" style="color:#fff; text-decoration:none; display:flex; align-items:center; gap:6px;">
        <span>🌐</span> View Live Website &rarr;
      </a>
    </div>
  </aside>

  <!-- Admin Main Area -->
  <div class="admin-main">
    <header class="admin-topbar">
      <div style="font-size:14px; font-weight:600; color:var(--admin-muted);">
        <?= Esc::html($breadcrumb ?? 'Control Panel') ?>
      </div>
      <div style="display:flex; align-items:center; gap:16px;">
        <span style="font-size:14px; font-weight:500;">
          <?= Esc::html($admin['name'] ?? 'Administrator') ?> (<?= Esc::html($admin['email'] ?? 'admin@lymko.in') ?>)
        </span>
        <a href="<?= App::baseUrl('admin/logout') ?>" class="btn-admin btn-admin-secondary" style="font-size:12px;">Sign Out</a>
      </div>
    </header>

    <main class="admin-content">
      <?php if ($flashSuccess): ?>
        <div style="background:#dcfce7; border:1px solid #86efac; color:#15803d; border-radius:6px; padding:12px 16px; margin-bottom:20px; font-size:14px;">
          <b>Success:</b> <?= Esc::html($flashSuccess) ?>
        </div>
      <?php endif; ?>

      <?php if ($flashError): ?>
        <div style="background:#fee2e2; border:1px solid #fca5a5; color:#b91c1c; border-radius:6px; padding:12px 16px; margin-bottom:20px; font-size:14px;">
          <b>Error:</b> <?= Esc::html($flashError) ?>
        </div>
      <?php endif; ?>

      <?= $content ?>
    </main>
  </div>
</body>
</html>
