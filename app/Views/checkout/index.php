<?php
use App\Config\App;
use App\Helpers\Esc;
use App\Helpers\Format;
use App\Helpers\Csrf;
use App\Helpers\Auth;
use App\Services\RazorpayService;

$user = Auth::user();
$isEmpty = empty($totals['items']) || ($totals['item_count'] ?? 0) === 0;
?>

<div class="checkout-wrapper" style="padding: 36px 0 90px; background: #faf9f6; min-height: 85vh;">
  <div class="w" style="max-width: 1140px; margin: 0 auto; padding: 0 16px;">

    <!-- Top Secure Header Banner -->
    <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid var(--line); padding-bottom: 22px; margin-bottom: 32px; flex-wrap: wrap; gap: 14px;">
      <div style="display: flex; align-items: center; gap: 14px;">
        <div style="width: 44px; height: 44px; border-radius: 12px; background: #fff; border: 1px solid var(--line); display: flex; align-items: center; justify-content: center; color: var(--or); box-shadow: 0 2px 6px rgba(0,0,0,0.03);">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:20px; height:20px;"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
        </div>
        <div>
          <h1 style="font-size: 24px; font-weight: 700; margin: 0; color: var(--ink); font-family: var(--sans);">Express Checkout</h1>
          <div style="font-size: 13px; color: var(--muted); margin-top: 3px;">
            Guaranteed safe &amp; secure checkout &middot; 256-bit SSL encrypted
          </div>
        </div>
      </div>
      <div style="display: flex; gap: 10px; align-items: center; flex-wrap: wrap;">
        <span style="background: #e8f5e9; color: #2e7d32; font-size: 12.5px; font-weight: 600; padding: 6px 14px; border-radius: 99px; display: inline-flex; align-items: center; gap: 6px;">
          ✓ Free Delivery Across India
        </span>
        <span style="background: #fff; border: 1px solid var(--line); color: var(--ink2); font-size: 12.5px; font-weight: 500; padding: 6px 14px; border-radius: 99px; display: inline-flex; align-items: center; gap: 6px;">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:14px; height:14px; color:var(--or);"><path d="M12 22v-9"/><path d="M12 13c-4.4 0-8-3.6-8-8 4.4 0 8 3.6 8 8Z"/><path d="M12 13c0-4.4 3.6-8 8-8 0 4.4-3.6 8-8 8Z"/></svg> 100% Authentic Nucelora
        </span>
      </div>
    </div>

    <?php if ($isEmpty): ?>
      <!-- State when Cart is Empty -->
      <div style="background: #fff; border: 1px solid var(--line); border-radius: 18px; padding: 48px 24px; text-align: center; box-shadow: 0 4px 20px rgba(0,0,0,0.03); max-width: 820px; margin: 0 auto;">
        <div style="width: 64px; height: 64px; background: var(--orsoft); color: var(--or); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; border: 1px solid rgba(181, 141, 78, 0.25);">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" style="width:28px; height:28px;"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
        </div>
        <h2 style="font-size: 24px; font-weight: 700; color: var(--ink); margin-bottom: 8px;">તમારી શોપિંગ બેગ ખાલી છે</h2>
        <p style="color: var(--muted); font-size: 15px; max-width: 480px; margin: 0 auto 28px;">
          Your bag is currently empty. Choose any of our best-selling botanical formulas below to proceed directly to checkout:
        </p>

        <!-- Featured Best Sellers Grid -->
        <?php if (!empty($featured)): ?>
          <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 16px; margin-bottom: 32px; text-align: left;">
            <?php foreach ($featured as $prod): ?>
              <div style="background: #faf9f6; border: 1px solid var(--line); border-radius: 12px; padding: 14px; display: flex; flex-direction: column; transition: transform 0.2s, box-shadow 0.2s;">
                <div style="width: 100%; aspect-ratio: 1/1; background: #fff; border-radius: 8px; overflow: hidden; margin-bottom: 12px; border: 1px solid rgba(0,0,0,0.04);">
                  <img src="<?= Esc::attr($prod['image_url'] ?? App::asset('images/placeholder.jpg')) ?>" alt="<?= Esc::attr($prod['title']) ?>" style="width: 100%; height: 100%; object-fit: contain;">
                </div>
                <h4 style="font-size: 13.5px; font-weight: 600; margin: 0 0 4px; color: var(--ink); line-height: 1.3; height: 36px; overflow: hidden;">
                  <?= Esc::html($prod['title']) ?>
                </h4>
                <div style="font-size: 14px; font-weight: 700; color: var(--or); margin-bottom: 10px;">
                  <?= Format::money($prod['price']) ?>
                  <?php if (!empty($prod['compare_price']) && $prod['compare_price'] > $prod['price']): ?>
                    <span style="font-size: 11.5px; color: var(--muted); text-decoration: line-through; margin-left: 4px; font-weight: normal;"><?= Format::money($prod['compare_price']) ?></span>
                  <?php endif; ?>
                </div>
                <button type="button" onclick="quickAddAndCheckout(<?= (int)$prod['id'] ?>)" class="btn btn-k sm" style="width: 100%; margin-top: auto; padding: 8px 0; font-size: 12.5px; border-radius: 6px;">
                  + Add &amp; Checkout
                </button>
              </div>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>

        <div style="display: flex; gap: 12px; justify-content: center; flex-wrap: wrap;">
          <a href="<?= App::baseUrl('collections/all') ?>" class="btn btn-k" style="padding: 12px 28px; border-radius: 99px;">
            Explore All Skincare Products &rarr;
          </a>
          <a href="<?= App::baseUrl() ?>" class="btn btn-l" style="padding: 12px 24px; border-radius: 99px;">
            Return to Home
          </a>
        </div>
      </div>

    <?php else: ?>
      <!-- State when Cart has items: Full Checkout Form -->
      <form id="checkout-form" action="<?= App::baseUrl('checkout/process') ?>" method="POST" class="checkout-grid" style="display: grid; grid-template-columns: 1fr 420px; gap: 36px; align-items: start;">
        <?= Csrf::field() ?>
        <input type="hidden" name="razorpay_payment_id" id="razorpay_payment_id" value="">

        <!-- Left Column: Shipping & Payment Information -->
        <div style="display: flex; flex-direction: column; gap: 24px;">

          <!-- 1. Contact Details Card -->
          <div class="checkout-card">
            <div class="card-title">
              <span class="step-num">1</span>
              <h3>Contact Details</h3>
            </div>
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
              <div style="grid-column: span 2;">
                <label class="field-label">Email Address (for order tracking &amp; invoice) *</label>
                <input type="email" name="email" required value="<?= Esc::attr($user['email'] ?? '') ?>" placeholder="e.g. rahul@gmail.com" class="field-input">
              </div>
              <div>
                <label class="field-label">Mobile Number *</label>
                <div style="position: relative;">
                  <span style="position: absolute; left: 12px; top: 13px; font-size: 13.5px; color: var(--muted); font-weight: 500;">+91</span>
                  <input type="tel" name="phone" required value="<?= Esc::attr($user['phone'] ?? '') ?>" placeholder="10 digits" pattern="[0-9]{10}" maxlength="10" class="field-input" style="padding-left: 48px;">
                </div>
              </div>
              <div>
                <label class="field-label">Full Name *</label>
                <input type="text" name="full_name" required value="<?= Esc::attr(($user['first_name'] ?? '') . ' ' . ($user['last_name'] ?? '')) ?>" placeholder="Recipient name" class="field-input">
              </div>
            </div>
          </div>

          <!-- 2. Delivery Address Card -->
          <div class="checkout-card">
            <div class="card-title">
              <span class="step-num">2</span>
              <h3>Delivery Address</h3>
            </div>

            <div style="display: flex; flex-direction: column; gap: 16px;">
              <div>
                <label class="field-label">House / Flat No., Apartment &amp; Society / Street *</label>
                <input type="text" name="address_line1" required placeholder="Flat / House No., Apartment name, Street address" class="field-input">
              </div>
              <div>
                <label class="field-label">Nearby Landmark (Optional)</label>
                <input type="text" name="address_line2" placeholder="e.g. Near City Garden or Behind Metro Station" class="field-input">
              </div>
              <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 14px;" class="addr-row">
                <div>
                  <label class="field-label">PIN Code *</label>
                  <input type="text" name="postal_code" required placeholder="6 digits" maxlength="6" pattern="[0-9]{6}" class="field-input">
                </div>
                <div>
                  <label class="field-label">City / District *</label>
                  <input type="text" name="city" required placeholder="e.g. Ahmedabad" class="field-input">
                </div>
                <div>
                  <label class="field-label">State *</label>
                  <input type="text" name="state" required placeholder="e.g. Gujarat" class="field-input">
                </div>
              </div>
            </div>
          </div>

          <!-- 3. Payment Method Card -->
          <div class="checkout-card">
            <div class="card-title">
              <span class="step-num">3</span>
              <h3>Payment Method</h3>
            </div>

            <div style="display: flex; flex-direction: column; gap: 12px;">
              <!-- Option 1: Cash on Delivery -->
              <label class="pay-option active" id="label-cod" style="display: flex; align-items: flex-start; gap: 14px; padding: 18px; border: 2px solid var(--or); background: var(--orsoft); border-radius: 12px; cursor: pointer; transition: all 0.2s;">
                <input type="radio" name="payment_method" value="cod" checked onchange="togglePayment(this.value)" style="margin-top: 3px; width: 18px; height: 18px; accent-color: var(--or);">
                <div style="flex: 1;">
                  <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 6px;">
                    <b style="font-size: 15px; color: var(--ink);">Cash on Delivery (COD)</b>
                    <span style="font-size: 11px; background: #2e7d32; color: #fff; padding: 3px 8px; border-radius: 4px; font-weight: 600;">EASY &amp; VERIFIED</span>
                  </div>
                  <div style="font-size: 13px; color: var(--muted); margin-top: 4px; line-height: 1.4;">
                    Pay in cash or scan QR using any UPI app (GPay, PhonePe, Paytm) right at your doorstep upon package delivery.
                  </div>
                </div>
              </label>

              <!-- Option 2: Online Payment -->
              <label class="pay-option" id="label-razorpay" style="display: flex; align-items: flex-start; gap: 14px; padding: 18px; border: 1px solid var(--line); background: #fff; border-radius: 12px; cursor: pointer; transition: all 0.2s;">
                <input type="radio" name="payment_method" value="razorpay" onchange="togglePayment(this.value)" style="margin-top: 3px; width: 18px; height: 18px; accent-color: var(--or);">
                <div style="flex: 1;">
                  <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 6px;">
                    <b style="font-size: 15px; color: var(--ink);">Online Payment (UPI, Cards &amp; NetBanking)</b>
                  </div>
                  <div style="font-size: 13px; color: var(--muted); margin-top: 4px; line-height: 1.4;">
                    Instant prepaid order via UPI (Google Pay, PhonePe, BHIM), Debit/Credit Card or NetBanking.
                  </div>
                </div>
              </label>
            </div>
          </div>

          <!-- Checkout Place Order Action Button -->
          <div>
            <button type="button" id="pay-btn" onclick="submitOrder()" class="btn btn-k" style="width: 100%; height: 56px; font-size: 16px; font-weight: 700; border-radius: 99px; cursor: pointer; background: var(--or); border: none; color: #fff; box-shadow: 0 8px 24px rgba(181, 141, 78, 0.35); transition: transform 0.15s, box-shadow 0.15s;">
              Confirm Cash on Delivery Order &middot; <?= Format::money($totals['total']) ?> &rarr;
            </button>
            <div style="display: flex; justify-content: center; gap: 20px; margin-top: 14px; font-size: 12.5px; color: var(--muted); flex-wrap: wrap;">
              <span style="display: inline-flex; align-items: center; gap: 5px;">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:13px; height:13px;"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg> 256-bit Encrypted
              </span>
              <span style="display: inline-flex; align-items: center; gap: 5px;">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:13px; height:13px;"><rect x="1" y="3" width="15" height="13" rx="2"/><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/></svg> Free Express Shipping
              </span>
              <span style="display: inline-flex; align-items: center; gap: 5px;">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:13px; height:13px;"><polyline points="23 4 23 10 17 10"/><path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10"/></svg> Easy Replacement
              </span>
            </div>
          </div>

        </div>

        <!-- Right Column: Order Summary Card -->
        <div class="checkout-card summary-card" style="position: sticky; top: 100px;">
          <h3 style="margin: 0 0 18px; font-size: 17px; font-weight: 700; display: flex; justify-content: space-between; align-items: center; color: var(--ink);">
            <span>Order Summary</span>
            <span style="font-size: 13px; color: var(--muted); font-weight: normal;"><?= $totals['item_count'] ?> item(s) in bag</span>
          </h3>

          <!-- Purchased Items Rail -->
          <div style="max-height: 290px; overflow-y: auto; margin-bottom: 20px; padding-right: 4px; display: flex; flex-direction: column; gap: 14px;">
            <?php foreach ($totals['items'] as $item): ?>
              <div style="display: flex; gap: 14px; align-items: center;">
                <div style="width: 54px; height: 54px; border-radius: 10px; overflow: hidden; background: var(--soft2); position: relative; flex-shrink: 0; border: 1px solid var(--line);">
                  <img src="<?= Esc::attr($item['image_url'] ?? App::asset('images/placeholder.jpg')) ?>" alt="<?= Esc::attr($item['title']) ?>" style="width: 100%; height: 100%; object-fit: contain;">
                  <span style="position: absolute; top: 0; right: 0; background: var(--ink); color: #fff; font-size: 10px; width: 18px; height: 18px; border-radius: 0 0 0 6px; display: flex; align-items: center; justify-content: center; font-weight: 700;"><?= $item['quantity'] ?></span>
                </div>
                <div style="flex: 1; min-width: 0;">
                  <div style="font-size: 13.5px; font-weight: 600; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; color: var(--ink);"><?= Esc::html($item['title']) ?></div>
                  <div style="font-size: 12px; color: var(--muted); margin-top: 2px;">Qty: <?= $item['quantity'] ?> &middot; <?= Esc::html($item['size_volume'] ?? 'Standard') ?></div>
                </div>
                <b style="font-size: 14.5px; color: var(--ink);"><?= Format::money($item['unit_price'] * $item['quantity']) ?></b>
              </div>
            <?php endforeach; ?>
          </div>

          <!-- Coupon Code Input Box -->
          <div style="margin-bottom: 18px; padding-bottom: 18px; border-bottom: 1px solid var(--line);">
            <div style="display: flex; gap: 8px;">
              <input type="text" id="coupon_input" placeholder="Discount code (e.g. WELCOME10)" value="<?= Esc::attr($totals['coupon_code'] ?? '') ?>" style="flex: 1; height: 42px; padding: 0 12px; border: 1px solid var(--line); border-radius: 8px; font-size: 13px; text-transform: uppercase; outline: none;">
              <button type="button" onclick="applyCheckoutCoupon()" class="btn btn-l sm" style="height: 42px; padding: 0 16px; border-radius: 8px; font-size: 13px; font-weight: 600;">Apply</button>
            </div>
            <div id="coupon-msg" style="font-size: 12px; margin-top: 6px;"></div>
          </div>

          <!-- Cost Breakdown List -->
          <div style="display: flex; flex-direction: column; gap: 11px; font-size: 14px;">
            <div style="display: flex; justify-content: space-between; color: var(--ink2);">
              <span>Bag Subtotal</span>
              <b><?= Format::money($totals['subtotal']) ?></b>
            </div>

            <?php if (!empty($totals['discount']) && $totals['discount'] > 0): ?>
              <div style="display: flex; justify-content: space-between; color: #2e7d32; font-weight: 600;">
                <span>Coupon Discount (<?= Esc::html($totals['coupon_code']) ?>)</span>
                <b>- <?= Format::money($totals['discount']) ?></b>
              </div>
            <?php endif; ?>

            <div style="display: flex; justify-content: space-between; color: var(--ink2);">
              <span>Shipping across India</span>
              <span style="color: #2e7d32; font-weight: 600;"><?= $totals['shipping'] == 0 ? 'FREE' : Format::money($totals['shipping']) ?></span>
            </div>

            <div style="border-top: 1px dashed var(--line); padding-top: 14px; margin-top: 4px; display: flex; justify-content: space-between; align-items: baseline;">
              <div>
                <div style="font-size: 17px; font-weight: 700; color: var(--ink);">Total Payable</div>
                <div style="font-size: 11.5px; color: var(--muted);">All taxes included</div>
              </div>
              <div style="font-size: 24px; font-weight: 800; color: var(--or);"><?= Format::money($totals['total']) ?></div>
            </div>
          </div>

          <div style="margin-top: 22px; padding: 12px; background: var(--orsoft); border-radius: 10px; font-size: 12px; color: var(--or2); text-align: center; border: 1px solid rgba(181, 141, 78, 0.2); display: flex; align-items: center; justify-content: center; gap: 6px;">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:14px; height:14px; color:var(--or);"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg> 100% Satisfaction Guarantee &middot; Crafted for visible skin health
          </div>
        </div>
      </form>
    <?php endif; ?>

  </div>
