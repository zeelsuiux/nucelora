<?php
use App\Config\App;
use App\Helpers\Esc;
use App\Helpers\Csrf;
use App\Helpers\Session;

$error = Session::getFlash('admin_login_error');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Sign In &mdash; Lymko E-commerce</title>
  <link rel="stylesheet" href="<?= App::asset('css/admin.css') ?>">
</head>
<body style="background:#0f172a; display:flex; align-items:center; justify-content:center; min-height:100vh; font-family:'Inter Tight', sans-serif;">
  <div style="background:#fff; border-radius:12px; padding:40px; width:100%; max-width:400px; box-shadow:0 20px 25px -5px rgba(0,0,0,0.5);">
    <div style="text-align:center; margin-bottom:28px;">
      <h2 style="font-size:22px; font-weight:700; color:#0f172a; margin-bottom:6px;">Lymko Control Center</h2>
      <p style="font-size:13px; color:#64748b;">Sign in with your administrative credentials</p>
    </div>

    <?php if ($error): ?>
      <div style="background:#fee2e2; border:1px solid #fca5a5; color:#b91c1c; border-radius:6px; padding:12px; font-size:13px; margin-bottom:20px;">
        <?= Esc::html($error) ?>
      </div>
    <?php endif; ?>

    <form action="<?= App::baseUrl('admin/login/submit') ?>" method="POST" style="display:flex; flex-direction:column; gap:16px;">
      <?= Csrf::field() ?>
      <div class="form-group" style="margin-bottom:0;">
        <label>Email Address</label>
        <input type="email" name="email" value="admin@lymko.in" required class="form-control">
      </div>
      <div class="form-group" style="margin-bottom:0;">
        <label>Password</label>
        <input type="password" name="password" value="admin123" required class="form-control">
      </div>
      <button type="submit" class="btn-admin btn-admin-primary" style="justify-content:center; padding:12px; font-size:14px; margin-top:8px;">
        Sign In to Admin Panel &rarr;
      </button>
    </form>
    <div style="margin-top:20px; text-align:center; font-size:12px; color:#94a3b8;">
      Default login: <b>admin@lymko.in</b> / <b>admin123</b>
    </div>
  </div>
</body>
</html>
