<?php
use App\Config\App;
use App\Helpers\Esc;
use App\Helpers\Csrf;

$isEdit = !empty($product);
?>

<div style="margin-bottom:24px;">
  <a href="<?= App::baseUrl('admin/products') ?>" style="font-size:13px; color:var(--admin-muted); text-decoration:none;">&larr; Back to Products</a>
  <h1 style="font-size:24px; font-weight:700; margin-top:8px;"><?= $isEdit ? 'Edit Product: ' . Esc::html($product['title']) : 'Add New Product' ?></h1>
</div>

<form action="<?= $isEdit ? App::baseUrl('admin/products/update') : App::baseUrl('admin/products/store') ?>" method="POST" class="admin-card" style="max-width:840px;">
  <?= Csrf::field() ?>
  <?php if ($isEdit): ?>
    <input type="hidden" name="id" value="<?= $product['id'] ?>">
  <?php endif; ?>

  <div style="display:grid; grid-template-columns:2fr 1fr; gap:20px;">
    <div class="form-group">
      <label>Product Title *</label>
      <input type="text" name="title" required value="<?= Esc::attr($product['title'] ?? '') ?>" class="form-control">
    </div>
    <div class="form-group">
      <label>SKU Code *</label>
      <input type="text" name="sku" required value="<?= Esc::attr($product['sku'] ?? 'LYM-' . rand(1000, 9999)) ?>" class="form-control">
    </div>
  </div>

  <div style="display:grid; grid-template-columns:1fr 1fr 1fr; gap:20px;">
    <div class="form-group">
      <label>Category</label>
      <select name="category_id" class="form-control">
        <option value="">-- Select Category --</option>
        <?php foreach ($categories as $cat): ?>
          <option value="<?= $cat['id'] ?>" <?= (($product['category_id'] ?? '') == $cat['id']) ? 'selected' : '' ?>>
            <?= Esc::html($cat['name']) ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>

    <div class="form-group">
      <label>Selling Price (₹) *</label>
      <input type="number" step="0.01" name="price" required value="<?= Esc::attr($product['price'] ?? '499.00') ?>" class="form-control">
    </div>

    <div class="form-group">
      <label>MRP / Compare Price (₹)</label>
      <input type="number" step="0.01" name="compare_at_price" value="<?= Esc::attr($product['compare_at_price'] ?? '999.00') ?>" class="form-control">
    </div>
  </div>

  <div style="display:grid; grid-template-columns:1fr 1fr 1fr; gap:20px;">
    <div class="form-group">
      <label>Stock Quantity *</label>
      <input type="number" name="stock_quantity" required value="<?= Esc::attr($product['stock_quantity'] ?? 100) ?>" class="form-control">
    </div>

    <div class="form-group">
      <label>Size / Net Content</label>
      <input type="text" name="size_volume" value="<?= Esc::attr($product['size_volume'] ?? '30 ml') ?>" class="form-control">
    </div>

    <div class="form-group">
      <label>Promotional Badge</label>
      <input type="text" name="badge_text" placeholder="e.g. Save 50%, Best Seller" value="<?= Esc::attr($product['badge_text'] ?? '') ?>" class="form-control">
    </div>
  </div>

  <div class="form-group">
    <label>Primary Image URL *</label>
    <input type="url" name="image_url" placeholder="https://..." value="<?= Esc::attr($product['image_url'] ?? '') ?>" class="form-control">
  </div>

  <div class="form-group">
    <label>Short Description (Excerpt)</label>
    <textarea name="short_description" rows="2" class="form-control"><?= Esc::html($product['short_description'] ?? '') ?></textarea>
  </div>

  <div class="form-group">
    <label>Full Product Description</label>
    <textarea name="description" rows="5" class="form-control"><?= Esc::html($product['description'] ?? '') ?></textarea>
  </div>

  <div class="form-group">
    <label>Key Benefits</label>
    <textarea name="benefits" rows="2" class="form-control"><?= Esc::html($product['benefits'] ?? '') ?></textarea>
  </div>

  <div class="form-group">
    <label>Directions for Use</label>
    <textarea name="directions" rows="2" class="form-control"><?= Esc::html($product['directions'] ?? '') ?></textarea>
  </div>

  <div style="display:flex; gap:24px; margin-top:20px;">
    <label style="display:flex; align-items:center; gap:8px; cursor:pointer;">
      <input type="checkbox" name="is_best_seller" value="1" <?= !empty($product['is_best_seller']) ? 'checked' : '' ?>>
      <span style="font-size:14px; font-weight:600;">Mark as Best Seller</span>
    </label>
    <label style="display:flex; align-items:center; gap:8px; cursor:pointer;">
      <input type="checkbox" name="is_featured" value="1" <?= !empty($product['is_featured']) ? 'checked' : '' ?>>
      <span style="font-size:14px; font-weight:600;">Feature on Homepage</span>
    </label>
    <label style="display:flex; align-items:center; gap:8px; cursor:pointer;">
      <input type="checkbox" name="is_active" value="1" <?= (!isset($product['is_active']) || $product['is_active']) ? 'checked' : '' ?>>
      <span style="font-size:14px; font-weight:600;">Product Visible (Active)</span>
    </label>
  </div>

  <div style="margin-top:28px; display:flex; gap:12px;">
    <button type="submit" class="btn-admin btn-admin-primary"><?= $isEdit ? 'Save Changes' : 'Publish Product' ?></button>
    <a href="<?= App::baseUrl('admin/products') ?>" class="btn-admin btn-admin-secondary">Cancel</a>
  </div>
</form>
