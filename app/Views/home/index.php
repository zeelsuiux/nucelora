<?php
use App\Config\App;
use App\Helpers\Esc;
use App\Helpers\Format;

$spotlightItems = [
    [
        'title' => 'Vitamin C Brightening Face Serum',
        'slug' => 'vitamin-c-brightening-face-serum',
        'id' => 1,
        'img' => 'lk-ps-vitamin-c-brightening-face-serum.webp',
        'tint' => '#FBEEE7',
        'price' => 'Rs. 499',
        'mrp' => 'Rs. 999',
        'tag' => '−50% · Face serum',
        'chips' => 'Ethyl Ascorbic Acid|Hyaluronic Acid|Acacia Senegal Gum|Propylene Glycol'
    ],
    [
        'title' => 'Niacinamide Face Serum',
        'slug' => 'niacinamide-face-serum',
        'id' => 2,
        'img' => 'lk-ps-niacinamide-face-serum.webp',
        'tint' => '#E9EFFA',
        'price' => 'Rs. 549',
        'mrp' => 'Rs. 999',
        'tag' => '−45% · Face serum',
        'chips' => 'Niacinamide|Hyaluronic Acid|Sodium Hyaluronate|Betaine'
    ],
    [
        'title' => 'Night Skin Face Serum',
        'slug' => 'night-skin-face-serum',
        'id' => 3,
        'img' => 'lk-ps-night-skin-face-serum.webp',
        'tint' => '#F0EBFA',
        'price' => 'Rs. 1,399',
        'mrp' => 'Rs. 1,899',
        'tag' => '−26% · Face serum',
        'chips' => 'Niacinamide|Alpha Arbutin|Hyaluronic Acid|Tranexamic Acid|Glutathione|Green Tea Extract|Olive Oil PEG-7 Esters|Alpinia Katsumadai Seed Extract|Geranium Robertianum Extract|Nano Bio Silver Technology|Nano Bio Quantum Technology'
    ],
    [
        'title' => 'SPF 50 Sunscreen Spray',
        'slug' => 'spf-50-sunscreen-spray',
        'id' => 4,
        'img' => 'lk-ps-spf-50-sunscreen-spray.webp',
        'tint' => '#FCF4DB',
        'price' => 'Rs. 549',
        'mrp' => 'Rs. 799',
        'tag' => '−31% · Sunscreen',
        'chips' => 'Shea Butter|Almond Oil|Moringa Oleifera Seed Oil|Biosaccharide Gum-4|Sunscreen Actives'
    ],
    [
        'title' => 'Pigmentation Correcting Serum',
        'slug' => 'pigmentation-correcting-serum',
        'id' => 5,
        'img' => 'lk-ps-pigmentation-correcting-serum.webp',
        'tint' => '#F9ECF3',
        'price' => 'Rs. 1,399',
        'mrp' => 'Rs. 1,899',
        'tag' => '−26% · Face serum',
        'chips' => 'Niacinamide|Tranexamic Acid|Alpha Arbutin|Glutathione|Nano Bio Silver Technology|Nano Bio Quantum Technology'
    ],
    [
        'title' => 'Vitamin E Moisturizer with Sodium Hyaluronate & Allantoin',
        'slug' => 'vitamin-e-moisturizer-with-sodium-hyaluronate-allantoin',
        'id' => 6,
        'img' => 'lk-ps-vitamin-e-moisturizer-with-sodium-hyaluronate-allantoin.webp',
        'tint' => '#ECF1F9',
        'price' => 'Rs. 499',
        'mrp' => 'Rs. 649',
        'tag' => '−23% · Moisturizer',
        'chips' => 'Vitamin E|Sodium Hyaluronate|Allantoin|Acacia Senegal Gum|Urea|Triethanolamine'
    ],
    [
        'title' => 'Anti Acne Face Serum',
        'slug' => 'anti-acne-face-serum',
        'id' => 7,
        'img' => 'lk-ps-anti-acne-face-serum.webp',
        'tint' => '#EEF2E1',
        'price' => 'Rs. 1,399',
        'mrp' => 'Rs. 1,899',
        'tag' => '−26% · Face serum',
        'chips' => 'Salicylic Acid|Hyaluronic Acid|Green Tea Extract|Willow Bark Extract|Soyabean Seed Extract|Nano Bio Silver Technology|Nano Bio Quantum Technology'
    ],
    [
        'title' => 'Under Eye Face Serum',
        'slug' => 'under-eye-face-serum',
        'id' => 8,
        'img' => 'lk-ps-under-eye-face-serum.webp',
        'tint' => '#ECEEF1',
        'price' => 'Rs. 1,399',
        'mrp' => 'Rs. 1,899',
        'tag' => '−26% · Face serum',
        'chips' => 'Hyaluronic Acid|Palmitoyl Tripeptide-5|Panthenol|Sodium Hyaluronate|Green Tea Extract|Dunaliella Salina Extract|Nano Bio Quantum Technology|Nano Bio Silver Technology'
    ],
];

