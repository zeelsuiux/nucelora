<?php
use App\Config\App;
use App\Helpers\Esc;
use App\Helpers\Format;
?>

<div class="page" style="padding:40px 0 90px; background:#faf9f6; min-height:80vh;">
  <div class="w" style="max-width:1140px; margin:0 auto; padding:0 16px;">
    
    <!-- Search Header -->
    <div style="border-bottom:1px solid var(--line); padding-bottom:28px; margin-bottom:36px;">
      <nav style="font-size:13px; color:var(--muted); margin-bottom:14px;">
        <a href="<?= App::baseUrl() ?>">Home</a> &rarr; <span>Search Results</span>
      </nav>
      
      <div style="display:flex; justify-content:space-between; align-items:flex-end; flex-wrap:wrap; gap:16px;">
        <div>
          <h1 class="h1" style="font-size:32px; font-weight:700; margin:0 0 8px; color:var(--ink);">
            <?php if (!empty($query)): ?>
              Results for &ldquo;<?= Esc::html($query) ?>&rdquo;
            <?php else: ?>
              Search All Products
            <?php endif; ?>
          </h1>
          <p style="color:var(--muted); margin:0; font-size:14.5px;">
            <?= count($products) ?> formulation<?= count($products) === 1 ? '' : 's' ?> found
          </p>
        </div>

        <!-- Inline search box to refine query -->
        <form action="<?= App::baseUrl('search') ?>" method="GET" style="display:flex; gap:8px; width:100%; max-width:380px;">
          <input type="search" name="q" value="<?= Esc::attr($query ?? '') ?>" placeholder="Search another concern, serum, SPF..." style="flex:1; height:44px; padding:0 14px; border:1px solid var(--line); border-radius:8px; font-size:14px; outline:none; background:#fff;">
          <button type="submit" class="btn btn-k sm" style="height:44px; padding:0 18px; border-radius:8px; font-weight:600;">Search</button>
        </form>
      </div>
    </div>

    <!-- Products Grid -->
    <?php if (empty($products)): ?>
      <div style="background:#fff; border:1px solid var(--line); border-radius:16px; padding:70px 24px; text-align:center; max-width:640px; margin:0 auto;">
        <div style="width:64px; height:64px; border-radius:50%; background:var(--orsoft); border:1px solid rgba(181, 141, 78, 0.25); display:flex; align-items:center; justify-content:center; color:var(--or); margin:0 auto 20px;">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" style="width:26px; height:26px;"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
        </div>
        <h3 style="font-size:22px; font-weight:700; margin:0 0 10px; color:var(--ink);">No formulations found</h3>
        <p style="margin:0 0 28px; color:var(--muted); font-size:14.5px;">
          We couldn't find any products matching &ldquo;<?= Esc::html($query) ?>&rdquo;. Try searching for "serum", "vitamin c", "acne", "sunscreen", or browse our full catalogue.
        </p>
        <div style="display:flex; gap:12px; justify-content:center; flex-wrap:wrap;">
          <a href="<?= App::baseUrl('collections/all') ?>" class="btn btn-k" style="padding:12px 28px; border-radius:99px;">Browse All Products &rarr;</a>
          <a href="<?= App::baseUrl('pages/routine-finder') ?>" class="btn btn-l" style="padding:12px 24px; border-radius:99px;">Take Routine Finder Quiz</a>
        </div>
      </div>
    <?php else: ?>
      <div class="cards-grid" style="display:grid; grid-template-columns:repeat(auto-fill, minmax(260px, 1fr)); gap:24px;">
        <?php foreach ($products as $p): ?>
          <article class="p-card" style="background:#fff; border:1px solid var(--line); border-radius:12px; overflow:hidden; display:flex; flex-direction:column; position:relative; box-shadow:0 2px 8px rgba(0,0,0,0.02); transition:transform 0.2s, box-shadow 0.2s;">
            <?php if (!empty($p['badge_text'])): ?>
              <span class="p-badge" style="position:absolute; top:12px; left:12px; background:var(--orsoft); color:var(--or); font-size:11px; font-weight:700; padding:4px 8px; border-radius:4px; z-index:2; border:1px solid rgba(181, 141, 78, 0.25);">
                <?= Esc::html($p['badge_text']) ?>
              </span>
            <?php endif; ?>
            <a href="<?= App::baseUrl('products/' . $p['slug']) ?>" style="display:block; overflow:hidden; background:var(--soft2); text-align:center; aspect-ratio:1/1;">
              <img src="<?= Esc::attr($p['image_url'] ?? App::asset('images/placeholder.jpg')) ?>" alt="<?= Esc::attr($p['title']) ?>" loading="lazy" style="width:100%; height:100%; object-fit:contain;">
            </a>
            <div style="padding:18px; display:flex; flex-direction:column; flex:1;">
              <span style="font-size:11.5px; color:var(--muted); text-transform:uppercase; letter-spacing:0.04em; margin-bottom:4px;">
                <?= Esc::html($p['category_name'] ?? 'Skincare') ?> &middot; <?= Esc::html($p['size_volume']) ?>
              </span>
              <h4 style="font-size:15.5px; font-weight:600; margin:0 0 8px; line-height:1.4;">
                <a href="<?= App::baseUrl('products/' . $p['slug']) ?>" style="color:var(--ink); text-decoration:none;"><?= Esc::html($p['title']) ?></a>
              </h4>
              <p style="font-size:12.5px; color:var(--ink2); line-height:1.5; margin:0 0 14px; flex:1;">
                <?= Esc::html(mb_strimwidth($p['short_description'] ?? '', 0, 80, '...')) ?>
              </p>
              <div style="display:flex; justify-content:space-between; align-items:center; margin-top:auto; padding-top:12px; border-top:1px solid var(--line);">
                <b style="font-size:16px; font-weight:700; color:var(--or);"><?= Format::money($p['price']) ?></b>
                <button type="button" class="btn btn-k sm" onclick="window.Lymko.addItems([{ id: <?= (int)$p['id'] ?>, quantity: 1 }])" style="padding:6px 14px; font-size:12px; border-radius:99px;">
                  + Add to Bag
                </button>
              </div>
            </div>
          </article>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>

  </div>
</div>
