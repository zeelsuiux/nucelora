<?php
use App\Config\App;
use App\Helpers\Esc;
use App\Helpers\Format;
?>

<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:24px;">
  <div>
    <h1 style="font-size:24px; font-weight:700; margin-bottom:4px;">Product Catalog Management</h1>
    <p style="font-size:14px; color:var(--admin-muted);">Manage prices, stock levels, variants, and visibility</p>
  </div>
  <a href="<?= App::baseUrl('admin/products/create') ?>" class="btn-admin btn-admin-primary">
    + Add New Product
  </a>
</div>

<div class="admin-card">
  <table class="admin-table">
    <thead>
      <tr>
        <th style="width:60px;">Image</th>
        <th>Product Title &amp; SKU</th>
        <th>Category</th>
        <th>Price / MRP</th>
        <th>Stock</th>
        <th>Status</th>
        <th style="text-align:right;">Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($products as $p): ?>
        <tr>
          <td>
            <img src="<?= Esc::attr($p['image_url'] ?? App::asset('images/placeholder.jpg')) ?>" style="width:44px; height:44px; object-fit:cover; border-radius:4px; border:1px solid var(--admin-border);">
          </td>
          <td>
            <b style="font-size:14px;"><?= Esc::html($p['title']) ?></b>
            <div style="font-size:12px; color:var(--admin-muted);">SKU: <?= Esc::html($p['sku']) ?> &middot; <?= Esc::html($p['size_volume']) ?></div>
          </td>
          <td><?= Esc::html($p['category_name'] ?? 'Uncategorized') ?></td>
          <td>
            <b><?= Format::money($p['price']) ?></b>
            <?php if (!empty($p['compare_at_price'])): ?>
              <div style="font-size:12px; color:var(--admin-muted); text-decoration:line-through;"><?= Format::money($p['compare_at_price']) ?></div>
            <?php endif; ?>
          </td>
          <td>
            <span style="font-weight:600; color:<?= $p['stock_quantity'] <= $p['low_stock_threshold'] ? '#dc2626' : '#15803d' ?>;">
              <?= $p['stock_quantity'] ?> in stock
            </span>
          </td>
          <td>
            <span class="badge" style="background:<?= $p['is_active'] ? '#dcfce7' : '#fee2e2' ?>; color:<?= $p['is_active'] ? '#15803d' : '#b91c1c' ?>;">
              <?= $p['is_active'] ? 'Active' : 'Draft' ?>
            </span>
          </td>
          <td style="text-align:right;">
            <div style="display:inline-flex; gap:6px;">
              <a href="<?= App::baseUrl('products/' . $p['slug']) ?>" target="_blank" class="btn-admin btn-admin-secondary" style="font-size:11px; padding:4px 8px;">View</a>
              <a href="<?= App::baseUrl('admin/products/edit?id=' . $p['id']) ?>" class="btn-admin btn-admin-secondary" style="font-size:11px; padding:4px 8px;">Edit</a>
              <a href="<?= App::baseUrl('admin/products/delete?id=' . $p['id'] . '&csrf_token=' . \App\Helpers\Csrf::token()) ?>" onclick="return confirm('Are you sure you want to delete this product?')" class="btn-admin btn-admin-danger" style="font-size:11px; padding:4px 8px;">Delete</a>
            </div>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>