$shelfItems = [
    ['slug' => 'scalp-repair-shampoo', 'title' => 'Scalp Repair Shampoo', 'img' => 'lk-ps-scalp-repair-shampoo.webp', 'delay' => '0.6s'],
    ['slug' => 'niacinamide-rice-water-face-wash', 'title' => 'Niacinamide & Rice Water Face Wash', 'img' => 'lk-ps-niacinamide-rice-water-face-wash.webp', 'delay' => '0.66s'],
    ['slug' => 'anti-acne-face-serum', 'title' => 'Anti Acne Face Serum', 'img' => 'lk-ps-anti-acne-face-serum.webp', 'delay' => '0.72s'],
    ['slug' => 'vitamin-c-brightening-face-serum', 'title' => 'Vitamin C Brightening Face Serum', 'img' => 'lk-ps-vitamin-c-brightening-face-serum.webp', 'delay' => '0.78s'],
    ['slug' => 'niacinamide-face-serum', 'title' => 'Niacinamide Face Serum', 'img' => 'lk-ps-niacinamide-face-serum.webp', 'delay' => '0.84s'],
    ['slug' => 'vitamin-e-moisturizer-with-sodium-hyaluronate-allantoin', 'title' => 'Vitamin E Moisturizer with Sodium Hyaluronate & Allantoin', 'img' => 'lk-ps-vitamin-e-moisturizer-with-sodium-hyaluronate-allantoin.webp', 'delay' => '0.9s'],
    ['slug' => 'retinol-anti-aging-serum', 'title' => 'Retinol Anti-Aging Serum', 'img' => 'lk-ps-retinol-anti-aging-serum.webp', 'delay' => '0.96s'],
    ['slug' => 'pigmentation-correcting-serum', 'title' => 'Pigmentation Correcting Serum', 'img' => 'lk-ps-pigmentation-correcting-serum.webp', 'delay' => '1.02s'],
    ['slug' => 'spf-50-sunscreen-spray', 'title' => 'SPF 50 Sunscreen Spray', 'img' => 'lk-ps-spf-50-sunscreen-spray.webp', 'delay' => '1.08s'],
    ['slug' => 'night-skin-face-serum', 'title' => 'Night Skin Face Serum', 'img' => 'lk-ps-night-skin-face-serum.webp', 'delay' => '1.14s'],
    ['slug' => 'under-eye-face-serum', 'title' => 'Under Eye Face Serum', 'img' => 'lk-ps-under-eye-face-serum.webp', 'delay' => '1.2s'],
    ['slug' => 'hair-finishing-stick-white', 'title' => 'Hair Finishing Stick White', 'img' => 'lk-ps-hair-finishing-stick-white.webp', 'delay' => '1.26s'],
    ['slug' => 'hair-finishing-stick', 'title' => 'Hair Finishing Stick', 'img' => 'lk-ps-hair-finishing-stick.webp', 'delay' => '1.32s'],
];
?>

<!-- 1. Hero Spotlight Section -->
<section class="hero" aria-label="Featured">
  <div class="w hero-g">
    <div class="hero-l">
      <span class="lab o fin">Skincare | Haircare</span>
      <h1 class="h1" style="margin-top:22px">
        <span class="ln"><span>Good skin.</span></span>
        <span class="ln"><span>Better <em>you.</em></span></span>
      </h1>
      <p class="p fin" style="animation-delay:.4s">
        Real care, visible glow. Korean-inspired formulas powered by nature and backed by science — paraben free, sulphate free and cruelty free.
      </p>
      <div class="hero-cta fin" style="animation-delay:.55s">
        <a href="<?= App::baseUrl('collections/all') ?>" class="btn btn-k">Shop the range <span class="ar">&rarr;</span></a>
        <a href="<?= App::baseUrl('pages/routine-finder') ?>" class="btn btn-l">Find my routine</a>
      </div>
      <div class="hero-meta fin" style="animation-delay:.7s">
        <div><b>4.94 &#9733;</b><span>Store rating &middot; 17 reviews</span></div>
        <div><b>27</b><span>Products &amp; rituals</span></div>
        <div><b>Free</b><span>Shipping in India</span></div>
      </div>
    </div>

    <!-- Interactive Carousel Spotlight matching reference lymko.in -->
    <div class="spot" id="spot" data-spot aria-roledescription="carousel" aria-label="Featured products">
      <div class="spot-ring"></div>
      <div class="spot-ring r2"></div>
      
      <div class="spot-dots" id="spd">
        <?php foreach ($spotlightItems as $idx => $sp): ?>
          <button type="button" data-sp="<?= $idx ?>" aria-label="Show <?= Esc::attr($sp['title']) ?>"></button>
        <?php endforeach; ?>
      </div>

      <span class="spot-tag" id="spt"></span>
      
      <div class="spot-img" id="spi">
        <?php foreach ($spotlightItems as $idx => $sp): ?>
          <img src="<?= App::asset('images/bottles/' . $sp['img']) ?>" 
               alt="<?= Esc::attr($sp['title']) ?>" 
               width="700" height="1000"
               data-name="<?= Esc::attr($sp['title']) ?>"
               data-url="<?= App::baseUrl('products/' . $sp['slug']) ?>"
               data-variant="<?= $sp['id'] ?>"
               data-tint="<?= $sp['tint'] ?>"
               data-price="<?= $sp['price'] ?>"
               data-mrp="<?= $sp['mrp'] ?>"
               data-tag="<?= $sp['tag'] ?>"
               data-chips="<?= $sp['chips'] ?>">
        <?php endforeach; ?>
      </div>

      <div hidden aria-hidden="true">
        <div class="chip-f c1"><i>&#10022;</i><span id="ch1"></span></div>
        <div class="chip-f c2"><i>&#10022;</i><span id="ch2"></span></div>
        <div class="chip-f c3"><i>&#10022;</i><span id="ch3"></span></div>
      </div>
      <div class="lk-chips" id="lkch" aria-hidden="true" hidden></div>

      <div class="spot-info">
        <div style="min-width:0">
          <div class="nm" id="spn"></div>
          <div class="pr" id="spp"></div>
        </div>
        <div class="spot-go">
          <a id="spv" href="<?= App::baseUrl('collections/all') ?>">View</a>
          <button type="button" id="spa" data-add="">Add to bag</button>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- 2. The Range Shelf Track -->
