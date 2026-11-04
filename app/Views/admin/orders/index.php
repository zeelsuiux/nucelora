<?php
use App\Config\App;
use App\Helpers\Esc;
use App\Helpers\Format;
?>

<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:24px;">
  <div>
    <h1 style="font-size:24px; font-weight:700; margin-bottom:4px;">Orders Management</h1>
    <p style="font-size:14px; color:var(--admin-muted);">Track customer orders, fulfillment pipelines, and shipments</p>
  </div>
</div>

<div class="admin-card">
  <table class="admin-table">
    <thead>
      <tr>
        <th>Order Number</th>
        <th>Customer</th>
        <th>Items</th>
        <th>Total Amount</th>
        <th>Payment</th>
        <th>Order Status</th>
        <th>Date</th>
        <th style="text-align:right;">Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php if (empty($orders)): ?>
        <tr>
          <td colspan="8" style="text-align:center; padding:32px; color:var(--admin-muted);">No orders found.</td>
        </tr>
      <?php else: ?>
        <?php foreach ($orders as $o): ?>
          <tr>
            <td><b><?= Esc::html($o['order_number']) ?></b></td>
            <td><?= Esc::html($o['guest_email'] ?: ('User #' . $o['customer_id'])) ?></td>
            <td><span class="badge" style="background:#f1f5f9;"><?= $o['item_count'] ?? 1 ?> items</span></td>
            <td><b><?= Format::money($o['total_amount']) ?></b></td>
            <td>
              <span class="badge" style="background:<?= $o['payment_status'] === 'paid' ? '#dcfce7' : '#fef3c7' ?>; color:<?= $o['payment_status'] === 'paid' ? '#15803d' : '#b45309' ?>;">
                <?= Esc::html($o['payment_method']) ?> &middot; <?= Esc::html($o['payment_status']) ?>
              </span>
            </td>
            <td>
              <span class="badge badge-<?= Esc::attr($o['status']) ?>"><?= Esc::html($o['status']) ?></span>
            </td>
            <td style="font-size:12px; color:var(--admin-muted);"><?= Format::date($o['created_at']) ?></td>
            <td style="text-align:right;">
              <a href="<?= App::baseUrl('admin/orders/show?id=' . $o['id']) ?>" class="btn-admin btn-admin-primary" style="font-size:11px; padding:4px 10px;">
                View Order &rarr;
              </a>
            </td>
          </tr>
        <?php endforeach; ?>
      <?php endif; ?>
    </tbody>
  </table>
</div>
