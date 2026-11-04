<?php
use App\Config\App;
use App\Helpers\Esc;
use App\Helpers\Format;

$address = json_decode($order['shipping_address_json'], true) ?: [];
?>

<div class="page" style="padding:40px 0 80px;">
  <div class="w" style="max-width:880px;">
    <nav style="font-size:13px; color:var(--muted); margin-bottom:20px;">
      <a href="<?= App::baseUrl('account') ?>">My Account</a> &rarr; 
      <span>Order <?= Esc::html($order['order_number']) ?></span>
    </nav>

    <div style="display:flex; justify-content:space-between; align-items:flex-end; flex-wrap:wrap; gap:16px; border-bottom:1px solid var(--line); padding-bottom:20px; margin-bottom:32px;">
      <div>
        <h1 class="h1" style="font-size:28px; margin:0 0 6px;">Order <?= Esc::html($order['order_number']) ?></h1>
        <div style="font-size:13px; color:var(--muted);">Placed on <?= Format::date($order['created_at']) ?></div>
      </div>
      <div style="display:flex; gap:10px;">
        <span style="font-size:13px; font-weight:700; padding:6px 14px; border-radius:4px; text-transform:uppercase; background:var(--orsoft); color:var(--or);">
          <?= Esc::html($order['status']) ?>
        </span>
      </div>
    </div>

    <!-- Order Items -->
    <div style="background:#fff; border:1px solid var(--line); border-radius:8px; padding:24px; margin-bottom:32px;">
      <h3 style="font-size:18px; margin:0 0 20px;">Purchased Items</h3>
      <div style="display:flex; flex-direction:column; gap:16px;">
        <?php foreach ($order['items'] as $item): ?>
          <div style="display:flex; justify-content:space-between; align-items:center; border-bottom:1px solid var(--line); padding-bottom:12px;">
            <div>
              <b style="font-size:15px;"><?= Esc::html($item['product_title']) ?></b>
              <div style="font-size:13px; color:var(--muted); margin-top:2px;">
                Qty: <?= $item['quantity'] ?> &times; <?= Format::money($item['unit_price']) ?>
              </div>
            </div>
            <b style="font-size:16px;"><?= Format::money($item['total_price']) ?></b>
          </div>
        <?php endforeach; ?>
      </div>

      <div style="margin-top:20px; padding-top:16px; display:flex; flex-direction:column; gap:8px; font-size:14px; max-width:320px; margin-left:auto;">
        <div style="display:flex; justify-content:space-between;">
          <span style="color:var(--muted);">Subtotal</span>
          <b><?= Format::money($order['subtotal']) ?></b>
        </div>
        <?php if ($order['discount_amount'] > 0): ?>
          <div style="display:flex; justify-content:space-between; color:#059669;">
            <span>Discount (<?= Esc::html($order['coupon_code']) ?>)</span>
            <b>- <?= Format::money($order['discount_amount']) ?></b>
          </div>
        <?php endif; ?>
        <div style="display:flex; justify-content:space-between;">
          <span style="color:var(--muted);">Shipping</span>
          <span style="color:#059669; font-weight:600;">FREE</span>
        </div>
        <div style="border-top:1px solid var(--line); padding-top:10px; display:flex; justify-content:space-between; font-size:18px;">
          <b>Total</b>
          <b style="color:var(--ink);"><?= Format::money($order['total_amount']) ?></b>
        </div>
      </div>
    </div>

    <!-- Status History Timeline -->
    <div style="background:#fff; border:1px solid var(--line); border-radius:8px; padding:24px;">
      <h3 style="font-size:18px; margin:0 0 16px;">Order Activity Timeline</h3>
      <div style="display:flex; flex-direction:column; gap:14px;">
        <?php foreach ($order['history'] as $h): ?>
          <div style="display:flex; gap:16px;">
            <div style="width:10px; height:10px; border-radius:50%; background:var(--or); margin-top:5px; flex-shrink:0;"></div>
            <div>
              <b style="font-size:14px; text-transform:uppercase;"><?= Esc::html($h['status']) ?></b>
              <div style="font-size:13px; color:var(--ink2);"><?= Esc::html($h['notes'] ?? 'Status updated') ?></div>
              <div style="font-size:11px; color:var(--muted);"><?= Format::date($h['created_at']) ?></div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</div>
