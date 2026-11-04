<?php
use App\Config\App;
use App\Helpers\Esc;
use App\Helpers\Format;
use App\Helpers\Csrf;

$images = !empty($images) ? $images : [['image_url' => $product['image_url'] ?? App::asset('images/placeholder.jpg')]];
$primaryImg = $images[0]['image_url'] ?? App::asset('images/placeholder.jpg');
?>

<div class="page" style="padding:32px 0 80px;">
  <div class="w">
    <!-- Breadcrumb -->
    <nav style="font-size:13px; color:var(--muted); margin-bottom:24px;">
      <a href="<?= App::baseUrl() ?>">Home</a> &rarr; 
      <a href="<?= App::baseUrl('collections/' . ($product['category_slug'] ?? 'all')) ?>"><?= Esc::html($product['category_name'] ?? 'Shop') ?></a> &rarr; 
      <span><?= Esc::html($product['title']) ?></span>
    </nav>

    <!-- Product Layout Grid -->
    <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(320px, 1fr)); gap:48px; align-items:start;">
      <!-- Product Images Gallery -->
      <div>
        <div style="background:var(--soft); border:1px solid var(--line); border-radius:12px; overflow:hidden; text-align:center;">
          <img id="main-prod-img" src="<?= Esc::attr($primaryImg) ?>" alt="<?= Esc::attr($product['title']) ?>" style="width:100%; max-height:560px; object-fit:contain; display:block;">
        </div>

        <?php if (count($images) > 1): ?>
          <div style="display:flex; gap:12px; margin-top:16px; overflow-x:auto;">
            <?php foreach ($images as $img): ?>
              <button type="button" onclick="document.getElementById('main-prod-img').src='<?= Esc::attr($img['image_url']) ?>'" style="border:1px solid var(--line); border-radius:6px; overflow:hidden; width:70px; height:70px; padding:0; background:var(--soft2); cursor:pointer;">
                <img src="<?= Esc::attr($img['image_url']) ?>" style="width:100%; height:100%; object-fit:cover;">
              </button>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>
      </div>

      <!-- Product Purchasing Info -->
      <div>
        <span class="lab o"><?= Esc::html($product['category_name'] ?? 'Skincare') ?> &middot; <?= Esc::html($product['size_volume']) ?></span>
        <h1 class="h1" style="font-size:32px; margin:12px 0 8px;"><?= Esc::html($product['title']) ?></h1>

        <!-- Rating -->
        <div class="rate" style="display:flex; align-items:center; gap:8px; margin-bottom:16px;">
          <span style="color:#f59e0b; font-size:18px;">★★★★★</span>
          <b style="font-size:14px;">5.0</b> &middot; <a href="#rev" style="font-size:14px; color:var(--ink2);"><?= count($reviews) ?> reviews</a>
        </div>

        <!-- Price block -->
        <div class="pdp-pr" style="display:flex; align-items:baseline; gap:12px; margin-bottom:12px;">
          <b data-price style="font-size:28px; font-weight:700; color:var(--ink);"><?= Format::money($product['price']) ?></b>
          <?php if (!empty($product['compare_at_price'])): ?>
            <s data-compare style="font-size:18px; color:var(--muted);"><?= Format::money($product['compare_at_price']) ?></s>
            <span data-save style="background:var(--orsoft); color:var(--or); font-size:13px; font-weight:600; padding:4px 8px; border-radius:4px;">
              Save <?= Format::discountPercent($product['price'], $product['compare_at_price']) ?>%
            </span>
          <?php endif; ?>
        </div>

        <div class="tax" style="font-size:13px; color:var(--muted); line-height:1.6; margin-bottom:24px; padding-bottom:16px; border-bottom:1px solid var(--line);">
          MRP inclusive of all taxes &middot; Free shipping across India &middot; <?= Esc::html($product['size_volume']) ?> &middot; 
          <span style="color:#059669; font-weight:600;"><?= $product['stock_quantity'] > 0 ? 'In stock' : 'Sold out' ?></span>
        </div>

        <!-- Quantity & Purchasing CTAs -->
        <div style="display:flex; gap:12px; align-items:center; margin-bottom:24px; flex-wrap:wrap;">
          <div style="display:inline-flex; border:1px solid var(--line); border-radius:4px; overflow:hidden;">
            <button type="button" onclick="let q=document.getElementById('p-qty'); if(q.value>1)q.value--;" style="width:40px; height:44px; border:none; background:#fff; cursor:pointer; font-size:18px;">-</button>
            <input type="number" id="p-qty" value="1" min="1" max="<?= $product['stock_quantity'] ?>" style="width:50px; text-align:center; border:none; font-size:16px; font-weight:600;">
            <button type="button" onclick="let q=document.getElementById('p-qty'); q.value++;" style="width:40px; height:44px; border:none; background:#fff; cursor:pointer; font-size:18px;">+</button>
          </div>

          <button type="button" class="btn btn-k" style="flex:1; min-width:160px; height:44px;" onclick="window.Lymko.addItems([{id: <?= $product['id'] ?>, quantity: parseInt(document.getElementById('p-qty').value) || 1}]).then(() => window.Lymko.openO('cart'))">
            Add to bag
          </button>

          <button type="button" class="btn btn-l" style="flex:1; min-width:160px; height:44px; background:var(--or); color:#fff; border-color:var(--or);" onclick="window.Lymko.addItems([{id: <?= $product['id'] ?>, quantity: parseInt(document.getElementById('p-qty').value) || 1}]).then(() => { window.location.href = '<?= App::baseUrl('checkout') ?>'; })">
            Buy it now
          </button>
        </div>

        <!-- Pincode Delivery Estimator -->
        <div style="background:var(--orsoft); border:1px solid rgba(181, 141, 78, 0.25); border-radius:10px; padding:16px; margin-bottom:24px;">
          <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:8px;">
            <span style="font-size:13px; font-weight:700; color:var(--ink); display:flex; align-items:center; gap:8px;">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" style="width:16px; height:16px; color:var(--or);"><rect x="1" y="3" width="15" height="13" rx="2"/><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/></svg> Estimated Delivery Date
            </span>
            <span style="font-size:12px; color:var(--or); font-weight:600;">Pan-India Free Express</span>
          </div>
          <div style="display:flex; gap:8px;">
            <input type="text" id="pdp-pincode" placeholder="Enter 6-digit PIN code" maxlength="6" pattern="[0-9]{6}" style="flex:1; height:38px; padding:0 12px; border:1px solid var(--line); border-radius:6px; font-size:13px; outline:none; background:#fff;">
            <button type="button" onclick="checkPincodeDelivery()" class="btn btn-k sm" style="height:38px; padding:0 16px; border-radius:6px; font-size:12px; font-weight:600;">Check</button>
          </div>
          <div id="pincode-result" style="font-size:12.5px; margin-top:8px; line-height:1.4;"></div>
        </div>

        <script>
        function checkPincodeDelivery() {
          const pin = document.getElementById('pdp-pincode').value.trim();
          const res = document.getElementById('pincode-result');
          if (!/^\d{6}$/.test(pin)) {
            res.innerHTML = '<span style="color:#dc2626;">Please enter a valid 6-digit Indian PIN code.</span>';
            return;
          }
          const days = (pin.startsWith('38') || pin.startsWith('39') || pin.startsWith('40')) ? 2 : 3;
          const d = new Date();
          d.setDate(d.getDate() + days);
          const dateStr = d.toLocaleDateString('en-IN', { weekday: 'short', month: 'short', day: 'numeric' });
          res.innerHTML = `<span style="color:#15803d; font-weight:600;">✓ Free Delivery by <b>${dateStr}</b> to PIN ${pin}</span><div style="color:var(--muted); font-size:11.5px; margin-top:2px;">Cash on Delivery (COD) &amp; Express Courier Available</div>`;
        }
        </script>

        <!-- Accordions -->
        <div class="accordions" style="border-top:1px solid var(--line);">
          <details open style="padding:16px 0; border-bottom:1px solid var(--line);">
            <summary style="font-weight:600; cursor:pointer; font-size:16px;">Description &amp; Highlights</summary>
            <div style="padding-top:12px; font-size:14px; line-height:1.7; color:var(--ink2);">
              <?= $product['description'] ?: '<p>' . Esc::html($product['short_description']) . '</p>' ?>
            </div>
          </details>

          <details style="padding:16px 0; border-bottom:1px solid var(--line);">
            <summary style="font-weight:600; cursor:pointer; font-size:16px;">Key Benefits</summary>
            <div style="padding-top:12px; font-size:14px; line-height:1.7; color:var(--ink2);">
              <p><?= Esc::html($product['benefits']) ?></p>
            </div>
          </details>

          <details style="padding:16px 0; border-bottom:1px solid var(--line);">
            <summary style="font-weight:600; cursor:pointer; font-size:16px;">Directions &amp; How to Use</summary>
            <div style="padding-top:12px; font-size:14px; line-height:1.7; color:var(--ink2);">
              <p><?= Esc::html($product['directions']) ?></p>
            </div>
          </details>
        </div>
      </div>
    </div>

    <!-- Related Products -->
    <?php if (!empty($related)): ?>
      <div style="margin-top:80px; padding-top:40px; border-top:1px solid var(--line);">
        <h3 class="h3" style="margin-bottom:24px;">Pairs well with this ritual</h3>
        <div class="cards-grid" style="display:grid; grid-template-columns:repeat(auto-fill, minmax(260px, 1fr)); gap:24px;">
          <?php foreach ($related as $rp): ?>
            <div style="background:#fff; border:1px solid var(--line); border-radius:8px; overflow:hidden; padding:16px;">
              <a href="<?= App::baseUrl('products/' . $rp['slug']) ?>">
                <img src="<?= Esc::attr($rp['image_url'] ?? App::asset('images/placeholder.jpg')) ?>" style="width:100%; height:240px; object-fit:cover; border-radius:4px;">
              </a>
              <h4 style="font-size:15px; margin:10px 0 6px;"><a href="<?= App::baseUrl('products/' . $rp['slug']) ?>"><?= Esc::html($rp['title']) ?></a></h4>
              <b style="font-size:16px;"><?= Format::money($rp['price']) ?></b>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    <?php endif; ?>

    <!-- Customer Reviews Section (#rev) -->
    <div id="rev" style="margin-top:80px; padding-top:40px; border-top:1px solid var(--line);">
      <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:16px; margin-bottom:32px;">
        <div>
          <h2 class="h2">Customer Reviews</h2>
          <p style="color:var(--muted); margin-top:4px;">Real experiences from verified purchasers</p>
        </div>
        <button type="button" class="btn btn-l sm" onclick="document.getElementById('review-form-card').hidden = !document.getElementById('review-form-card').hidden">
          Write a review
        </button>
      </div>

      <!-- Write Review Form -->
      <div id="review-form-card" hidden style="background:var(--soft2); border:1px solid var(--line); border-radius:8px; padding:24px; max-width:640px; margin-bottom:32px;">
        <h4 style="margin:0 0 16px;">Share your experience with <?= Esc::html($product['title']) ?></h4>
        <form action="<?= App::baseUrl('api/reviews') ?>" method="POST" style="display:flex; flex-direction:column; gap:14px;">
          <?= Csrf::field() ?>
          <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
          <div style="display:flex; gap:12px;">
            <input type="text" name="reviewer_name" placeholder="Your Name" required style="flex:1; padding:10px 14px; border:1px solid var(--line); border-radius:4px;">
            <input type="email" name="reviewer_email" placeholder="Your Email" required style="flex:1; padding:10px 14px; border:1px solid var(--line); border-radius:4px;">
          </div>
          <select name="rating" style="padding:10px 14px; border:1px solid var(--line); border-radius:4px;">
            <option value="5">★★★★★ - Excellent (5/5)</option>
            <option value="4">★★★★☆ - Very Good (4/5)</option>
            <option value="3">★★★☆☆ - Average (3/5)</option>
            <option value="2">★★☆☆☆ - Poor (2/5)</option>
            <option value="1">★☆☆☆☆ - Terrible (1/5)</option>
          </select>
          <input type="text" name="title" placeholder="Review Title (e.g. Glowing skin within 2 weeks!)" required style="padding:10px 14px; border:1px solid var(--line); border-radius:4px;">
          <textarea name="content" rows="4" placeholder="Your feedback..." required style="padding:10px 14px; border:1px solid var(--line); border-radius:4px; font-family:var(--sans);"></textarea>
          <button type="submit" class="btn btn-k" style="align-self:flex-start;">Submit Review</button>
        </form>
      </div>

      <!-- Reviews Listing -->
      <div style="display:flex; flex-direction:column; gap:16px;">
        <?php foreach ($reviews as $r): ?>
          <div style="background:#fff; border:1px solid var(--line); border-radius:8px; padding:20px;">
            <div style="display:flex; justify-content:space-between; margin-bottom:8px;">
              <div>
                <span style="color:#f59e0b;">★★★★★</span>
                <b style="margin-left:8px;"><?= Esc::html($r['title']) ?></b>
              </div>
              <span style="font-size:12px; color:var(--muted);"><?= Format::date($r['created_at'], 'd M Y') ?></span>
            </div>
            <p style="font-size:14px; color:var(--ink2); line-height:1.6; margin:0 0 8px;"><?= Esc::html($r['content']) ?></p>
            <div style="font-size:13px; color:var(--muted);">
              By <b><?= Esc::html($r['reviewer_name']) ?></b> &middot; <span style="color:#059669;">Verified Buyer</span>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</div>
