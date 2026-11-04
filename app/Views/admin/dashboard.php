<?php
use App\Config\App;
use App\Helpers\Esc;
use App\Helpers\Format;
?>

<div style="margin-bottom:28px;">
  <h1 style="font-size:24px; font-weight:700; margin-bottom:4px;">Dashboard Overview</h1>
  <p style="font-size:14px; color:var(--admin-muted);">Live real-time store performance metrics and order pipeline</p>
</div>

<!-- KPI Metrics Grid -->
<div class="kpi-grid">
  <div class="kpi-card">
    <div class="kpi-title">Total Revenue</div>
    <div class="kpi-value"><?= Format::money($kpis['total_revenue']) ?></div>
    <div class="kpi-sub">Today: <b><?= Format::money($kpis['today_revenue']) ?></b></div>
  </div>

  <div class="kpi-card">
    <div class="kpi-title">Total Orders</div>
    <div class="kpi-value"><?= $kpis['total_orders'] ?></div>
    <div class="kpi-sub"><?= $kpis['delivered_orders'] ?> Delivered &middot; <?= $kpis['cancelled_orders'] ?> Cancelled</div>
  </div>

  <div class="kpi-card">
    <div class="kpi-title">Pending Fulfillment</div>
    <div class="kpi-value" style="color:#b45309;"><?= $kpis['pending_orders'] ?></div>
    <div class="kpi-sub"><?= $kpis['processing_orders'] ?> in processing</div>
  </div>

  <div class="kpi-card">
    <div class="kpi-title">Active Catalog</div>
    <div class="kpi-value"><?= $kpis['total_products'] ?></div>
    <div class="kpi-sub"><?= $kpis['total_customers'] ?> registered buyers</div>
  </div>
</div>

<!-- Recent Orders & Inventory Alerts -->
<div style="display:grid; grid-template-columns:2fr 1fr; gap:24px; align-items:start;">
  <!-- Recent Orders Table -->
  <div class="admin-card">
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:16px;">
      <h3 style="font-size:16px; font-weight:600;">Recent Store Orders</h3>
      <a href="<?= App::baseUrl('admin/orders') ?>" style="font-size:13px; color:var(--admin-primary); font-weight:600;">View All &rarr;</a>
    </div>

    <?php if (empty($recentOrders)): ?>
      <p style="color:var(--admin-muted); font-size:14px; padding:20px 0; text-align:center;">No orders placed yet.</p>
    <?php else: ?>
      <table class="admin-table">
        <thead>
          <tr>
            <th>Order #</th>
            <th>Customer</th>
            <th>Total</th>
            <th>Status</th>
            <th>Date</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($recentOrders as $ro): ?>
            <tr>
              <td><b><?= Esc::html($ro['order_number']) ?></b></td>
              <td><?= Esc::html($ro['guest_email'] ?: ('Customer #' . $ro['customer_id'])) ?></td>
              <td><b><?= Format::money($ro['total_amount']) ?></b></td>
              <td><span class="badge badge-<?= Esc::attr($ro['status']) ?>"><?= Esc::html($ro['status']) ?></span></td>
              <td style="font-size:12px; color:var(--admin-muted);"><?= Format::date($ro['created_at'], 'd M, h:i A') ?></td>
              <td>
                <a href="<?= App::baseUrl('admin/orders/show?id=' . $ro['id']) ?>" class="btn-admin btn-admin-secondary" style="font-size:11px; padding:4px 8px;">View</a>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    <?php endif; ?>
  </div>

  <!-- Low Stock Alert Sidebar -->
  <div class="admin-card">
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:16px;">
      <h3 style="font-size:16px; font-weight:600;">Low Stock Alerts (<?= count($lowStockList) ?>)</h3>
      <a href="<?= App::baseUrl('admin/inventory') ?>" style="font-size:13px; color:var(--admin-primary); font-weight:600;">Inventory &rarr;</a>
    </div>

    <?php if (empty($lowStockList)): ?>
      <p style="color:#15803d; font-size:13px; background:#dcfce7; padding:12px; border-radius:6px;">
        ✓ All stock levels are healthy above threshold limits.
      </p>
    <?php else: ?>
      <div style="display:flex; flex-direction:column; gap:12px;">
        <?php foreach ($lowStockList as $ls): ?>
          <div style="display:flex; justify-content:space-between; align-items:center; border-bottom:1px solid var(--admin-border); padding-bottom:8px; font-size:13px;">
            <div>
              <b><?= Esc::html($ls['title']) ?></b>
              <div style="font-size:11px; color:var(--admin-muted);">SKU: <?= Esc::html($ls['sku']) ?></div>
            </div>
            <span style="font-weight:700; color:#dc2626;"><?= $ls['stock_quantity'] ?> left</span>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </div>
</div>
