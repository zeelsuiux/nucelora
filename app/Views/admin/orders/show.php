<?php
use App\Config\App;
use App\Helpers\Esc;
use App\Helpers\Format;
use App\Helpers\Csrf;

$address = json_decode($order['shipping_address_json'], true) ?: [];
?>

<div style="margin-bottom:24px; display:flex; justify-content:space-between; align-items:center;">
  <div>
    <a href="<?= App::baseUrl('admin/orders') ?>" style="font-size:13px; color:var(--admin-muted); text-decoration:none;">&larr; Back to Orders</a>
    <h1 style="font-size:24px; font-weight:700; margin-top:6px;">Order <?= Esc::html($order['order_number']) ?></h1>
  </div>
  <button type="button" onclick="window.print()" class="btn-admin btn-admin-secondary">
    🖨️ Print Invoice
  </button>
</div>

<div style="display:grid; grid-template-columns:2fr 1fr; gap:24px; align-items:start;">
  <!-- Left Column: Items & Customer Details -->
  <div>
    <!-- Items Card -->
    <div class="admin-card">
      <h3 style="font-size:16px; font-weight:600; margin-bottom:16px;">Purchased Line Items</h3>
      <table class="admin-table">
        <thead>
          <tr>
            <th>Product</th>
            <th>SKU</th>
            <th>Unit Price</th>
            <th>Qty</th>
            <th style="text-align:right;">Line Total</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($order['items'] as $it): ?>
            <tr>
              <td>
                <b><?= Esc::html($it['product_title']) ?></b>
                <div style="font-size:12px; color:var(--admin-muted);"><?= Esc::html($it['variant_title']) ?></div>
              </td>
              <td><?= Esc::html($it['sku']) ?></td>
              <td><?= Format::money($it['unit_price']) ?></td>
              <td><b><?= $it['quantity'] ?></b></td>
              <td style="text-align:right;"><b><?= Format::money($it['total_price']) ?></b></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>

      <div style="max-width:300px; margin-left:auto; margin-top:20px; display:flex; flex-direction:column; gap:8px; font-size:14px;">
        <div style="display:flex; justify-content:space-between;">
          <span style="color:var(--admin-muted);">Subtotal</span>
          <b><?= Format::money($order['subtotal']) ?></b>
        </div>
        <?php if ($order['discount_amount'] > 0): ?>
          <div style="display:flex; justify-content:space-between; color:#15803d;">
            <span>Discount (<?= Esc::html($order['coupon_code']) ?>)</span>
            <b>- <?= Format::money($order['discount_amount']) ?></b>
          </div>
        <?php endif; ?>
        <div style="display:flex; justify-content:space-between;">
          <span style="color:var(--admin-muted);">Shipping</span>
          <b><?= $order['shipping_amount'] == 0 ? 'FREE' : Format::money($order['shipping_amount']) ?></b>
        </div>
        <div style="border-top:1px solid var(--admin-border); padding-top:10px; display:flex; justify-content:space-between; font-size:18px;">
          <b>Total</b>
          <b style="color:var(--admin-primary);"><?= Format::money($order['total_amount']) ?></b>
        </div>
      </div>
    </div>

    <!-- Status History -->
    <div class="admin-card">
      <h3 style="font-size:16px; font-weight:600; margin-bottom:16px;">Order Status Activity Log</h3>
      <div style="display:flex; flex-direction:column; gap:12px;">
        <?php foreach ($order['history'] as $hist): ?>
          <div style="display:flex; justify-content:space-between; border-bottom:1px solid var(--admin-border); padding-bottom:8px; font-size:13px;">
            <div>
              <b style="text-transform:uppercase; color:var(--admin-primary);"><?= Esc::html($hist['status']) ?></b>
              <div style="color:var(--admin-muted); margin-top:2px;"><?= Esc::html($hist['notes'] ?? 'Updated') ?></div>
            </div>
            <div style="font-size:12px; color:var(--admin-muted);"><?= Format::date($hist['created_at']) ?></div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>

  <!-- Right Column: Status Actions & Shipping Info -->
  <div style="display:flex; flex-direction:column; gap:24px;">
    <!-- Update Status Card -->
    <div class="admin-card">
      <h3 style="font-size:16px; font-weight:600; margin-bottom:16px;">Update Order Status</h3>
      <form action="<?= App::baseUrl('admin/orders/update-status') ?>" method="POST">
        <?= Csrf::field() ?>
        <input type="hidden" name="order_id" value="<?= $order['id'] ?>">
        
        <div class="form-group">
          <label>Lifecycle Status</label>
          <select name="status" class="form-control">
            <?php foreach (['pending', 'confirmed', 'processing', 'shipped', 'delivered', 'cancelled', 'refunded'] as $st): ?>
              <option value="<?= $st ?>" <?= $order['status'] === $st ? 'selected' : '' ?>><?= ucfirst($st) ?></option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="form-group">
          <label>Status Notes (Optional)</label>
          <input type="text" name="notes" placeholder="e.g. Package dispatched via Delhivery" class="form-control">
        </div>

        <button type="submit" class="btn-admin btn-admin-primary" style="width:100%; justify-content:center;">
          Update Status
        </button>
      </form>
    </div>

    <!-- Customer & Shipping Card -->
    <div class="admin-card">
      <h3 style="font-size:16px; font-weight:600; margin-bottom:16px;">Shipping &amp; Customer</h3>
      <div style="font-size:14px; line-height:1.6;">
        <b><?= Esc::html($address['full_name'] ?? 'Guest Customer') ?></b><br>
        Phone: <b><?= Esc::html($address['phone'] ?? '-') ?></b><br>
        Email: <?= Esc::html($order['guest_email'] ?: '-') ?><br><br>
        <span style="color:var(--admin-muted);">Address:</span><br>
        <?= Esc::html($address['address_line1'] ?? '') ?><br>
        <?php if (!empty($address['address_line2'])): ?>
          <?= Esc::html($address['address_line2']) ?><br>
        <?php endif; ?>
        <?= Esc::html($address['city'] ?? '') ?>, <?= Esc::html($address['state'] ?? '') ?> - <?= Esc::html($address['postal_code'] ?? '') ?><br>
        <?= Esc::html($address['country'] ?? 'India') ?>
      </div>
    </div>
  </div>
</div>