<section class="shelf lk-shelf" aria-label="The range">
  <div class="w">
    <div class="shelf-row">
      <div class="shelf-track">
        <?php foreach ($shelfItems as $s): ?>
          <a href="<?= App::baseUrl('products/' . $s['slug']) ?>" aria-label="<?= Esc::attr($s['title']) ?>">
            <img src="<?= App::asset('images/bottles/' . $s['img']) ?>" alt="" style="animation-delay:<?= $s['delay'] ?>" width="200" height="300">
            <span><?= Esc::html($s['title']) ?></span>
          </a>
        <?php endforeach; ?>
        <?php foreach ($shelfItems as $s): ?>
          <a class="lk-dup" href="<?= App::baseUrl('products/' . $s['slug']) ?>" aria-hidden="true" tabindex="-1">
            <img src="<?= App::asset('images/bottles/' . $s['img']) ?>" alt="" loading="lazy" width="200" height="300">
          </a>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</section>

<!-- 3. Skin Concern Finder Tabs ("What does your skin need?") -->
<section class="sec lkbs" data-finder>
  <div class="w">
    <div class="sec-h" style="display:flex; justify-content:space-between; align-items:flex-end; margin-bottom:32px;">
      <div>
        <span class="lab o">Targeted care</span>
        <h2 class="h2">What does your skin need?</h2>
      </div>
      <a href="<?= App::baseUrl('pages/routine-finder') ?>" class="btn btn-l sm d-only">Take Routine Quiz &rarr;</a>
    </div>

    <!-- Concern Tabs Buttons -->
    <div class="cons" role="tablist" style="display:flex; gap:8px; overflow-x:auto; padding-bottom:12px; margin-bottom:28px;">
      <button type="button" class="con-btn on" data-con="0" role="tab" aria-selected="true">Acne &amp; Blemishes</button>
      <button type="button" class="con-btn" data-con="1" role="tab" aria-selected="false">Dark Spots &amp; Pigmentation</button>
      <button type="button" class="con-btn" data-con="2" role="tab" aria-selected="false">Fine Lines &amp; Aging</button>
      <button type="button" class="con-btn" data-con="3" role="tab" aria-selected="false">Dehydration &amp; Dryness</button>
      <button type="button" class="con-btn" data-con="4" role="tab" aria-selected="false">Instant Glow</button>
    </div>

    <!-- Concern Tab Panels -->
    <?php
    $concerns = [
      0 => ['key' => 'acne', 'title' => 'Anti Acne Face Serum', 'lab' => 'Acne · Clear, calm-looking skin', 'bg' => '#EEF2E1'],
      1 => ['key' => 'pigmentation', 'title' => 'Pigmentation Correcting Serum', 'lab' => 'Tone · Even, radiant complexion', 'bg' => '#F9ECF3'],
      2 => ['key' => 'anti-aging', 'title' => 'Retinol Anti-Aging Serum', 'lab' => 'Aging · Smooth, firm renewal', 'bg' => '#F0EBFA'],
      3 => ['key' => 'hydration', 'title' => 'Vitamin E Moisturizer with Sodium Hyaluronate', 'lab' => 'Moisture · Deep hydration barrier', 'bg' => '#ECF1F9'],
      4 => ['key' => 'glow', 'title' => 'Vitamin C Brightening Face Serum', 'lab' => 'Glow · Natural daytime radiance', 'bg' => '#FBEEE7']
    ];
    ?>

    <?php foreach ($concerns as $cIdx => $c): 
      // Find matching product
      $matchProd = null;
      foreach ($allProducts as $p) {
        if (stripos($p['title'], explode(' ', $c['title'])[0]) !== false || $p['skin_concern'] === $c['key']) {
          $matchProd = $p;
          break;
        }
      }
      if (!$matchProd) $matchProd = $allProducts[0];
    ?>
      <div class="f-card" role="tabpanel" data-panel="<?= $cIdx ?>" style="background:<?= $c['bg'] ?>;" <?= $cIdx !== 0 ? 'hidden' : '' ?>>
        <div class="f-img">
          <img src="<?= Esc::attr($matchProd['image_url'] ?? App::asset('images/placeholder.jpg')) ?>" alt="<?= Esc::attr($matchProd['title']) ?>" loading="lazy" width="500" height="700">
        </div>
        <div class="f-txt">
          <span class="lab o"><?= $c['lab'] ?></span>
          <h3 class="h3"><?= Esc::html($matchProd['title']) ?></h3>
          <p><?= Esc::html($matchProd['short_description']) ?></p>
          <div class="pdp-pr" style="margin:20px 0;">
            <b data-price><?= Format::money($matchProd['price']) ?></b>
            <?php if (!empty($matchProd['compare_at_price'])): ?>
              <s data-compare><?= Format::money($matchProd['compare_at_price']) ?></s>
              <span data-save>Save <?= Format::discountPercent($matchProd['price'], $matchProd['compare_at_price']) ?>%</span>
            <?php endif; ?>
          </div>
          <div class="f-act" style="display:flex; gap:12px;">
            <a href="<?= App::baseUrl('products/' . $matchProd['slug']) ?>" class="btn btn-k">View details</a>
            <button type="button" class="btn btn-l" data-add="<?= $matchProd['id'] ?>">Quick add to bag</button>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</section>

