<?php
require_once __DIR__ . '/../config/config.php';
if (is_logged_in()) header('Location: dashboard.php');

$errors = $_SESSION['login_errors'] ?? [];
$old = $_SESSION['login_old'] ?? [];
unset($_SESSION['login_errors'], $_SESSION['login_old']);
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Login — Student Notes</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <link rel="stylesheet" href="style.css">
</head>
<body class="auth-page">
  <div class="container-sm">
    <div class="card">
      <div class="header">
        <div class="brand">
          <div class="logo">SN</div>
          <div>
            <div class="h1">Login</div>
            <div class="sub">Access your notes</div>
          </div>
        </div>
        <div class="actions">
          <a class="btn ghost" href="register.php">Create account</a>
        </div>
      </div>

      <?php if(!empty($errors)): ?>
        <div class="err"><?php foreach($errors as $e) echo "<div>" . htmlspecialchars($e) . "</div>"; ?></div>
      <?php endif; ?>

      <form action="../src/login_process.php" method="post" style="margin-top:12px">
        <input type="hidden" name="csrf" value="<?php echo htmlspecialchars(csrf_token()); ?>">
        <label>Email</label>
        <input class="input" type="email" name="email" value="<?php echo htmlspecialchars($old['email'] ?? '') ?>" required>

        <label style="margin-top:12px">Password</label>
        <input class="input" type="password" name="password" required>

        <div style="margin-top:16px" class="actions">
          <button class="btn" type="submit">Login</button>
          <a class="btn ghost" href="index.php">Back</a>
        </div>
      </form>
    </div>

    <div class="footer" style="margin-top:14px;">Forgot password? Contact admin.</div>
  </div>
</body>
</html>
