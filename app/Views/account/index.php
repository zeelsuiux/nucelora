<?php
use App\Config\App;
use App\Helpers\Esc;
use App\Helpers\Format;
?>

<div class="page" style="padding:40px 0 80px;">
  <div class="w" style="max-width:960px;">
    <!-- Account Header -->
    <div style="display:flex; justify-content:space-between; align-items:center; border-bottom:1px solid var(--line); padding-bottom:20px; margin-bottom:32px;">
      <div>
        <span class="lab o">Customer Profile</span>
        <h1 class="h1" style="font-size:32px; margin:6px 0 0;">Welcome, <?= Esc::html($customer['first_name']) ?>!</h1>
      </div>
      <a href="<?= App::baseUrl('account/logout') ?>" class="btn btn-l sm">Log Out</a>
    </div>

    <div style="display:grid; grid-template-columns:1fr 320px; gap:40px; align-items:start;">
      <!-- Orders List -->
      <div>
        <div style="display:flex; justify-content:space-between; align-items:baseline; margin-bottom:16px;">
          <h3 style="font-size:20px; margin:0;">Recent Orders</h3>
        </div>

        <?php if (empty($orders)): ?>
          <div style="background:#fff; border:1px solid var(--line); border-radius:8px; padding:40px; text-align:center;">
            <p style="color:var(--muted); margin-bottom:16px;">You haven't placed any orders yet.</p>
            <a href="<?= App::baseUrl('collections/all') ?>" class="btn btn-k sm">Start Shopping</a>
          </div>
        <?php else: ?>
          <div style="display:flex; flex-direction:column; gap:16px;">
            <?php foreach ($orders as $ord): ?>
              <div style="background:#fff; border:1px solid var(--line); border-radius:8px; padding:20px; display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px;">
                <div>
                  <b style="font-size:15px;"><?= Esc::html($ord['order_number']) ?></b>
                  <div style="font-size:13px; color:var(--muted); margin-top:4px;">
                    Placed on <?= Format::date($ord['created_at'], 'd M Y') ?> &middot; <?= Format::money($ord['total_amount']) ?>
                  </div>
                </div>
                <div style="display:flex; align-items:center; gap:12px;">
                  <span style="font-size:12px; font-weight:600; padding:4px 10px; border-radius:4px; text-transform:uppercase; background:var(--soft2); border:1px solid var(--line);">
                    <?= Esc::html($ord['status']) ?>
                  </span>
                  <a href="<?= App::baseUrl('account/orders/' . $ord['id']) ?>" class="btn btn-l sm">View Details</a>
                </div>
              </div>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>
      </div>

      <!-- Account Info Sidebar -->
      <div style="background:var(--soft2); border:1px solid var(--line); border-radius:8px; padding:24px;">
        <h4 style="margin:0 0 16px; font-size:16px;">Account Details</h4>
        <div style="font-size:14px; line-height:1.6; color:var(--ink2);">
          <b><?= Esc::html($customer['first_name'] . ' ' . ($customer['last_name'] ?? '')) ?></b><br>
          <?= Esc::html($customer['email']) ?><br>
          <?= Esc::html($customer['phone'] ?? 'No phone added') ?>
        </div>
      </div>
    </div>
  </div>
</div>