<!-- 4. Best Sellers Grid Section -->
<section class="sec" style="padding-top:40px;">
  <div class="w">
    <div class="sec-h" style="display:flex; justify-content:space-between; align-items:flex-end; margin-bottom:32px;">
      <div>
        <span class="lab o">Most Loved</span>
        <h2 class="h2">Everyone's favourites.</h2>
      </div>
      <a href="<?= App::baseUrl('collections/best-selling') ?>" class="btn btn-l sm">View all <?= count($allProducts) ?> products &rarr;</a>
    </div>

    <div class="cards-grid" style="display:grid; grid-template-columns:repeat(auto-fill, minmax(260px, 1fr)); gap:24px;">
      <?php foreach ($bestSellers as $bp): ?>
        <article class="p-card" style="background:#fff; border:1px solid var(--line); border-radius:8px; overflow:hidden; display:flex; flex-direction:column; position:relative;">
          <?php if (!empty($bp['badge_text'])): ?>
            <span class="p-badge" style="position:absolute; top:12px; left:12px; background:var(--orsoft); color:var(--or); font-size:12px; font-weight:600; padding:4px 8px; border-radius:4px; z-index:2;">
              <?= Esc::html($bp['badge_text']) ?>
            </span>
          <?php endif; ?>
          <a href="<?= App::baseUrl('products/' . $bp['slug']) ?>" style="display:block; overflow:hidden; background:var(--soft2); text-align:center;">
            <img src="<?= Esc::attr($bp['image_url'] ?? App::asset('images/placeholder.jpg')) ?>" alt="<?= Esc::attr($bp['title']) ?>" loading="lazy" style="width:100%; height:320px; object-fit:cover; transition:transform 0.4s var(--e);">
          </a>
          <div style="padding:18px; display:flex; flex-direction:column; flex:1;">
            <span style="font-size:12px; color:var(--muted); text-transform:uppercase; letter-spacing:0.04em; margin-bottom:4px;"><?= Esc::html($bp['category_name'] ?? 'Skincare') ?></span>
            <h4 style="font-size:16px; font-weight:600; margin:0 0 10px; line-height:1.4;">
              <a href="<?= App::baseUrl('products/' . $bp['slug']) ?>"><?= Esc::html($bp['title']) ?></a>
            </h4>
            <div style="display:flex; align-items:baseline; gap:8px; margin-bottom:14px;">
              <b style="font-size:17px; font-weight:700; color:var(--ink);"><?= Format::money($bp['price']) ?></b>
              <?php if (!empty($bp['compare_at_price'])): ?>
                <s style="font-size:14px; color:var(--muted);"><?= Format::money($bp['compare_at_price']) ?></s>
              <?php endif; ?>
            </div>
            <div style="margin-top:auto; display:flex; gap:8px;">
              <button type="button" class="btn btn-k sm" style="width:100%;" data-add="<?= $bp['id'] ?>">Add to bag</button>
            </div>
          </div>
        </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- 5. Four Steps Routine Section ("Four steps. Every day.") -->