</div>

<style>
.checkout-card {
  background: #fff;
  border: 1px solid var(--line);
  border-radius: 16px;
  padding: 26px;
  box-shadow: 0 2px 12px rgba(0,0,0,0.025);
}
.card-title {
  display: flex;
  align-items: center;
  gap: 12px;
  margin-bottom: 22px;
}
.step-num {
  background: var(--or);
  color: #fff;
  width: 28px;
  height: 28px;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 13.5px;
  font-weight: 700;
}
.card-title h3 {
  font-size: 18px;
  font-weight: 700;
  margin: 0;
  color: var(--ink);
}
.field-label {
  display: block;
  font-size: 12.5px;
  font-weight: 600;
  margin-bottom: 6px;
  color: var(--ink2);
}
.field-input {
  width: 100%;
  height: 46px;
  padding: 0 14px;
  border: 1px solid #dcdcdc;
  border-radius: 8px;
  font-size: 14px;
  color: var(--ink);
  outline: none;
  background: #fff;
  box-sizing: border-box;
  transition: border-color 0.2s, box-shadow 0.2s;
}
.field-input:focus {
  border-color: var(--or);
  box-shadow: 0 0 0 3px rgba(181, 141, 78, 0.15);
}
@media (max-width: 900px) {
  .checkout-grid {
    grid-template-columns: 1fr !important;
  }
  .summary-card {
    position: static !important;
    order: -1;
    margin-bottom: 20px;
  }
  .addr-row {
    grid-template-columns: 1fr !important;
  }
}
</style>

