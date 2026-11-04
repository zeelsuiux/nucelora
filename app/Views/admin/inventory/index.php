<?php
use App\Config\App;
use App\Helpers\Esc;
use App\Helpers\Csrf;
?>

<div style="margin-bottom:24px;">
  <h1 style="font-size:24px; font-weight:700; margin-bottom:4px;">Inventory &amp; Stock Tracking</h1>
  <p style="font-size:14px; color:var(--admin-muted);">Real-time SKU quantities, safety stock levels, and rapid adjustments</p>
</div>

<div class="admin-card">
  <table class="admin-table">
    <thead>
      <tr>
        <th>SKU</th>
        <th>Product Title</th>
        <th>Current Stock</th>
        <th>Low Stock Limit</th>
        <th>Stock Health</th>
        <th style="text-align:right;">Quick Update</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($products as $p): ?>
        <tr>
          <td><code><?= Esc::html($p['sku']) ?></code></td>
          <td>
            <b><?= Esc::html($p['title']) ?></b>
            <div style="font-size:12px; color:var(--admin-muted);"><?= Esc::html($p['size_volume']) ?></div>
          </td>
          <td><b><?= $p['stock_quantity'] ?></b></td>
          <td><?= $p['low_stock_threshold'] ?></td>
          <td>
            <?php if ($p['stock_quantity'] <= 0): ?>
              <span class="badge" style="background:#fee2e2; color:#b91c1c;">Out of Stock</span>
            <?php elseif ($p['stock_quantity'] <= $p['low_stock_threshold']): ?>
              <span class="badge" style="background:#fef3c7; color:#b45309;">Low Stock</span>
            <?php else: ?>
              <span class="badge" style="background:#dcfce7; color:#15803d;">Optimal</span>
            <?php endif; ?>
          </td>
          <td style="text-align:right;">
            <form action="<?= App::baseUrl('admin/inventory/update') ?>" method="POST" style="display:inline-flex; gap:6px;">
              <?= Csrf::field() ?>
              <input type="hidden" name="product_id" value="<?= $p['id'] ?>">
              <input type="number" name="quantity" value="<?= $p['stock_quantity'] ?>" style="width:70px; padding:4px 8px; border:1px solid var(--admin-border); border-radius:4px; font-size:13px;">
              <button type="submit" class="btn-admin btn-admin-secondary" style="font-size:11px; padding:4px 10px;">Update</button>
            </form>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>