<section class="sec" data-routine style="background:var(--soft); padding:80px 0; margin:60px 0;">
  <div class="w">
    <div style="text-align:center; max-width:640px; margin:0 auto 40px;">
      <span class="lab o">The Ritual Blueprint</span>
      <h2 class="h2" style="margin-top:10px;">Four steps. Every day.</h2>
      <p class="p" style="margin-top:8px;">A simplified, intuitive system that balances, treats, and defends your skin around the clock.</p>
    </div>

    <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(220px, 1fr)); gap:20px;">
      <div style="background:#fff; padding:28px 24px; border-radius:8px; border:1px solid var(--line);">
        <span style="font-family:var(--serif); font-size:32px; color:var(--or); font-style:italic;">01</span>
        <h4 style="font-size:18px; margin:10px 0 6px;">Cleanse</h4>
        <p style="font-size:14px; color:var(--ink2); line-height:1.5;">Wash away impurities, excess sebum, and pollution without stripping the lipid barrier.</p>
        <a href="<?= App::baseUrl('collections/face-wash') ?>" style="display:inline-block; margin-top:12px; font-size:13px; font-weight:600; color:var(--or);">View cleansers &rarr;</a>
      </div>

      <div style="background:#fff; padding:28px 24px; border-radius:8px; border:1px solid var(--line);">
        <span style="font-family:var(--serif); font-size:32px; color:var(--or); font-style:italic;">02</span>
        <h4 style="font-size:18px; margin:10px 0 6px;">Treat</h4>
        <p style="font-size:14px; color:var(--ink2); line-height:1.5;">Infuse high-potency bio-active serums targeting acne, dullness, or uneven texture.</p>
        <a href="<?= App::baseUrl('collections/face-serums') ?>" style="display:inline-block; margin-top:12px; font-size:13px; font-weight:600; color:var(--or);">View serums &rarr;</a>
      </div>

      <div style="background:#fff; padding:28px 24px; border-radius:8px; border:1px solid var(--line);">
        <span style="font-family:var(--serif); font-size:32px; color:var(--or); font-style:italic;">03</span>
        <h4 style="font-size:18px; margin:10px 0 6px;">Moisturize</h4>
        <p style="font-size:14px; color:var(--ink2); line-height:1.5;">Lock in moisture with Sodium Hyaluronate &amp; Vitamin E for all-day skin barrier integrity.</p>
        <a href="<?= App::baseUrl('collections/moisturizer') ?>" style="display:inline-block; margin-top:12px; font-size:13px; font-weight:600; color:var(--or);">View moisturizers &rarr;</a>
      </div>

      <div style="background:#fff; padding:28px 24px; border-radius:8px; border:1px solid var(--line);">
        <span style="font-family:var(--serif); font-size:32px; color:var(--or); font-style:italic;">04</span>
        <h4 style="font-size:18px; margin:10px 0 6px;">Protect</h4>
        <p style="font-size:14px; color:var(--ink2); line-height:1.5;">Shield against photo-aging, UVA, and UVB rays with ultra-lightweight SPF 50 spray.</p>
        <a href="<?= App::baseUrl('collections/sunscreen') ?>" style="display:inline-block; margin-top:12px; font-size:13px; font-weight:600; color:var(--or);">View sunscreens &rarr;</a>
      </div>
    </div>
  </div>
</section>

