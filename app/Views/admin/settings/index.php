<?php
use App\Config\App;
use App\Helpers\Esc;
use App\Helpers\Csrf;
?>

<div style="margin-bottom:24px;">
  <h1 style="font-size:24px; font-weight:700; margin-bottom:4px;">Website &amp; Gateway Settings</h1>
  <p style="font-size:14px; color:var(--admin-muted);">Configure Razorpay API credentials, free shipping limits, and support details</p>
</div>

<form action="<?= App::baseUrl('admin/settings/update') ?>" method="POST" class="admin-card" style="max-width:800px;">
  <?= Csrf::field() ?>

  <h3 style="font-size:16px; font-weight:600; margin-bottom:16px; padding-bottom:8px; border-bottom:1px solid var(--admin-border);">
    💳 Payment Gateway (Razorpay)
  </h3>
  <div style="display:grid; grid-template-columns:1fr 1fr; gap:20px; margin-bottom:24px;">
    <div class="form-group">
      <label>Razorpay Key ID</label>
      <input type="text" name="razorpay_key_id" value="<?= Esc::attr($settings['razorpay_key_id'] ?? '') ?>" class="form-control">
    </div>
    <div class="form-group">
      <label>Razorpay Key Secret</label>
      <input type="password" name="razorpay_key_secret" value="<?= Esc::attr($settings['razorpay_key_secret'] ?? '') ?>" class="form-control">
    </div>
  </div>

  <h3 style="font-size:16px; font-weight:600; margin-bottom:16px; padding-bottom:8px; border-bottom:1px solid var(--admin-border);">
    🚚 Shipping &amp; Logistics
  </h3>
  <div style="display:grid; grid-template-columns:1fr 1fr; gap:20px; margin-bottom:24px;">
    <div class="form-group">
      <label>Free Shipping Threshold (₹) (0 = Always Free)</label>
      <input type="number" step="0.01" name="free_shipping_threshold" value="<?= Esc::attr($settings['free_shipping_threshold'] ?? '0') ?>" class="form-control">
    </div>
    <div class="form-group">
      <label>Standard Shipping Fee (₹)</label>
      <input type="number" step="0.01" name="standard_shipping_fee" value="<?= Esc::attr($settings['standard_shipping_fee'] ?? '0') ?>" class="form-control">
    </div>
  </div>

  <h3 style="font-size:16px; font-weight:600; margin-bottom:16px; padding-bottom:8px; border-bottom:1px solid var(--admin-border);">
    📞 Customer Care &amp; Contact
  </h3>
  <div style="display:grid; grid-template-columns:1fr 1fr; gap:20px; margin-bottom:24px;">
    <div class="form-group">
      <label>Support Email</label>
      <input type="email" name="contact_email" value="<?= Esc::attr($settings['contact_email'] ?? 'contact@lymko.in') ?>" class="form-control">
    </div>
    <div class="form-group">
      <label>Helpline Phone</label>
      <input type="text" name="contact_phone" value="<?= Esc::attr($settings['contact_phone'] ?? '+918866611621') ?>" class="form-control">
    </div>
    <div class="form-group" style="grid-column:span 2;">
      <label>Registered Office Address</label>
      <input type="text" name="contact_address" value="<?= Esc::attr($settings['contact_address'] ?? 'Surat, Gujarat, India - 395006') ?>" class="form-control">
    </div>
  </div>

  <button type="submit" class="btn-admin btn-admin-primary">Save All Settings</button>
</form>
