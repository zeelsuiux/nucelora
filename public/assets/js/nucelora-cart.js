/**
 * Nucelora Dynamic Cart Drawer Engine
 * Real-time AJAX Cart rendering, Qty Increment/Decrement, Line Removal, and Checkout Sync
 */
(() => {
  'use strict';

  function formatMoney(cents) {
    const rupees = Math.round(cents / 100);
    return 'Rs. ' + rupees.toLocaleString('en-IN');
  }

  async function renderDrawer() {
    const box = document.getElementById('dcartin');
    if (!box) return;

    try {
      const res = await fetch(window.LYMKO.routes.root + '/cart.js?t=' + Date.now());
      if (!res.ok) return;
      const cart = await res.json();

      // Update badge counts
      document.querySelectorAll('[data-cc], [data-cc2]').forEach(el => {
        el.textContent = cart.item_count;
        el.classList.toggle('on', cart.item_count > 0);
      });

      const titleCount = document.querySelector('[data-cc2]');
      if (titleCount) titleCount.textContent = cart.item_count;

      if (!cart.items || cart.items.length === 0) {
        box.innerHTML = `
          <div class="dr-b">
            <div class="empty" style="padding:60px 0; text-align:center;">
              <h3 class="h3">Your bag is empty.</h3>
              <p style="margin-top:10px; color:var(--muted);">Let's find something your skin will love.</p>
              <div class="oact" style="margin-top:24px; display:flex; gap:10px; justify-content:center;">
                <a href="${window.LYMKO.routes.root}/collections/all" class="btn btn-k sm" data-close>Start shopping</a>
                <a href="${window.LYMKO.routes.root}/pages/routine-finder" class="btn btn-l sm" data-close>Find my routine</a>
              </div>
            </div>
          </div>
        `;
        return;
      }

      // Free shipping threshold (Rs. 499)
      const freeShipThreshold = 49900;
      const needed = freeShipThreshold - cart.total_price;
      const shipMsg = needed <= 0 
        ? `<div class="dr-ship">🎉 You unlocked <b>FREE Express Shipping</b> across India!</div>`
        : `<div class="dr-ship">Add <b>${formatMoney(needed)}</b> more to unlock <b>FREE shipping</b></div>`;

      let itemsHtml = cart.items.map((it, idx) => {
        const line = idx + 1;
        return `
          <div class="dci" data-cart-item="${it.id}">
            <div class="cim" style="background:var(--soft2); overflow:hidden;">
              <img src="${it.image}" alt="${it.title}" style="width:100%; height:100%; object-fit:contain;">
            </div>
            <div>
              <div style="display:flex; justify-content:space-between; align-items:flex-start; gap:8px;">
                <h4 style="font-size:14px; font-weight:600;"><a href="${it.url}">${it.title}</a></h4>
                <button type="button" class="btn-item-remove" data-item-id="${it.id}" style="color:var(--muted); font-size:16px; border:none; background:none; cursor:pointer;" title="Remove">&times;</button>
              </div>
              <div style="font-size:12px; color:var(--muted); margin:4px 0 8px;">${it.size || '30 ml'}</div>
              <div class="r" style="display:flex; justify-content:space-between; align-items:center;">
                <div class="qty" style="display:inline-flex; border:1px solid var(--line); border-radius:99px; overflow:hidden; height:32px;">
                  <button type="button" class="btn-qty-minus" data-item-id="${it.id}" data-current-qty="${it.quantity}" style="width:30px; height:32px; border:none; background:none; cursor:pointer; font-size:15px;">&minus;</button>
                  <input type="text" readonly value="${it.quantity}" style="width:28px; text-align:center; border:none; font-size:13px; font-weight:600; padding:0;">
                  <button type="button" class="btn-qty-plus" data-item-id="${it.id}" data-current-qty="${it.quantity}" style="width:30px; height:32px; border:none; background:none; cursor:pointer; font-size:15px;">&#43;</button>
                </div>
                <div style="font-size:14px; font-weight:600;">${formatMoney(it.line_price)}</div>
              </div>
            </div>
          </div>
        `;
      }).join('');

      box.innerHTML = `
        ${shipMsg}
        <div class="dr-b">
          ${itemsHtml}
        </div>
        <div class="dr-f">
          <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:14px; font-size:15px;">
            <span style="color:var(--muted);">Subtotal (${cart.item_count} items)</span>
            <b style="font-size:18px; color:var(--ink);">${formatMoney(cart.total_price)}</b>
          </div>
          <div style="font-size:12px; color:var(--muted); margin-bottom:16px;">Taxes and shipping calculated at checkout</div>
          <a href="${window.LYMKO.routes.root}/checkout" class="btn btn-k" style="width:100%; height:48px; font-size:15px; border-radius:99px; display:flex; justify-content:center; align-items:center; text-decoration:none;">
            Proceed to Checkout &rarr;
          </a>
          <div style="margin-top:10px; text-align:center;">
            <a href="${window.LYMKO.routes.root}/cart" style="font-size:13px; color:var(--ink2); text-decoration:underline;">View bag details</a>
          </div>
        </div>
      `;
    } catch (e) {
      console.error('Error rendering drawer:', e);
    }
  }

  // Intercept cart qty clicks
  document.addEventListener('click', async (e) => {
    // Plus
    const plus = e.target.closest('.btn-qty-plus');
    if (plus) {
      e.preventDefault();
      const id = plus.dataset.itemId;
      const current = parseInt(plus.dataset.currentQty, 10);
      plus.disabled = true;
      try {
        await fetch(window.LYMKO.routes.cartChange + '.js', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({ id: Number(id), quantity: current + 1 })
        });
        await renderDrawer();
      } catch (err) {}
      return;
    }

    // Minus
    const minus = e.target.closest('.btn-qty-minus');
    if (minus) {
      e.preventDefault();
      const id = minus.dataset.itemId;
      const current = parseInt(minus.dataset.currentQty, 10);
      minus.disabled = true;
      try {
        await fetch(window.LYMKO.routes.cartChange + '.js', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({ id: Number(id), quantity: Math.max(0, current - 1) })
        });
        await renderDrawer();
      } catch (err) {}
      return;
    }

    // Remove
    const removeBtn = e.target.closest('.btn-item-remove');
    if (removeBtn) {
      e.preventDefault();
      const id = removeBtn.dataset.itemId;
      try {
        await fetch(window.LYMKO.routes.cartChange + '.js', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({ id: Number(id), quantity: 0 })
        });
        await renderDrawer();
      } catch (err) {}
      return;
    }

    // Header bag icon open
    const bagIcon = e.target.closest('[data-open="cart"]');
    if (bagIcon) {
      e.preventDefault();
      await renderDrawer();
      if (window.Lymko && window.Lymko.openO) {
        window.Lymko.openO('cart');
      }
      return;
    }

    // Close buttons inside drawer
    if (e.target.closest('#dcart [data-close]')) {
      if (window.Lymko && window.Lymko.closeAll) {
        window.Lymko.closeAll();
      }
    }
  });

  // Re-render when drawer opened or item added
  window.addEventListener('cart:refresh', renderDrawer);

  // Hook into native addItems
  const origAddItems = window.Lymko ? window.Lymko.addItems : null;
  if (origAddItems) {
    window.Lymko.addItems = async function(items) {
      const result = await origAddItems.apply(this, arguments);
      await renderDrawer();
      return result;
    };
  }

  // Initial drawer render
  document.addEventListener('DOMContentLoaded', renderDrawer);
})();
