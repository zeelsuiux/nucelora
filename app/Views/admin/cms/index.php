<?php
use App\Config\App;
use App\Helpers\Esc;
use App\Helpers\Format;
?>

<div style="margin-bottom:24px;">
  <h1 style="font-size:24px; font-weight:700; margin-bottom:4px;">CMS Informational Pages</h1>
  <p style="font-size:14px; color:var(--admin-muted);">Update store policies, brand storytelling, and guides without editing PHP files</p>
</div>

<div class="admin-card">
  <table class="admin-table">
    <thead>
      <tr>
        <th>Page Title</th>
        <th>URL Slug</th>
        <th>Last Updated</th>
        <th style="text-align:right;">Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($pages as $p): ?>
        <tr>
          <td><b><?= Esc::html($p['title']) ?></b></td>
          <td><code>/pages/<?= Esc::html($p['slug']) ?></code></td>
          <td style="font-size:12px; color:var(--admin-muted);"><?= Format::date($p['updated_at'] ?? null) ?></td>
          <td style="text-align:right;">
            <div style="display:inline-flex; gap:6px;">
              <a href="<?= App::baseUrl('pages/' . $p['slug']) ?>" target="_blank" class="btn-admin btn-admin-secondary" style="font-size:11px; padding:4px 8px;">View</a>
              <a href="<?= App::baseUrl('admin/cms/edit?id=' . $p['id']) ?>" class="btn-admin btn-admin-primary" style="font-size:11px; padding:4px 8px;">Edit Content</a>
            </div>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>
