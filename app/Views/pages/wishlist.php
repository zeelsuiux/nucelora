<?php
use App\Config\App;
use App\Helpers\Esc;
use App\Helpers\Format;
?>

<div class="page" style="padding:40px 0 90px; background:#faf9f6; min-height:80vh;">
  <div class="w" style="max-width:1100px; margin:0 auto; padding:0 16px;">
    
    <div style="border-bottom:1px solid var(--line); padding-bottom:20px; margin-bottom:32px; display:flex; justify-content:space-between; align-items:baseline; flex-wrap:wrap; gap:12px;">
      <div>
        <h1 class="h1" style="font-size:32px; font-weight:700; margin:0 0 6px; color:var(--ink);">My Saved Wishlist</h1>
        <div id="wlcount" style="font-size:13.5px; color:var(--muted);">
          Saved formulas stored on this device.
        </div>
      </div>
      <div id="wlhead" hidden>
        <button type="button" id="mvall" class="btn btn-l sm" onclick="moveAllWishlistToBag()" style="border-radius:99px; font-weight:600;">
          + Move All to Bag
        </button>
      </div>
    </div>

    <!-- Dynamic Wishlist Cards Grid -->
    <div id="wlgrid" class="cards-grid" style="display:grid; grid-template-columns:repeat(auto-fill, minmax(260px, 1fr)); gap:24px;">
      <!-- Populated dynamically via fetchCard() by Lymko.renderWishlist() -->
    </div>

    <!-- Wishlist Empty State -->
    <div id="wlempty" style="background:#fff; border:1px solid var(--line); border-radius:16px; padding:70px 24px; text-align:center; max-width:640px; margin:0 auto;">
      <div style="width:64px; height:64px; border-radius:50%; background:var(--orsoft); border:1px solid rgba(181, 141, 78, 0.25); display:flex; align-items:center; justify-content:center; color:var(--or); margin:0 auto 20px;">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" style="width:28px; height:28px;"><path d="M12 20s-7.5-4.6-9.2-9.3C1.6 7.2 4 4 7.3 4c2 0 3.6 1.1 4.7 2.7C13.1 5.1 14.7 4 16.7 4 20 4 22.4 7.2 21.2 10.7 19.5 15.4 12 20 12 20Z"/></svg>
      </div>
      <h3 style="font-size:22px; font-weight:700; margin:0 0 10px; color:var(--ink);">Your wishlist is empty</h3>
      <p style="margin:0 0 28px; color:var(--muted); font-size:14.5px;">
        Tap the heart icon on any Nucelora face serum, cleanser, or ritual to save it here for later.
      </p>
      <div style="display:flex; gap:12px; justify-content:center; flex-wrap:wrap;">
        <a href="<?= App::baseUrl('collections/all') ?>" class="btn btn-k" style="padding:12px 28px; border-radius:99px;">
          Explore Formulations &rarr;
        </a>
        <a href="<?= App::baseUrl('pages/routine-finder') ?>" class="btn btn-l" style="padding:12px 24px; border-radius:99px;">
          Find My Routine
        </a>
      </div>
    </div>

  </div>
</div>

<script>
function moveAllWishlistToBag() {
  const cards = document.querySelectorAll('#wlgrid .card .add');
  if (cards.length) {
    cards.forEach(btn => btn.click());
    if (window.Lymko && window.Lymko.openO) {
      setTimeout(() => window.Lymko.openO('cart'), 600);
    }
  }
}
</script>
