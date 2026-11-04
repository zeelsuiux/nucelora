<?php
use App\Config\App;
use App\Helpers\Esc;
use App\Helpers\Format;
?>
<div class="card" data-h="<?= Esc::attr($p['slug']) ?>">
  <div class="ph" style="aspect-ratio:1/1; background:var(--soft2); border-radius:12px; overflow:hidden; position:relative;">
    <a href="<?= App::baseUrl('products/' . $p['slug']) ?>" style="display:block; width:100%; height:100%;">
      <img src="<?= Esc::attr($p['image_url'] ?? App::asset('images/placeholder.jpg')) ?>" class="pk" alt="<?= Esc::attr($p['title']) ?>" loading="lazy" style="width:100%; height:100%; object-fit:contain;">
    </a>
    <button type="button" class="fav on" data-fav="<?= Esc::attr($p['slug']) ?>" aria-label="Remove from wishlist" style="position:absolute; top:10px; right:10px; width:34px; height:34px; border-radius:50%; background:#fff; border:1px solid var(--line); display:flex; align-items:center; justify-content:center; cursor:pointer; color:#dc2626; box-shadow:0 2px 6px rgba(0,0,0,0.06);">
      <svg viewBox="0 0 24 24" fill="currentColor" stroke="currentColor" stroke-width="1.6" style="width:18px; height:18px;"><path d="M12 20s-7.5-4.6-9.2-9.3C1.6 7.2 4 4 7.3 4c2 0 3.6 1.1 4.7 2.7C13.1 5.1 14.7 4 16.7 4 20 4 22.4 7.2 21.2 10.7 19.5 15.4 12 20 12 20Z"/></svg>
    </button>
  </div>
  <div class="pi" style="padding:14px 4px 6px;">
    <span class="pt" style="font-size:11.5px; color:var(--muted); text-transform:uppercase; letter-spacing:0.04em;"><?= Esc::html($p['category_name'] ?? 'Botanical Skincare') ?></span>
    <h3 class="pn" style="font-size:15px; font-weight:600; margin:4px 0 8px; line-height:1.35;">
      <a href="<?= App::baseUrl('products/' . $p['slug']) ?>" style="color:var(--ink); text-decoration:none;"><?= Esc::html($p['title']) ?></a>
    </h3>
    <div class="pr" style="display:flex; align-items:baseline; gap:8px; margin-bottom:12px;">
      <b style="font-size:16px; color:var(--or); font-weight:700;"><?= Format::money($p['price']) ?></b>
      <?php if (!empty($p['compare_at_price'])): ?>
        <s style="font-size:13px; color:var(--muted);"><?= Format::money($p['compare_at_price']) ?></s>
      <?php endif; ?>
    </div>
    <button type="button" class="btn btn-k sm add" onclick="window.Lymko.addItems([{ id: <?= (int)$p['id'] ?>, quantity: 1 }])" style="width:100%; border-radius:99px; font-size:12.5px; padding:8px 0;">
      + Add to Bag
    </button>
  </div>
</div>
