<?php
use App\Config\App;
use App\Helpers\Esc;
use App\Helpers\Format;
?>

<div style="margin-bottom:24px;">
  <h1 style="font-size:24px; font-weight:700; margin-bottom:4px;">Customer Reviews &amp; Moderation</h1>
  <p style="font-size:14px; color:var(--admin-muted);">Approve, reject, or manage verified customer feedback</p>
</div>

<div class="admin-card">
  <table class="admin-table">
    <thead>
      <tr>
        <th>Rating</th>
        <th>Product</th>
        <th>Reviewer &amp; Content</th>
        <th>Status</th>
        <th>Date</th>
        <th style="text-align:right;">Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($reviews as $rev): ?>
        <tr>
          <td><span style="color:#f59e0b; font-size:16px;">★★★★★</span></td>
          <td><b><?= Esc::html($rev['product_title'] ?? ('Product #' . $rev['product_id'])) ?></b></td>
          <td>
            <b><?= Esc::html($rev['title']) ?></b>
            <div style="font-size:13px; color:var(--admin-muted); margin-top:2px;">"<?= Esc::html($rev['content']) ?>"</div>
            <div style="font-size:11px; color:var(--admin-muted); margin-top:4px;">By <b><?= Esc::html($rev['reviewer_name']) ?></b> (<?= Esc::html($rev['reviewer_email']) ?>)</div>
          </td>
          <td>
            <span class="badge" style="background:<?= $rev['is_approved'] ? '#dcfce7' : '#fef3c7' ?>; color:<?= $rev['is_approved'] ? '#15803d' : '#b45309' ?>;">
              <?= $rev['is_approved'] ? 'Approved' : 'Pending' ?>
            </span>
          </td>
          <td style="font-size:12px; color:var(--admin-muted);"><?= Format::date($rev['created_at'], 'd M Y') ?></td>
          <td style="text-align:right;">
            <div style="display:inline-flex; gap:6px;">
              <?php if (!$rev['is_approved']): ?>
                <a href="<?= App::baseUrl('admin/reviews/approve?id=' . $rev['id'] . '&csrf_token=' . \App\Helpers\Csrf::token()) ?>" class="btn-admin btn-admin-primary" style="font-size:11px; padding:4px 8px;">Approve</a>
              <?php else: ?>
                <a href="<?= App::baseUrl('admin/reviews/reject?id=' . $rev['id'] . '&csrf_token=' . \App\Helpers\Csrf::token()) ?>" class="btn-admin btn-admin-secondary" style="font-size:11px; padding:4px 8px;">Hide</a>
              <?php endif; ?>
              <a href="<?= App::baseUrl('admin/reviews/delete?id=' . $rev['id'] . '&csrf_token=' . \App\Helpers\Csrf::token()) ?>" onclick="return confirm('Delete review permanently?')" class="btn-admin btn-admin-danger" style="font-size:11px; padding:4px 8px;">Delete</a>
            </div>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>