<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
let currentPaymentMethod = 'cod';

function togglePayment(val) {
  currentPaymentMethod = val;
  const btn = document.getElementById('pay-btn');
  const labelCod = document.getElementById('label-cod');
  const labelRzp = document.getElementById('label-razorpay');

  if (val === 'cod') {
    labelCod.style.border = '2px solid var(--or)';
    labelCod.style.background = 'var(--orsoft)';
    labelRzp.style.border = '1px solid var(--line)';
    labelRzp.style.background = '#fff';
    btn.innerHTML = 'Confirm Cash on Delivery Order &middot; <?= Format::money($totals['total'] ?? 0) ?> &rarr;';
  } else {
    labelRzp.style.border = '2px solid var(--or)';
    labelRzp.style.background = 'var(--orsoft)';
    labelCod.style.border = '1px solid var(--line)';
    labelCod.style.background = '#fff';
    btn.innerHTML = 'Pay Online Securely &middot; <?= Format::money($totals['total'] ?? 0) ?> &rarr;';
  }
}

function submitOrder() {
  const form = document.getElementById('checkout-form');
  if (!form.checkValidity()) {
    form.reportValidity();
    return;
  }

  if (currentPaymentMethod === 'cod') {
    const btn = document.getElementById('pay-btn');
    btn.disabled = true;
    btn.innerHTML = 'Placing Order... Please wait...';
    form.submit();
    return;
  }

  // Razorpay Gateway Flow
  const options = {
    key: "<?= RazorpayService::getKeyId() ?>",
    amount: <?= (int)(($totals['total'] ?? 0) * 100) ?>,
    currency: "INR",
    name: "Nucelora Skincare",
    description: "Order Checkout",
    image: "<?= App::asset('images/nucelora-logo-cropped.png') ?>",
    handler: function (response) {
      document.getElementById('razorpay_payment_id').value = response.razorpay_payment_id;
      form.submit();
    },
    prefill: {
      name: form.elements['full_name'].value,
      email: form.elements['email'].value,
      contact: form.elements['phone'].value
    },
    theme: {
      color: "#b58d4e"
    }
  };

  try {
    const rzp = new Razorpay(options);
    rzp.on('payment.failed', function (response) {
      alert("Payment unsuccessful: " + (response.error ? response.error.description : 'Unknown error'));
    });
    rzp.open();
  } catch (err) {
    alert("Payment gateway initializing: " + err.message);
  }
}

async function quickAddAndCheckout(productId) {
  try {
    const res = await fetch('<?= App::baseUrl('cart/add') ?>', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ id: productId, quantity: 1 })
    });
    if (res.ok) {
      location.reload();
    }
  } catch (e) {
    alert("Could not add product. Please try again.");
  }
}

async function applyCheckoutCoupon() {
  const code = document.getElementById('coupon_input').value.trim();
  const msg = document.getElementById('coupon-msg');
  if (!code) {
    msg.innerHTML = '<span style="color:#dc2626;">Please enter a discount code</span>';
    return;
  }
  msg.innerHTML = '<span style="color:var(--muted);">Applying coupon...</span>';

  const formData = new FormData();
  formData.append('coupon_code', code);
  formData.append('csrf_token', '<?= Csrf::token() ?>');

  try {
    const res = await fetch('<?= App::baseUrl('cart/apply-coupon') ?>', {
      method: 'POST',
      body: formData
    });
    location.reload();
  } catch (e) {
    msg.innerHTML = '<span style="color:#dc2626;">Failed to apply coupon. Try again.</span>';
  }
}
</script>
