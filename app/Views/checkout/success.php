<?php
use App\Config\App;
use App\Helpers\Esc;
use App\Helpers\Format;
use App\Helpers\Csrf;

$address = json_decode($order['shipping_address_json'], true) ?: [];
?>

<div class="page" style="padding:60px 0 100px; background:#faf9f6; min-height:80vh;">
  <div class="w" style="max-width:680px; margin:0 auto; padding:0 20px;">
    <div style="background:#fff; border:1px solid var(--line); border-radius:16px; padding:40px 32px; text-align:center; box-shadow:0 4px 24px rgba(0,0,0,0.03);">
      
      <!-- Success Icon -->
      <div style="width:64px; height:64px; background:#dcfce7; color:#15803d; border-radius:50%; display:flex; align-items:center; justify-content:center; margin:0 auto 20px; border:1px solid #bbf7d0;">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="width:32px; height:32px;"><path d="m5 13 4 4L19 7"/></svg>
      </div>

      <span class="lab o" style="background:var(--orsoft); color:var(--or); padding:5px 14px; border-radius:99px; font-size:12px; font-weight:700; letter-spacing:0.08em; text-transform:uppercase;">Order Confirmed</span>
      <h1 class="h1" style="font-size:32px; font-weight:800; margin:14px 0 8px; color:var(--ink);">Thank you for your order!</h1>
      <p style="color:var(--muted); margin-bottom:28px; font-size:15px; line-height:1.5;">
        We've received your order and our fulfillment team is preparing your pure botanical ritual package.
      </p>

      <!-- Order Summary Card -->
      <div style="background:var(--soft2); border:1px solid var(--line); border-radius:12px; padding:22px; text-align:left; margin-bottom:28px;">
        <div style="display:flex; justify-content:space-between; margin-bottom:12px;">
          <span style="color:var(--muted); font-size:14px;">Order Number</span>
          <b style="font-size:15px; color:var(--ink); letter-spacing:0.02em;"><?= Esc::html($order['order_number']) ?></b>
        </div>
        <div style="display:flex; justify-content:space-between; margin-bottom:12px;">
          <span style="color:var(--muted); font-size:14px;">Payment Method</span>
          <b style="font-size:14px; text-transform:uppercase; color:var(--ink);"><?= Esc::html($order['payment_method']) ?> (<?= Esc::html($order['payment_status']) ?>)</b>
        </div>
        <div style="display:flex; justify-content:space-between; margin-bottom:12px;">
          <span style="color:var(--muted); font-size:14px;">Total Paid / Due</span>
          <b style="font-size:19px; color:var(--or);"><?= Format::money($order['total_amount']) ?></b>
        </div>
        <div style="border-top:1px solid var(--line); padding-top:14px; margin-top:10px; font-size:13.5px; color:var(--ink2); line-height:1.5;">
          <b>Shipping Address:</b><br>
          <?= Esc::html($address['full_name'] ?? '') ?>, <?= Esc::html($address['address_line1'] ?? '') ?><?= !empty($address['address_line2']) ? ', ' . Esc::html($address['address_line2']) : '' ?>, <?= Esc::html($address['city'] ?? '') ?>, <?= Esc::html($address['state'] ?? '') ?> - <?= Esc::html($address['postal_code'] ?? '') ?>
        </div>
      </div>

      <?php if (!empty($canCreateAccount)): ?>
        <!-- 1-Click Password Creation Box: ONLY shown if this email has no existing customer account -->
        <div id="account-creation-card" style="background:#fffcf8; border:1.5px solid rgba(181,141,78,0.35); border-radius:12px; padding:24px 26px; text-align:left; margin-bottom:28px; box-shadow:0 4px 16px rgba(181,141,78,0.06);">
          <div style="display:flex; align-items:flex-start; gap:12px; margin-bottom:14px;">
            <div style="width:38px; height:38px; border-radius:50%; background:var(--orsoft); color:var(--or); display:flex; align-items:center; justify-content:center; flex-shrink:0;">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:20px; height:20px;"><rect width="18" height="11" x="3" y="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
            </div>
            <div>
              <h3 style="font-size:16px; font-weight:700; color:var(--ink); margin:0 0 4px;">Track your order anytime &middot; Set a Password</h3>
              <p style="font-size:13px; color:var(--muted); margin:0; line-height:1.4;">
                Create a password for <b><?= Esc::html($email) ?></b> to track your parcel live and enjoy 1-click checkout next time.
              </p>
            </div>
          </div>

          <div id="acc-msg" style="display:none; font-size:13px; padding:10px 14px; border-radius:6px; margin-bottom:14px;"></div>

          <form id="create-account-form" onsubmit="submitQuickAccount(event)" style="display:flex; gap:10px; flex-wrap:wrap;">
            <?= Csrf::field() ?>
            <input type="hidden" name="order_id" value="<?= Esc::attr($order['id']) ?>">
            
            <div style="flex:1; min-width:220px;">
              <input type="password" id="acc_pwd" name="password" required minlength="6" placeholder="Choose a password (min 6 characters)" style="width:100%; padding:12px 14px; border:1px solid var(--line); border-radius:6px; font-size:14px; box-sizing:border-box;">
            </div>
            <button type="submit" id="acc-btn" class="btn btn-k" style="padding:12px 24px; white-space:nowrap; font-weight:600;">
              Save &amp; Track &rarr;
            </button>
          </form>
        </div>

        <script>
        function submitQuickAccount(e) {
          e.preventDefault();
          const form = document.getElementById('create-account-form');
          const btn = document.getElementById('acc-btn');
          const msg = document.getElementById('acc-msg');
          const pwd = document.getElementById('acc_pwd').value.trim();

          if (pwd.length < 6) {
            msg.style.display = 'block';
            msg.style.background = '#fee2e2';
            msg.style.color = '#b91c1c';
            msg.style.border = '1px solid #fca5a5';
            msg.textContent = 'Password must be at least 6 characters.';
            return;
          }

          btn.disabled = true;
          btn.textContent = 'Creating account...';

          const fd = new FormData(form);
          fetch('<?= App::baseUrl('checkout/create-account') ?>', {
            method: 'POST',
            body: fd
          })
          .then(res => res.json())
          .then(data => {
            if (data.success) {
              const card = document.getElementById('account-creation-card');
              card.style.background = '#f0fdf4';
              card.style.borderColor = '#86efac';
              card.innerHTML = `
                <div style="display:flex; align-items:center; gap:12px;">
                  <div style="width:40px; height:40px; border-radius:50%; background:#dcfce7; color:#15803d; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="width:22px; height:22px;"><path d="m5 13 4 4L19 7"/></svg>
                  </div>
                  <div>
                    <h4 style="margin:0 0 4px; font-size:16px; color:#15803d; font-weight:700;">Account Created Successfully!</h4>
                    <p style="margin:0; font-size:13.5px; color:var(--ink2);">You are now signed in. You can track this order live from your member dashboard.</p>
                  </div>
                </div>
                <div style="margin-top:16px; text-align:left;">
                  <a href="<?= App::baseUrl('account/orders/' . $order['id']) ?>" class="btn btn-k" style="padding:10px 22px; display:inline-block; font-size:13.5px;">View Order in My Account &rarr;</a>
                </div>
              `;
            } else {
              btn.disabled = false;
              btn.textContent = 'Save & Track →';
              msg.style.display = 'block';
              msg.style.background = '#fee2e2';
              msg.style.color = '#b91c1c';
              msg.style.border = '1px solid #fca5a5';
              msg.textContent = data.message || 'Error creating account. Please try again.';
            }
          })
          .catch(err => {
            btn.disabled = false;
            btn.textContent = 'Save & Track →';
            msg.style.display = 'block';
            msg.style.background = '#fee2e2';
            msg.style.color = '#b91c1c';
            msg.style.border = '1px solid #fca5a5';
            msg.textContent = 'Network error. Please try again.';
          });
        }
        </script>
      <?php endif; ?>

      <!-- Actions -->
      <div style="display:flex; gap:12px; justify-content:center; flex-wrap:wrap;">
        <a href="<?= App::baseUrl('collections/all') ?>" class="btn btn-k" style="padding:12px 28px;">Continue Shopping</a>
        <?php if (!empty($order['customer_id'])): ?>
          <a href="<?= App::baseUrl('account/orders/' . $order['id']) ?>" class="btn btn-l" style="padding:12px 24px;">View Order Status</a>
        <?php endif; ?>
      </div>

    </div>
  </div>
</div>
