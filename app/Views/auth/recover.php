<?php
use App\Config\App;
use App\Helpers\Esc;
use App\Helpers\Csrf;
use App\Helpers\Session;

$error = Session::getFlash('recover_error');
$success = Session::getFlash('recover_success');
?>

<div class="page" style="padding:60px 0 100px;">
  <div class="w" style="max-width:440px;">
    <div style="background:#fff; border:1px solid var(--line); border-radius:14px; padding:36px; text-align:center; box-shadow:0 4px 20px rgba(0,0,0,0.03);">
      <span class="lab o">Account Security</span>
      <h1 class="h1" style="font-size:26px; margin:12px 0 10px;">Reset Password</h1>
      <p style="font-size:14px; color:var(--muted); margin:0 0 24px; line-height:1.5;">
        Enter your registered email address and we'll help you securely reset your password.
      </p>

      <?php if ($error): ?>
        <div style="background:#fee2e2; border:1px solid #fca5a5; color:#b91c1c; border-radius:8px; padding:12px; font-size:13px; margin-bottom:20px; text-align:left;">
          <?= Esc::html($error) ?>
        </div>
      <?php endif; ?>

      <?php if ($success): ?>
        <div style="background:#dcfce7; border:1px solid #86efac; color:#15803d; border-radius:8px; padding:14px; font-size:13px; margin-bottom:20px; text-align:left; line-height:1.5;">
          <?= $success /* allow trusted local HTML link */ ?>
        </div>
      <?php endif; ?>

      <form action="<?= App::baseUrl('account/recover/submit') ?>" method="POST" style="display:flex; flex-direction:column; gap:16px; text-align:left;">
        <?= Csrf::field() ?>
        <div>
          <label style="display:block; font-size:13px; font-weight:600; margin-bottom:6px;">Your Email Address</label>
          <input type="email" name="email" required placeholder="name@example.com" style="width:100%; padding:12px; border:1px solid var(--line); border-radius:6px; font-size:14px; box-sizing:border-box;">
        </div>

        <button type="submit" class="btn btn-k" style="width:100%; padding:14px 0; margin-top:6px; font-weight:700;">Send Reset Link</button>
      </form>

      <div style="margin-top:24px; padding-top:20px; border-top:1px solid var(--line); font-size:13.5px; color:var(--ink2);">
        Remember your password? <a href="<?= App::baseUrl('account/login') ?>" style="font-weight:600; color:var(--or);">Back to sign in</a>
      </div>
    </div>
  </div>
</div>
