<?php
use App\Config\App;
use App\Helpers\Esc;
use App\Helpers\Csrf;
use App\Helpers\Session;

$flashSuccess = Session::getFlash('contact_success');
?>

<div class="page" style="padding:50px 0 100px; background:#faf9f6; min-height:80vh;">
  <div class="w" style="max-width:960px; margin:0 auto; padding:0 16px;">
    
    <div style="text-align:center; margin-bottom:44px;">
      <span class="lab o" style="background:var(--orsoft); color:var(--or); padding:5px 14px; border-radius:99px; font-size:12px; font-weight:700; letter-spacing:0.08em; text-transform:uppercase;">We're here to help</span>
      <h1 class="h1" style="font-size:36px; font-weight:700; margin:14px 0 8px; color:var(--ink);">Get in Touch with Nucelora</h1>
      <p style="color:var(--muted); max-width:540px; margin:0 auto; font-size:15px; line-height:1.6;">
        Questions about our botanical active formulas, routine recommendations, or your order tracking? Our skincare experts are here to assist you.
      </p>
    </div>

    <?php if ($flashSuccess): ?>
      <div style="background:#dcfce7; border:1px solid #86efac; color:#15803d; border-radius:12px; padding:18px 24px; margin-bottom:32px; text-align:center; font-weight:600;">
        ✓ <?= Esc::html($flashSuccess) ?>
      </div>
    <?php endif; ?>

    <div style="display:grid; grid-template-columns:1fr 1fr; gap:40px; align-items:start;" class="contact-grid">
      <!-- Contact Form -->
      <div style="background:#fff; border:1px solid var(--line); border-radius:16px; padding:32px; box-shadow:0 2px 12px rgba(0,0,0,0.025);">
        <h3 style="font-size:20px; font-weight:700; margin:0 0 20px; color:var(--ink);">Send Us a Message</h3>
        <form action="<?= App::baseUrl('pages/contact/submit') ?>" method="POST" style="display:flex; flex-direction:column; gap:16px;">
          <?= Csrf::field() ?>
          <div>
            <label style="display:block; font-size:12.5px; font-weight:600; margin-bottom:6px; color:var(--ink2);">Your Name *</label>
            <input type="text" name="name" required placeholder="Full name" style="width:100%; height:46px; padding:0 14px; border:1px solid #dcdcdc; border-radius:8px; font-size:14px; outline:none; box-sizing:border-box;">
          </div>
          <div>
            <label style="display:block; font-size:12.5px; font-weight:600; margin-bottom:6px; color:var(--ink2);">Email Address *</label>
            <input type="email" name="email" required placeholder="name@example.com" style="width:100%; height:46px; padding:0 14px; border:1px solid #dcdcdc; border-radius:8px; font-size:14px; outline:none; box-sizing:border-box;">
          </div>
          <div>
            <label style="display:block; font-size:12.5px; font-weight:600; margin-bottom:6px; color:var(--ink2);">Mobile Phone (Optional)</label>
            <input type="tel" name="phone" placeholder="10-digit number" style="width:100%; height:46px; padding:0 14px; border:1px solid #dcdcdc; border-radius:8px; font-size:14px; outline:none; box-sizing:border-box;">
          </div>
          <div>
            <label style="display:block; font-size:12.5px; font-weight:600; margin-bottom:6px; color:var(--ink2);">Subject *</label>
            <input type="text" name="subject" required placeholder="Order inquiry, skincare routine advice..." style="width:100%; height:46px; padding:0 14px; border:1px solid #dcdcdc; border-radius:8px; font-size:14px; outline:none; box-sizing:border-box;">
          </div>
          <div>
            <label style="display:block; font-size:12.5px; font-weight:600; margin-bottom:6px; color:var(--ink2);">Message *</label>
            <textarea name="message" rows="4" required placeholder="How can we help your skin today?" style="width:100%; padding:12px 14px; border:1px solid #dcdcdc; border-radius:8px; font-size:14px; font-family:var(--sans); outline:none; box-sizing:border-box;"></textarea>
          </div>
          <button type="submit" class="btn btn-k" style="height:50px; font-size:15px; font-weight:700; border-radius:99px; cursor:pointer;">
            Send Message &rarr;
          </button>
        </form>
      </div>

      <!-- Contact Info Cards -->
      <div style="display:flex; flex-direction:column; gap:20px;">
        <div style="background:#fff; border:1px solid var(--line); border-radius:16px; padding:26px; box-shadow:0 2px 8px rgba(0,0,0,0.02);">
          <div style="display:flex; align-items:center; gap:12px; margin-bottom:12px;">
            <div style="width:38px; height:38px; border-radius:10px; background:#e8f5e9; color:#2e7d32; display:flex; align-items:center; justify-content:center;">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:20px;height:20px;"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/></svg>
            </div>
            <h4 style="margin:0; font-size:17px; font-weight:700; color:var(--ink);">WhatsApp Support</h4>
          </div>
          <p style="font-size:13.5px; color:var(--muted); margin:0 0 14px; line-height:1.5;">Instant chat support for routine consultations, order tracking, and delivery updates.</p>
          <a href="https://wa.me/918866611621" target="_blank" rel="noopener" class="btn btn-k sm" style="background:#25D366; border-color:#25D366; color:#fff; display:inline-flex; align-items:center; gap:8px; border-radius:99px; text-decoration:none;">
            Chat on WhatsApp (+91 88666 11621)
          </a>
        </div>

        <div style="background:#fff; border:1px solid var(--line); border-radius:16px; padding:26px; box-shadow:0 2px 8px rgba(0,0,0,0.02);">
          <div style="display:flex; align-items:center; gap:12px; margin-bottom:12px;">
            <div style="width:38px; height:38px; border-radius:10px; background:var(--orsoft); color:var(--or); display:flex; align-items:center; justify-content:center;">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:20px;height:20px;"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
            </div>
            <h4 style="margin:0; font-size:17px; font-weight:700; color:var(--ink);">Customer Care Email</h4>
          </div>
          <p style="font-size:13.5px; color:var(--muted); margin:0 0 8px;">For order status, returns, and business inquiries:</p>
          <a href="mailto:care@nucelora.com" style="font-weight:700; color:var(--or); font-size:16px; text-decoration:none;">care@nucelora.com</a>
        </div>

        <div style="background:#fff; border:1px solid var(--line); border-radius:16px; padding:26px; box-shadow:0 2px 8px rgba(0,0,0,0.02);">
          <div style="display:flex; align-items:center; gap:12px; margin-bottom:12px;">
            <div style="width:38px; height:38px; border-radius:10px; background:var(--soft2); color:var(--ink); display:flex; align-items:center; justify-content:center;">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:20px;height:20px;"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
            </div>
            <h4 style="margin:0; font-size:17px; font-weight:700; color:var(--ink);">Nucelora Skincare Headquarters</h4>
          </div>
          <p style="font-size:13.5px; color:var(--ink2); margin:0; line-height:1.6;">
            <b>Nucelora Skincare India</b><br>
            Surat, Gujarat, India &middot; 395006<br>
            Operating Hours: Mon - Sat (10:00 AM - 7:00 PM IST)
          </p>
        </div>
      </div>
    </div>

  </div>
</div>

<style>
@media (max-width: 820px) {
  .contact-grid {
    grid-template-columns: 1fr !important;
  }
}
</style>
