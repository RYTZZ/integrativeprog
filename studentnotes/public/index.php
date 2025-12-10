<?php
require_once __DIR__ . '/../config/config.php';
if (is_logged_in()) {
    header('Location: dashboard.php');
    exit;
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Student Notes System</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <link rel="stylesheet" href="style.css">
</head>

<body class="auth-page">

<div class="container">

  <div class="header">
    <div class="brand">
      <div class="logo">SN</div>
      <div>
        <div class="h1">Student Notes</div>
        <div class="sub">Secure. Minimal. Private.</div>
      </div>
    </div>

    <div class="actions">
      <a class="btn" href="register.php">Create Account</a>
      <a class="btn ghost" href="login.php">Login</a>
    </div>
  </div>

  <div class="card" style="margin-top:25px; text-align:center;">
    <h2 style="margin-bottom:8px;">Welcome!</h2>
    <p class="sub" style="font-size:14px; max-width:420px; margin:auto;">
      A simple and secure PHP system using PDO + MySQL.
      Register and start creating your private notes anytime.
    </p>

    <div style="margin-top:18px; display:flex; gap:10px; justify-content:center;">
      <a class="btn" href="register.php">Get Started</a>
      <a class="btn ghost" href="login.php">I Already Have an Account</a>
    </div>
  </div>

  <div class="footer" style="text-align:center; margin-top:25px; opacity:.6; font-size:13px;">
    Student Notes System • For academic use only
  </div>

</div>

</body>
</html>
