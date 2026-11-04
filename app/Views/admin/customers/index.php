<?php
use App\Config\App;
use App\Helpers\Esc;
use App\Helpers\Format;
?>

<div style="margin-bottom:24px;">
  <h1 style="font-size:24px; font-weight:700; margin-bottom:4px;">Registered Customers</h1>
  <p style="font-size:14px; color:var(--admin-muted);">Customer accounts, order histories, and contact information</p>
</div>

<div class="admin-card">
  <table class="admin-table">
    <thead>
      <tr>
        <th>Customer Name</th>
        <th>Email Address</th>
        <th>Phone</th>
        <th>Total Orders</th>
        <th>Registered Date</th>
      </tr>
    </thead>
    <tbody>
      <?php if (empty($customers)): ?>
        <tr>
          <td colspan="5" style="text-align:center; padding:32px; color:var(--admin-muted);">No registered customers yet.</td>
        </tr>
      <?php else: ?>
        <?php foreach ($customers as $c): ?>
          <tr>
            <td><b><?= Esc::html($c['first_name'] . ' ' . ($c['last_name'] ?? '')) ?></b></td>
            <td><?= Esc::html($c['email']) ?></td>
            <td><?= Esc::html($c['phone'] ?? '-') ?></td>
            <td><span class="badge" style="background:#e0e7ff; color:#4338ca;"><?= $c['order_count'] ?? 0 ?> orders</span></td>
            <td style="font-size:12px; color:var(--admin-muted);"><?= Format::date($c['created_at'], 'd M Y') ?></td>
          </tr>
        <?php endforeach; ?>
      <?php endif; ?>
    </tbody>
  </table>
</div>
