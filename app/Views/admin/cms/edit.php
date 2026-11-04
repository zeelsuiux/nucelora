<?php
use App\Config\App;
use App\Helpers\Esc;
use App\Helpers\Csrf;
?>

<div style="margin-bottom:24px;">
  <a href="<?= App::baseUrl('admin/cms') ?>" style="font-size:13px; color:var(--admin-muted); text-decoration:none;">&larr; Back to CMS Pages</a>
  <h1 style="font-size:24px; font-weight:700; margin-top:8px;">Edit CMS Page: <?= Esc::html($page['title']) ?></h1>
</div>

<form action="<?= App::baseUrl('admin/cms/update') ?>" method="POST" class="admin-card" style="max-width:800px;">
  <?= Csrf::field() ?>
  <input type="hidden" name="id" value="<?= $page['id'] ?>">

  <div class="form-group">
    <label>Page Title *</label>
    <input type="text" name="title" required value="<?= Esc::attr($page['title']) ?>" class="form-control">
  </div>

  <div class="form-group">
    <label>URL Slug</label>
    <input type="text" name="slug" readonly value="<?= Esc::attr($page['slug']) ?>" class="form-control" style="background:#f1f5f9;">
  </div>

  <div class="form-group">
    <label>HTML Content *</label>
    <textarea name="content_html" rows="14" required class="form-control" style="font-family:monospace; font-size:13px; line-height:1.5;"><?= Esc::html($page['content_html']) ?></textarea>
  </div>

  <div style="display:flex; gap:12px; margin-top:20px;">
    <button type="submit" class="btn-admin btn-admin-primary">Save Changes</button>
    <a href="<?= App::baseUrl('admin/cms') ?>" class="btn-admin btn-admin-secondary">Cancel</a>
  </div>
</form>
