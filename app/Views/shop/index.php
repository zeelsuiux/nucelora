<?php
use App\Config\App;
use App\Helpers\Esc;
use App\Helpers\Format;
?>

<div class="page" style="padding:40px 0 80px;">
  <div class="w">
    <!-- Header & Category Title -->
    <div style="border-bottom:1px solid var(--line); padding-bottom:24px; margin-bottom:32px;">
      <nav style="font-size:13px; color:var(--muted); margin-bottom:12px;">
        <a href="<?= App::baseUrl() ?>">Home</a> &rarr; 
        <span><?= Esc::html($category['name'] ?? 'All Products') ?></span>
      </nav>
      <div style="display:flex; justify-content:space-between; align-items:flex-end; flex-wrap:wrap; gap:16px;">
        <div>
          <h1 class="h1" style="font-size:36px; margin:0 0 8px;"><?= Esc::html($category['name'] ?? 'Shop All Formulations') ?></h1>
          <p style="color:var(--ink2); max-width:600px; margin:0;">
            <?= Esc::html($category['description'] ?? 'Targeted botanical bio-actives formulated with minimalist precision. Paraben-free, cruelty-free, and suitable for all Indian skin types.') ?>
          </p>
        </div>
        <div style="font-size:14px; color:var(--muted);">
          Showing <b><?= count($products) ?></b> items
        </div>
      </div>
    </div>

    <!-- Category Filter Pills -->
    <div style="display:flex; gap:10px; overflow-x:auto; padding-bottom:16px; margin-bottom:32px;">
      <a href="<?= App::baseUrl('collections/all') ?>" class="con-btn <?= empty($activeCategorySlug) ? 'on' : '' ?>">All</a>
      <?php foreach ($categories as $cat): ?>
        <a href="<?= App::baseUrl('collections/' . $cat['slug']) ?>" class="con-btn <?= ($activeCategorySlug ?? '') === $cat['slug'] ? 'on' : '' ?>">
          <?= Esc::html($cat['name']) ?>
        </a>
      <?php endforeach; ?>
    </div>

    <!-- Products Grid -->
    <?php if (empty($products)): ?>
      <div style="text-align:center; padding:80px 20px;">
        <h3 class="h3">No products found in this category.</h3>
        <p style="margin-top:10px; color:var(--muted);">Check back soon for new arrivals or browse our full range.</p>
        <a href="<?= App::baseUrl('collections/all') ?>" class="btn btn-k" style="margin-top:20px;">Browse all products</a>
      </div>
    <?php else: ?>
      <div class="cards-grid" style="display:grid; grid-template-columns:repeat(auto-fill, minmax(280px, 1fr)); gap:28px;">
        <?php foreach ($products as $p): ?>
          <article class="p-card" style="background:#fff; border:1px solid var(--line); border-radius:8px; overflow:hidden; display:flex; flex-direction:column; position:relative;">
            <?php if (!empty($p['badge_text'])): ?>
              <span class="p-badge" style="position:absolute; top:12px; left:12px; background:var(--orsoft); color:var(--or); font-size:12px; font-weight:600; padding:4px 8px; border-radius:4px; z-index:2;">
                <?= Esc::html($p['badge_text']) ?>
              </span>
            <?php endif; ?>
            <a href="<?= App::baseUrl('products/' . $p['slug']) ?>" style="display:block; overflow:hidden; background:var(--soft2); text-align:center;">
              <img src="<?= Esc::attr($p['image_url'] ?? App::asset('images/placeholder.jpg')) ?>" alt="<?= Esc::attr($p['title']) ?>" loading="lazy" style="width:100%; height:340px; object-fit:cover; transition:transform 0.4s var(--e);">
            </a>
            <div style="padding:20px; display:flex; flex-direction:column; flex:1;">
              <span style="font-size:12px; color:var(--muted); text-transform:uppercase; letter-spacing:0.04em; margin-bottom:4px;">
                <?= Esc::html($p['category_name'] ?? 'Skincare') ?> &middot; <?= Esc::html($p['size_volume']) ?>
              </span>
              <h4 style="font-size:17px; font-weight:600; margin:0 0 10px; line-height:1.4;">
                <a href="<?= App::baseUrl('products/' . $p['slug']) ?>"><?= Esc::html($p['title']) ?></a>
              </h4>
              <p style="font-size:13px; color:var(--ink2); line-height:1.5; margin:0 0 16px; flex:1;">
                <?= Esc::html(mb_strimwidth($p['short_description'] ?? '', 0, 90, '...')) ?>
              </p>
              <div style="display:flex; align-items:baseline; gap:8px; margin-bottom:16px;">
                <b style="font-size:18px; font-weight:700; color:var(--ink);"><?= Format::money($p['price']) ?></b>
                <?php if (!empty($p['compare_at_price'])): ?>
                  <s style="font-size:14px; color:var(--muted);"><?= Format::money($p['compare_at_price']) ?></s>
                  <span style="font-size:12px; color:#059669; font-weight:600;">Save <?= Format::discountPercent($p['price'], $p['compare_at_price']) ?>%</span>
                <?php endif; ?>
              </div>
              <div style="display:flex; gap:8px;">
                <button type="button" class="btn btn-k sm" style="width:100%;" data-add="<?= $p['id'] ?>">Add to bag</button>
              </div>
            </div>
          </article>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </div>
</div>