<!-- 6. Curated Rituals Section -->
<section class="sec lk-rs" data-rituals style="padding-bottom:60px;">
  <div class="w">
    <div class="sec-h" style="display:flex; justify-content:space-between; align-items:flex-end; margin-bottom:32px;">
      <div>
        <span class="lab o">Complete Routines</span>
        <h2 class="h2">Rituals, curated.</h2>
      </div>
      <div style="display:flex; gap:8px;">
        <button type="button" class="ib" data-rrail="-1" aria-label="Previous rituals"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" style="width:20px;height:20px;"><path d="m15 18-6-6 6-6"/></svg></button>
        <button type="button" class="ib" data-rrail="1" aria-label="Next rituals"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" style="width:20px;height:20px;"><path d="m9 18 6-6-6-6"/></svg></button>
      </div>
    </div>

    <div class="rail-scroll" id="rrail" style="display:flex; gap:20px; overflow-x:auto; scroll-snap-type:x mandatory; padding-bottom:16px;">
      <?php foreach ($rituals as $rp): ?>
        <div class="card" style="flex:0 0 300px; scroll-snap-align:start; background:#fff; border:1px solid var(--line); border-radius:8px; overflow:hidden;">
          <a href="<?= App::baseUrl('products/' . $rp['slug']) ?>">
            <img src="<?= Esc::attr($rp['image_url'] ?? App::asset('images/placeholder.jpg')) ?>" alt="<?= Esc::attr($rp['title']) ?>" loading="lazy" style="width:100%; height:260px; object-fit:cover;">
          </a>
          <div style="padding:16px;">
            <span class="lab o" style="font-size:11px;">Curated Ritual Set</span>
            <h4 style="font-size:16px; margin:6px 0 10px; line-height:1.3;">
              <a href="<?= App::baseUrl('products/' . $rp['slug']) ?>"><?= Esc::html($rp['title']) ?></a>
            </h4>
            <div style="display:flex; gap:8px; align-items:baseline; margin-bottom:12px;">
              <b style="font-size:16px;"><?= Format::money($rp['price']) ?></b>
              <?php if (!empty($rp['compare_at_price'])): ?>
                <s style="font-size:13px; color:var(--muted);"><?= Format::money($rp['compare_at_price']) ?></s>
              <?php endif; ?>
            </div>
            <button type="button" class="btn btn-k sm" style="width:100%;" data-add="<?= $rp['id'] ?>">Add bundle to bag</button>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- Nucelora Homepage Young Female Voice Greeting -->
<audio id="nucelora-welcome-audio" preload="auto">
  <source src="<?= App::baseUrl('public/assets/audio/welcome.mp3') ?>" type="audio/mpeg">
</audio>

<button type="button" id="nucelora-voice-pill" aria-label="Play welcome greeting" style="position:fixed; bottom:26px; left:24px; z-index:998; background:rgba(20,20,20,0.92); backdrop-filter:blur(8px); -webkit-backdrop-filter:blur(8px); color:#fff; border:1px solid rgba(181,141,78,0.45); border-radius:99px; padding:9px 16px; font-size:12.5px; font-weight:600; display:inline-flex; align-items:center; gap:8px; cursor:pointer; box-shadow:0 6px 22px rgba(0,0,0,0.2); transition:all 0.3s ease; user-select:none;">
  <span id="nucelora-voice-icon" style="display:inline-flex; width:18px; height:18px; align-items:center; justify-content:center; color:var(--or);">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:16px; height:16px;"><polygon points="11 5 6 9 2 9 2 15 6 15 11 19 11 5"/><path d="M19.07 4.93a10 10 0 0 1 0 14.14M15.54 8.46a5 5 0 0 1 0 7.07"/></svg>
  </span>
  <span id="nucelora-voice-label">Welcome Voice</span>
</button>

<script>
(function() {
  const audio = document.getElementById('nucelora-welcome-audio');
  const pill = document.getElementById('nucelora-voice-pill');
  const icon = document.getElementById('nucelora-voice-icon');
  const label = document.getElementById('nucelora-voice-label');
  let hasTriggered = false;

  function speakViaWebSpeech() {
    if (!('speechSynthesis' in window)) return;
    window.speechSynthesis.cancel();
    const utter = new SpeechSynthesisUtterance("Welcome to Nucelora Advanced Skincare.");
    utter.lang = 'en-US';
    utter.rate = 0.95;  // relaxed, elegant pace
    utter.pitch = 1.18; // higher pitch = young, fresh female tone

    const voices = window.speechSynthesis.getVoices();
    const femaleVoice = voices.find(v => 
      (v.lang.startsWith('en') && (v.name.includes('Female') || v.name.includes('Zira') || v.name.includes('Samantha') || v.name.includes('Victoria') || v.name.includes('Karen') || v.name.includes('Natural')))
    ) || voices.find(v => v.lang.startsWith('en'));

    if (femaleVoice) {
      utter.voice = femaleVoice;
    }

    utter.onstart = () => animatePillStart();
    utter.onend = () => animatePillEnd();
    window.speechSynthesis.speak(utter);
  }

  function animatePillStart() {
    if (pill) {
      pill.style.borderColor = 'var(--or)';
      pill.style.boxShadow = '0 6px 24px rgba(181,141,78,0.35)';
      pill.style.transform = 'scale(1.04)';
    }
    if (label) label.textContent = 'Welcome to Nucelora...';
    if (icon) {
      icon.innerHTML = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" style="width:16px; height:16px; animation:spin 2s linear infinite;"><path d="M12 2v4m0 12v4M4.93 4.93l2.83 2.83m8.48 8.48 2.83 2.83M2 12h4m12 0h4M4.93 19.07l2.83-2.83m8.48-8.48 2.83-2.83"/></svg>';
    }
  }

  function animatePillEnd() {
    if (pill) {
      pill.style.borderColor = 'rgba(181,141,78,0.45)';
      pill.style.boxShadow = '0 6px 22px rgba(0,0,0,0.2)';
      pill.style.transform = 'scale(1)';
    }
    if (label) label.textContent = 'Replay Voice';
    if (icon) {
      icon.innerHTML = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:16px; height:16px;"><polygon points="11 5 6 9 2 9 2 15 6 15 11 19 11 5"/><path d="M19.07 4.93a10 10 0 0 1 0 14.14M15.54 8.46a5 5 0 0 1 0 7.07"/></svg>';
    }
  }

  function playWelcomeGreeting() {
    if (hasTriggered) return;
    hasTriggered = true;

    if (audio) {
      audio.currentTime = 0;
      const promise = audio.play();
      if (promise !== undefined) {
        promise.then(() => {
          animatePillStart();
          audio.onended = () => animatePillEnd();
        }).catch(() => {
          // If browser policy blocked unmuted audio, fallback or wait for gesture
          hasTriggered = false;
        });
      }
    } else {
      speakViaWebSpeech();
    }
  }

  // 1. Trigger immediately on page load
  window.addEventListener('load', () => {
    setTimeout(playWelcomeGreeting, 500);
  });

  // 2. Fallback for strict browser autoplay policies: trigger on first user gesture
  const gestures = ['click', 'touchstart', 'scroll', 'keydown'];
  function onFirstUserGesture() {
    if (!hasTriggered) {
      playWelcomeGreeting();
    }
    gestures.forEach(g => window.removeEventListener(g, onFirstUserGesture, { passive: true }));
  }
  gestures.forEach(g => window.addEventListener(g, onFirstUserGesture, { passive: true, once: true }));

  // 3. User can manually tap the pill to play / replay
  if (pill) {
    pill.addEventListener('click', (e) => {
      e.stopPropagation();
      hasTriggered = false;
      playWelcomeGreeting();
    });
  }
})();
</script>

