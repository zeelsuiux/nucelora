<?php
use App\Config\App;
use App\Helpers\Esc;
use App\Helpers\Csrf;
?>

<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:24px;">
  <div>
    <h1 style="font-size:24px; font-weight:700; margin-bottom:4px;">Category Management</h1>
    <p style="font-size:14px; color:var(--admin-muted);">Organize product catalogs and navigational collections</p>
  </div>
</div>

<div style="display:grid; grid-template-columns:1fr 340px; gap:24px; align-items:start;">
  <div class="admin-card">
    <table class="admin-table">
      <thead>
        <tr>
          <th>Category Name</th>
          <th>URL Slug</th>
          <th>Status</th>
          <th style="text-align:right;">Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($categories as $cat): ?>
          <tr>
            <td><b><?= Esc::html($cat['name']) ?></b></td>
            <td><code>/collections/<?= Esc::html($cat['slug']) ?></code></td>
            <td>
              <span class="badge" style="background:<?= $cat['is_active'] ? '#dcfce7' : '#fee2e2' ?>; color:<?= $cat['is_active'] ? '#15803d' : '#b91c1c' ?>;">
                <?= $cat['is_active'] ? 'Active' : 'Disabled' ?>
              </span>
            </td>
            <td style="text-align:right;">
              <a href="<?= App::baseUrl('collections/' . $cat['slug']) ?>" target="_blank" class="btn-admin btn-admin-secondary" style="font-size:11px; padding:4px 8px;">View</a>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>

  <div class="admin-card">
    <h3 style="font-size:16px; font-weight:600; margin-bottom:16px;">Add New Category</h3>
    <form action="<?= App::baseUrl('admin/categories/store') ?>" method="POST">
      <?= Csrf::field() ?>
      <div class="form-group">
        <label>Category Name *</label>
        <input type="text" name="name" required placeholder="e.g. Lip Care" class="form-control">
      </div>
      <div class="form-group">
        <label>URL Slug (Optional)</label>
        <input type="text" name="slug" placeholder="e.g. lip-care" class="form-control">
      </div>
      <div class="form-group">
        <label>Description</label>
        <textarea name="description" rows="3" class="form-control"></textarea>
      </div>
      <button type="submit" class="btn-admin btn-admin-primary" style="width:100%; justify-content:center;">
        Create Category
      </button>
    </form>
  </div>
</div>
