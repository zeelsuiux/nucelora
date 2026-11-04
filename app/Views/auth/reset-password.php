<?php
use App\Config\App;
use App\Helpers\Esc;
use App\Helpers\Csrf;
use App\Helpers\Session;

$error = Session::getFlash('reset_error');
?>

<div class="page" style="padding:60px 0 100px;">
  <div class="w" style="max-width:440px;">
    <div style="background:#fff; border:1px solid var(--line); border-radius:14px; padding:36px; text-align:center; box-shadow:0 4px 20px rgba(0,0,0,0.03);">
      <span class="lab o">New Credentials</span>
      <h1 class="h1" style="font-size:26px; margin:12px 0 10px;">Create New Password</h1>
      <p style="font-size:13.5px; color:var(--muted); margin:0 0 24px;">
        Setting new password for: <b><?= Esc::html($email) ?></b>
      </p>

      <?php if ($error): ?>
        <div style="background:#fee2e2; border:1px solid #fca5a5; color:#b91c1c; border-radius:8px; padding:12px; font-size:13px; margin-bottom:20px; text-align:left;">
          <?= Esc::html($error) ?>
        </div>
      <?php endif; ?>

      <form action="<?= App::baseUrl('account/reset-password/submit') ?>" method="POST" style="display:flex; flex-direction:column; gap:16px; text-align:left;">
        <?= Csrf::field() ?>
        <input type="hidden" name="token" value="<?= Esc::attr($token) ?>">

        <div>
          <label style="display:block; font-size:13px; font-weight:600; margin-bottom:6px;">New Password (min 6 characters)</label>
          <input type="password" name="password" required minlength="6" placeholder="••••••••" style="width:100%; padding:12px; border:1px solid var(--line); border-radius:6px; font-size:14px; box-sizing:border-box;">
        </div>

        <div>
          <label style="display:block; font-size:13px; font-weight:600; margin-bottom:6px;">Confirm New Password</label>
          <input type="password" name="password_confirm" required minlength="6" placeholder="••••••••" style="width:100%; padding:12px; border:1px solid var(--line); border-radius:6px; font-size:14px; box-sizing:border-box;">
        </div>

        <button type="submit" class="btn btn-k" style="width:100%; padding:14px 0; margin-top:6px; font-weight:700;">Update Password &amp; Sign In</button>
      </form>
    </div>
  </div>
</div>
