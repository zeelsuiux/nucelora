<?php
use App\Config\App;
use App\Helpers\Esc;
use App\Helpers\Csrf;
?>

<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:24px;">
  <div>
    <h1 style="font-size:24px; font-weight:700; margin-bottom:4px;">Coupon &amp; Discount Management</h1>
    <p style="font-size:14px; color:var(--admin-muted);">Create promotional promo codes, percent discounts, and minimum order rules</p>
  </div>
</div>

<div style="display:grid; grid-template-columns:1fr 340px; gap:24px; align-items:start;">
  <div class="admin-card">
    <table class="admin-table">
      <thead>
        <tr>
          <th>Code</th>
          <th>Discount</th>
          <th>Min Order</th>
          <th>Usage</th>
          <th>Status</th>
          <th style="text-align:right;">Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($coupons as $cp): ?>
          <tr>
            <td><b style="font-size:14px; color:var(--admin-primary);"><?= Esc::html($cp['code']) ?></b></td>
            <td>
              <?= $cp['discount_type'] === 'percentage' ? ((int)$cp['discount_value'] . '% OFF') : ('₹' . (int)$cp['discount_value'] . ' FLAT') ?>
            </td>
            <td>₹<?= (int)$cp['min_order_amount'] ?></td>
            <td><?= $cp['times_used'] ?> uses</td>
            <td>
              <span class="badge" style="background:<?= $cp['is_active'] ? '#dcfce7' : '#fee2e2' ?>; color:<?= $cp['is_active'] ? '#15803d' : '#b91c1c' ?>;">
                <?= $cp['is_active'] ? 'Active' : 'Expired' ?>
              </span>
            </td>
            <td style="text-align:right;">
              <a href="<?= App::baseUrl('admin/coupons/delete?id=' . $cp['id'] . '&csrf_token=' . \App\Helpers\Csrf::token()) ?>" onclick="return confirm('Delete coupon?')" class="btn-admin btn-admin-danger" style="font-size:11px; padding:4px 8px;">Delete</a>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>

  <div class="admin-card">
    <h3 style="font-size:16px; font-weight:600; margin-bottom:16px;">Create Coupon</h3>
    <form action="<?= App::baseUrl('admin/coupons/store') ?>" method="POST">
      <?= Csrf::field() ?>
      <div class="form-group">
        <label>Coupon Code *</label>
        <input type="text" name="code" required placeholder="e.g. GLOW15" style="text-transform:uppercase;" class="form-control">
      </div>
      <div class="form-group">
        <label>Discount Type</label>
        <select name="discount_type" class="form-control">
          <option value="percentage">Percentage (%)</option>
          <option value="fixed">Fixed Amount (₹)</option>
        </select>
      </div>
      <div class="form-group">
        <label>Discount Value *</label>
        <input type="number" step="0.01" name="discount_value" required placeholder="e.g. 15 or 100" class="form-control">
      </div>
      <div class="form-group">
        <label>Minimum Cart Total (₹)</label>
        <input type="number" step="0.01" name="min_order_amount" value="0.00" class="form-control">
      </div>
      <button type="submit" class="btn-admin btn-admin-primary" style="width:100%; justify-content:center;">
        Create Coupon
      </button>
    </form>
  </div>
</div>
