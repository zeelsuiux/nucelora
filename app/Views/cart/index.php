<?php
use App\Config\App;
use App\Helpers\Esc;
use App\Helpers\Format;
use App\Helpers\Csrf;
?>

<div class="cart-page-wrapper" style="padding: 40px 0 90px; background: #faf9f6; min-height: 80vh;">
  <div class="w" style="max-width: 1040px; margin: 0 auto; padding: 0 16px;">
    
    <div style="display: flex; justify-content: space-between; align-items: baseline; margin-bottom: 28px; flex-wrap: wrap; gap: 12px; border-bottom: 1px solid var(--line); padding-bottom: 18px;">
      <div>
        <h1 style="font-size: 26px; font-weight: 700; margin: 0; color: var(--ink);">Your Shopping Bag</h1>
        <div style="font-size: 13.5px; color: var(--muted); margin-top: 4px;">
          <?= $totals['item_count'] ?> item<?= $totals['item_count'] === 1 ? '' : 's' ?> curated for visible skin glow
        </div>
      </div>
      <a href="<?= App::baseUrl('collections/all') ?>" style="font-size: 13.5px; color: var(--or); font-weight: 600; text-decoration: none;">
        &larr; Continue Shopping
      </a>
    </div>

    <?php if (empty($totals['items'])): ?>
      <div style="background: #fff; border: 1px solid var(--line); border-radius: 16px; padding: 60px 24px; text-align: center; box-shadow: 0 2px 12px rgba(0,0,0,0.025); max-width: 640px; margin: 0 auto;">
        <div style="width: 64px; height: 64px; border-radius: 50%; background: var(--orsoft); border: 1px solid rgba(181, 141, 78, 0.25); display: flex; align-items: center; justify-content: center; color: var(--or); margin: 0 auto 20px;">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" style="width: 28px; height: 28px;"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
        </div>
        <h3 style="font-size: 22px; font-weight: 700; margin: 0 0 10px; color: var(--ink);">Your shopping bag is empty</h3>
        <p style="margin: 0 0 28px; color: var(--muted); font-size: 14.5px;">Discover our scientifically balanced bio-active face serums &amp; daily rituals.</p>
        <a href="<?= App::baseUrl('collections/all') ?>" class="btn btn-k" style="padding: 12px 32px; border-radius: 99px; font-size: 15px; font-weight: 600;">Explore All Formulations &rarr;</a>
      </div>
    <?php else: ?>
      <div class="cart-grid" style="display: grid; grid-template-columns: 1fr 360px; gap: 36px; align-items: start;">
        
        <!-- Cart Items List -->
        <div style="display: flex; flex-direction: column; gap: 16px;">
          <?php foreach ($totals['items'] as $item): ?>
            <div style="display: flex; gap: 20px; background: #fff; border: 1px solid var(--line); border-radius: 14px; padding: 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.02); align-items: center;">
              <a href="<?= App::baseUrl('products/' . $item['slug']) ?>" style="flex: 0 0 88px; height: 88px; border-radius: 10px; overflow: hidden; background: var(--soft2); border: 1px solid var(--line); display: block;">
                <img src="<?= Esc::attr($item['image_url'] ?? App::asset('images/placeholder.jpg')) ?>" alt="<?= Esc::attr($item['title']) ?>" style="width: 100%; height: 100%; object-fit: contain;">
              </a>
              <div style="flex: 1; display: flex; flex-direction: column; gap: 6px;">
                <div style="display: flex; justify-content: space-between; align-items: flex-start; gap: 12px;">
                  <h4 style="margin: 0; font-size: 15px; font-weight: 600;">
                    <a href="<?= App::baseUrl('products/' . $item['slug']) ?>" style="color: var(--ink); text-decoration: none;"><?= Esc::html($item['title']) ?></a>
                  </h4>
                  <b style="font-size: 16px; color: var(--ink); white-space: nowrap;"><?= Format::money($item['unit_price'] * $item['quantity']) ?></b>
                </div>
                <div style="font-size: 12.5px; color: var(--muted);"><?= Esc::html($item['size_volume'] ?? 'Standard') ?></div>
                
                <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 10px;">
                  <div style="display: inline-flex; border: 1px solid var(--line); border-radius: 99px; overflow: hidden; height: 32px;">
                    <button type="button" onclick="updateBagQty(<?= (int)$item['product_id'] ?>, <?= (int)$item['quantity'] - 1 ?>)" style="width: 32px; height: 32px; border: none; background: #fff; cursor: pointer; font-size: 16px;">&minus;</button>
                    <span style="width: 36px; line-height: 32px; text-align: center; font-size: 13.5px; font-weight: 700;"><?= $item['quantity'] ?></span>
                    <button type="button" onclick="updateBagQty(<?= (int)$item['product_id'] ?>, <?= (int)$item['quantity'] + 1 ?>)" style="width: 32px; height: 32px; border: none; background: #fff; cursor: pointer; font-size: 16px;">&#43;</button>
                  </div>
                  <button type="button" onclick="updateBagQty(<?= (int)$item['product_id'] ?>, 0)" style="border: none; background: none; color: #dc2626; font-size: 12.5px; font-weight: 500; cursor: pointer;">Remove</button>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        </div>

        <!-- Order Summary & Checkout Card -->
        <div style="background: #fff; border: 1px solid var(--line); border-radius: 16px; padding: 26px; box-shadow: 0 2px 12px rgba(0,0,0,0.03); position: sticky; top: 100px;">
          <h3 style="margin: 0 0 20px; font-size: 17px; font-weight: 700; color: var(--ink);">Bag Summary</h3>
          
          <div style="display: flex; justify-content: space-between; margin-bottom: 12px; font-size: 14px; color: var(--ink2);">
            <span>Subtotal</span>
            <b><?= Format::money($totals['subtotal']) ?></b>
          </div>

          <?php if (!empty($totals['discount']) && $totals['discount'] > 0): ?>
            <div style="display: flex; justify-content: space-between; margin-bottom: 12px; font-size: 14px; color: #2e7d32; font-weight: 600;">
              <span>Coupon Discount (<?= Esc::html($totals['coupon_code']) ?>)</span>
              <b>- <?= Format::money($totals['discount']) ?></b>
            </div>
          <?php endif; ?>

          <div style="display: flex; justify-content: space-between; margin-bottom: 18px; font-size: 14px; color: var(--ink2);">
            <span>Shipping across India</span>
            <span style="color: #2e7d32; font-weight: 600;"><?= $totals['shipping'] == 0 ? 'FREE' : Format::money($totals['shipping']) ?></span>
          </div>

          <!-- Coupon Input -->
          <form action="<?= App::baseUrl('cart/apply-coupon') ?>" method="POST" style="display: flex; gap: 8px; margin-bottom: 22px;">
            <?= Csrf::field() ?>
            <input type="text" name="coupon_code" placeholder="Discount code" value="<?= Esc::attr($totals['coupon_code'] ?? '') ?>" style="flex: 1; height: 40px; padding: 0 12px; border: 1px solid var(--line); border-radius: 8px; font-size: 13px; text-transform: uppercase; outline: none;">
            <button type="submit" class="btn btn-l sm" style="height: 40px; padding: 0 14px; border-radius: 8px; font-size: 13px;">Apply</button>
          </form>

          <div style="border-top: 1px dashed var(--line); padding-top: 16px; margin-bottom: 24px; display: flex; justify-content: space-between; align-items: baseline;">
            <div>
              <b style="font-size: 16px; color: var(--ink);">Total Amount</b>
              <div style="font-size: 11px; color: var(--muted);">Taxes included</div>
            </div>
            <b style="font-size: 22px; color: var(--or); font-weight: 800;"><?= Format::money($totals['total']) ?></b>
          </div>

          <a href="<?= App::baseUrl('checkout') ?>" class="btn btn-k" style="width: 100%; text-align: center; padding: 14px 0; font-size: 15px; font-weight: 700; border-radius: 99px; text-decoration: none; display: block; box-shadow: 0 6px 20px rgba(181, 141, 78, 0.3);">
            Proceed to Checkout &rarr;
          </a>

          <div style="margin-top: 16px; text-align: center; font-size: 12px; color: var(--muted); display: flex; align-items: center; justify-content: center; gap: 6px;">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:13px; height:13px;"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg> Safe &amp; Secure Checkout &middot; Free Delivery Across India
          </div>
        </div>

      </div>
    <?php endif; ?>

  </div>
</div>

<style>
@media (max-width: 860px) {
  .cart-grid {
    grid-template-columns: 1fr !important;
  }
}
</style>

<script>
function updateBagQty(productId, qty) {
  fetch('<?= App::baseUrl('cart/change') ?>', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({ id: productId, quantity: qty })
  }).then(() => location.reload());
}
</script>
