<?php
use App\Config\App;
use App\Helpers\Esc;
use App\Helpers\Csrf;
use App\Helpers\Session;

$error = Session::getFlash('login_error');
$success = Session::getFlash('login_success');
?>

<div class="page" style="padding:60px 0 100px;">
  <div class="w" style="max-width:440px;">
    <div style="background:#fff; border:1px solid var(--line); border-radius:12px; padding:36px; text-align:center;">
      <span class="lab o">Customer Sign In</span>
      <h1 class="h1" style="font-size:28px; margin:12px 0 20px;">Welcome Back</h1>

      <?php if ($error): ?>
        <div style="background:#fee2e2; border:1px solid #fca5a5; color:#b91c1c; border-radius:6px; padding:12px; font-size:13px; margin-bottom:20px; text-align:left;">
          <?= Esc::html($error) ?>
        </div>
      <?php endif; ?>

      <?php if ($success): ?>
        <div style="background:#dcfce7; border:1px solid #86efac; color:#15803d; border-radius:6px; padding:12px; font-size:13px; margin-bottom:20px; text-align:left;">
          <?= Esc::html($success) ?>
        </div>
      <?php endif; ?>

      <form action="<?= App::baseUrl('account/login/submit') ?>" method="POST" style="display:flex; flex-direction:column; gap:16px; text-align:left;">
        <?= Csrf::field() ?>
        <div>
          <label style="display:block; font-size:13px; font-weight:600; margin-bottom:6px;">Email Address</label>
          <input type="email" name="email" required placeholder="name@example.com" style="width:100%; padding:12px; border:1px solid var(--line); border-radius:4px; font-size:14px;">
        </div>

        <div>
          <div style="display:flex; justify-content:space-between; margin-bottom:6px;">
            <label style="font-size:13px; font-weight:600;">Password</label>
            <a href="<?= App::baseUrl('account/recover') ?>" style="font-size:12px; color:var(--or);">Forgot?</a>
          </div>
          <input type="password" name="password" required placeholder="••••••••" style="width:100%; padding:12px; border:1px solid var(--line); border-radius:4px; font-size:14px;">
        </div>

        <button type="submit" class="btn btn-k" style="width:100%; padding:14px 0; margin-top:8px;">Sign In</button>
      </form>

      <div style="margin-top:24px; padding-top:20px; border-top:1px solid var(--line); font-size:14px; color:var(--ink2);">
        New to Lymko? <a href="<?= App::baseUrl('account/register') ?>" style="font-weight:600; color:var(--or);">Create an account</a>
      </div>
    </div>
  </div>
</div>