<!-- 7. Manifesto Statement -->
<section class="stmt" data-stmt style="background:#222; color:#fff; padding:90px 24px; text-align:center;">
  <div class="w" style="max-width:840px;">
    <span class="lab" style="color:var(--or);">Our Pledge</span>
    <h2 class="h2" style="font-family:var(--serif); font-size:38px; line-height:1.3; margin:18px 0; color:#fff; font-weight:400;">
      Every Drop a Ritual. Plant Your Tree. Start Your Green Revolution.
    </h2>
    <p style="font-size:16px; color:#aaa; line-height:1.7; max-width:600px; margin:0 auto 24px;">
      For every curated ritual box delivered, we plant a native sapling to restore green cover. Pure ingredients in recyclable glass packaging.
    </p>
    <a href="<?= App::baseUrl('pages/sustainability') ?>" class="btn btn-l sm" style="border-color:#555; color:#fff;">Discover our impact &rarr;</a>
  </div>
</section>

<!-- 8. Real Customer Reviews Section -->
<section class="sec lk-revs" style="padding:80px 0;">
  <div class="w">
    <div style="text-align:center; max-width:640px; margin:0 auto 40px;">
      <span class="lab o">Verified Buyers</span>
      <h2 class="h2">Loved by conscious skin enthusiasts.</h2>
    </div>

    <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(300px, 1fr)); gap:24px;">
      <?php foreach ($reviews as $rev): ?>
        <div style="background:#fff; border:1px solid var(--line); border-radius:8px; padding:24px;">
          <div style="color:#f59e0b; font-size:16px; margin-bottom:8px;">
            <?= str_repeat('&#9733;', (int)$rev['rating']) ?>
          </div>
          <h4 style="font-size:16px; margin-bottom:8px; font-weight:600;"><?= Esc::html($rev['title']) ?></h4>
          <p style="font-size:14px; color:var(--ink2); line-height:1.6; margin-bottom:16px;">
            "<?= Esc::html($rev['content']) ?>"
          </p>
          <div style="display:flex; justify-content:space-between; align-items:center; border-top:1px solid var(--line); padding-top:12px; font-size:13px;">
            <b style="color:var(--ink);"><?= Esc::html($rev['reviewer_name']) ?></b>
            <span style="color:#059669; display:flex; align-items:center; gap:4px;">
              <svg viewBox="0 0 20 20" fill="currentColor" style="width:14px; height:14px;"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg> Verified
            </span>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- Nucelora Homepage Young Female Voice Greeting -->
<audio id="nucelora-welcome-audio" preload="auto">
  <source src="<?= App::baseUrl('public/assets/audio/welcome.mp3') ?>" type="audio/mpeg">
</audio>

