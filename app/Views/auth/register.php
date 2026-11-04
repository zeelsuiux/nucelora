<?php
use App\Config\App;
use App\Helpers\Esc;
use App\Helpers\Csrf;
use App\Helpers\Session;

$error = Session::getFlash('register_error');
?>

<div class="page" style="padding:60px 0 100px;">
  <div class="w" style="max-width:480px;">
    <div style="background:#fff; border:1px solid var(--line); border-radius:12px; padding:36px; text-align:center;">
      <span class="lab o">Join the Lymko Collective</span>
      <h1 class="h1" style="font-size:28px; margin:12px 0 20px;">Create Account</h1>

      <?php if ($error): ?>
        <div style="background:#fee2e2; border:1px solid #fca5a5; color:#b91c1c; border-radius:6px; padding:12px; font-size:13px; margin-bottom:20px; text-align:left;">
          <?= Esc::html($error) ?>
        </div>
      <?php endif; ?>

      <form action="<?= App::baseUrl('account/register/submit') ?>" method="POST" style="display:flex; flex-direction:column; gap:16px; text-align:left;">
        <?= Csrf::field() ?>
        <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px;">
          <div>
            <label style="display:block; font-size:13px; font-weight:600; margin-bottom:6px;">First Name *</label>
            <input type="text" name="first_name" required placeholder="First name" style="width:100%; padding:12px; border:1px solid var(--line); border-radius:4px; font-size:14px;">
          </div>
          <div>
            <label style="display:block; font-size:13px; font-weight:600; margin-bottom:6px;">Last Name</label>
            <input type="text" name="last_name" placeholder="Last name" style="width:100%; padding:12px; border:1px solid var(--line); border-radius:4px; font-size:14px;">
          </div>
        </div>

        <div>
          <label style="display:block; font-size:13px; font-weight:600; margin-bottom:6px;">Email Address *</label>
          <input type="email" name="email" required placeholder="name@example.com" style="width:100%; padding:12px; border:1px solid var(--line); border-radius:4px; font-size:14px;">
        </div>

        <div>
          <label style="display:block; font-size:13px; font-weight:600; margin-bottom:6px;">Mobile Phone (Optional)</label>
          <input type="tel" name="phone" placeholder="10-digit mobile" style="width:100%; padding:12px; border:1px solid var(--line); border-radius:4px; font-size:14px;">
        </div>

        <div>
          <label style="display:block; font-size:13px; font-weight:600; margin-bottom:6px;">Password (Minimum 6 characters) *</label>
          <input type="password" name="password" minlength="6" required placeholder="••••••••" style="width:100%; padding:12px; border:1px solid var(--line); border-radius:4px; font-size:14px;">
        </div>

        <button type="submit" class="btn btn-k" style="width:100%; padding:14px 0; margin-top:8px;">Create My Account</button>
      </form>

      <div style="margin-top:24px; padding-top:20px; border-top:1px solid var(--line); font-size:14px; color:var(--ink2);">
        Already have an account? <a href="<?= App::baseUrl('account/login') ?>" style="font-weight:600; color:var(--or);">Sign in here</a>
      </div>
    </div>
  </div>
</div>
