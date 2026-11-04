<?php
use App\Config\App;
use App\Helpers\Esc;
use App\Helpers\Csrf;
?>

<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:24px;">
  <div>
    <h1 style="font-size:24px; font-weight:700; margin-bottom:4px;">Homepage Banners &amp; Spotlight</h1>
    <p style="font-size:14px; color:var(--admin-muted);">Control hero banner carousels, CTA links, and visual background tints</p>
  </div>
</div>

<div style="display:grid; grid-template-columns:1fr 340px; gap:24px; align-items:start;">
  <div class="admin-card">
    <table class="admin-table">
      <thead>
        <tr>
          <th>Badge &amp; Title</th>
          <th>Button CTA</th>
          <th>Tint</th>
          <th>Order</th>
          <th style="text-align:right;">Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($banners as $b): ?>
          <tr>
            <td>
              <span class="badge" style="background:#f1f5f9;"><?= Esc::html($b['badge_text']) ?></span>
              <div style="font-weight:600; margin-top:4px;"><?= Esc::html($b['title']) ?></div>
              <div style="font-size:12px; color:var(--admin-muted);"><?= Esc::html($b['subtitle']) ?></div>
            </td>
            <td>
              <span style="font-size:13px;"><?= Esc::html($b['button_text']) ?> &rarr; <?= Esc::html($b['button_url']) ?></span>
            </td>
            <td>
              <span style="display:inline-block; width:20px; height:20px; border-radius:50%; background:<?= Esc::attr($b['bg_tint']) ?>; border:1px solid #ccc; vertical-align:middle;"></span>
              <span style="font-size:12px; margin-left:4px;"><?= Esc::html($b['bg_tint']) ?></span>
            </td>
            <td><?= $b['sort_order'] ?></td>
            <td style="text-align:right;">
              <a href="<?= App::baseUrl('admin/banners/delete?id=' . $b['id'] . '&csrf_token=' . \App\Helpers\Csrf::token()) ?>" onclick="return confirm('Delete this banner?')" class="btn-admin btn-admin-danger" style="font-size:11px; padding:4px 8px;">Delete</a>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>

  <div class="admin-card">
    <h3 style="font-size:16px; font-weight:600; margin-bottom:16px;">Add New Banner</h3>
    <form action="<?= App::baseUrl('admin/banners/store') ?>" method="POST">
      <?= Csrf::field() ?>
      <div class="form-group">
        <label>Heading Title *</label>
        <input type="text" name="title" required placeholder="e.g. Pure Bio-Actives" class="form-control">
      </div>
      <div class="form-group">
        <label>Badge Label</label>
        <input type="text" name="badge_text" placeholder="e.g. Skincare | Haircare" class="form-control">
      </div>
      <div class="form-group">
        <label>Subtitle Description</label>
        <textarea name="subtitle" rows="2" class="form-control"></textarea>
      </div>
      <div class="form-group">
        <label>Desktop Image URL *</label>
        <input type="url" name="desktop_image_url" required placeholder="https://..." class="form-control">
      </div>
      <div class="form-group">
        <label>Background Tint (Hex)</label>
        <input type="text" name="bg_tint" value="#f7f6f4" class="form-control">
      </div>
      <div class="form-group">
        <label>Button Text &amp; URL</label>
        <div style="display:flex; gap:8px;">
          <input type="text" name="button_text" value="Shop Now" placeholder="Text" class="form-control" style="flex:1;">
          <input type="text" name="button_url" value="/collections/all" placeholder="URL" class="form-control" style="flex:1;">
        </div>
      </div>
      <button type="submit" class="btn-admin btn-admin-primary" style="width:100%; justify-content:center;">
        Create Banner
      </button>
    </form>
  </div>
</div>