<button type="button" id="nucelora-voice-pill" aria-label="Play welcome greeting" style="position:fixed; bottom:26px; left:24px; z-index:998; background:rgba(20,20,20,0.92); backdrop-filter:blur(8px); -webkit-backdrop-filter:blur(8px); color:#fff; border:1px solid rgba(181,141,78,0.45); border-radius:99px; padding:9px 16px; font-size:12.5px; font-weight:600; display:inline-flex; align-items:center; gap:8px; cursor:pointer; box-shadow:0 6px 22px rgba(0,0,0,0.2); transition:all 0.3s ease; user-select:none;">
  <span id="nucelora-voice-icon" style="display:inline-flex; width:18px; height:18px; align-items:center; justify-content:center; color:var(--or);">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:16px; height:16px;"><polygon points="11 5 6 9 2 9 2 15 6 15 11 19 11 5"/><path d="M19.07 4.93a10 10 0 0 1 0 14.14M15.54 8.46a5 5 0 0 1 0 7.07"/></svg>
  </span>
  <span id="nucelora-voice-label">Welcome Voice</span>
</button>

<script>
(function() {
  const audio = document.getElementById('nucelora-welcome-audio');
  const pill = document.getElementById('nucelora-voice-pill');
  const icon = document.getElementById('nucelora-voice-icon');
  const label = document.getElementById('nucelora-voice-label');
  let hasTriggered = false;

  function speakViaWebSpeech() {
    if (!('speechSynthesis' in window)) return;
    window.speechSynthesis.cancel();
    const utter = new SpeechSynthesisUtterance("Welcome to Nucelora Advanced Skincare.");
    utter.lang = 'en-US';
    utter.rate = 0.95;  // relaxed, elegant pace
    utter.pitch = 1.18; // higher pitch = young, fresh female tone

    const voices = window.speechSynthesis.getVoices();
    const femaleVoice = voices.find(v => 
      (v.lang.startsWith('en') && (v.name.includes('Female') || v.name.includes('Zira') || v.name.includes('Samantha') || v.name.includes('Victoria') || v.name.includes('Karen') || v.name.includes('Natural')))
    ) || voices.find(v => v.lang.startsWith('en'));

    if (femaleVoice) {
      utter.voice = femaleVoice;
    }

    utter.onstart = () => animatePillStart();
    utter.onend = () => animatePillEnd();
    window.speechSynthesis.speak(utter);
  }

  function animatePillStart() {
    if (pill) {
      pill.style.borderColor = 'var(--or)';
      pill.style.boxShadow = '0 6px 24px rgba(181,141,78,0.35)';
      pill.style.transform = 'scale(1.04)';
    }
    if (label) label.textContent = 'Welcome to Nucelora...';
    if (icon) {
      icon.innerHTML = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" style="width:16px; height:16px; animation:spin 2s linear infinite;"><path d="M12 2v4m0 12v4M4.93 4.93l2.83 2.83m8.48 8.48 2.83 2.83M2 12h4m12 0h4M4.93 19.07l2.83-2.83m8.48-8.48 2.83-2.83"/></svg>';
    }
  }

  function animatePillEnd() {
    if (pill) {
      pill.style.borderColor = 'rgba(181,141,78,0.45)';
      pill.style.boxShadow = '0 6px 22px rgba(0,0,0,0.2)';
      pill.style.transform = 'scale(1)';
    }
    if (label) label.textContent = 'Replay Voice';
    if (icon) {
      icon.innerHTML = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:16px; height:16px;"><polygon points="11 5 6 9 2 9 2 15 6 15 11 19 11 5"/><path d="M19.07 4.93a10 10 0 0 1 0 14.14M15.54 8.46a5 5 0 0 1 0 7.07"/></svg>';
    }
  }

  function playWelcomeGreeting() {
    if (hasTriggered) return;
    hasTriggered = true;

    if (audio) {
      audio.currentTime = 0;
      const promise = audio.play();
      if (promise !== undefined) {
        promise.then(() => {
          animatePillStart();
          audio.onended = () => animatePillEnd();
        }).catch(() => {
          // If browser policy blocked unmuted audio, fallback or wait for gesture
          hasTriggered = false;
        });
      }
    } else {
      speakViaWebSpeech();
    }
  }

  // 1. Trigger immediately on page load
  window.addEventListener('load', () => {
    setTimeout(playWelcomeGreeting, 500);
  });

  // 2. Fallback for strict browser autoplay policies: trigger on first user gesture
  const gestures = ['click', 'touchstart', 'scroll', 'keydown'];
  function onFirstUserGesture() {
    if (!hasTriggered) {
      playWelcomeGreeting();
    }
    gestures.forEach(g => window.removeEventListener(g, onFirstUserGesture, { passive: true }));
  }
  gestures.forEach(g => window.addEventListener(g, onFirstUserGesture, { passive: true, once: true }));

  // 3. User can manually tap the pill to play / replay
  if (pill) {
    pill.addEventListener('click', (e) => {
      e.stopPropagation();
      hasTriggered = false;
      playWelcomeGreeting();
    });
  }
})();
</script>
