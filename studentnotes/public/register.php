<?php
require_once __DIR__ . '/../config/config.php';
$errors = $_SESSION['form_errors'] ?? [];
$old = $_SESSION['form_old'] ?? [];
unset($_SESSION['form_errors'], $_SESSION['form_old']);
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Register — Student Notes</title>
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
            <div class="h1">Create account</div>
            <div class="sub">Register to save private notes</div>
          </div>
        </div>
        <div class="actions">
          <a class="btn ghost" href="login.php">Login</a>
        </div>
      </div>

      <?php if(!empty($errors)): ?>
        <div class="err">
          <?php foreach($errors as $e) echo "<div>" . htmlspecialchars($e) . "</div>"; ?>
        </div>
      <?php endif; ?>

      <form action="../src/register_process.php" method="post" style="margin-top:12px">
        <input type="hidden" name="csrf" value="<?php echo htmlspecialchars(csrf_token()); ?>">
        <div class="form-row">
          <div style="flex:1">
            <label>First name</label>
            <input class="input" name="first_name" value="<?php echo htmlspecialchars($old['first_name'] ?? '') ?>" required>
          </div>
          <div style="flex:1">
            <label>Middle name</label>
            <input class="input" name="middle_name" value="<?php echo htmlspecialchars($old['middle_name'] ?? '') ?>">
          </div>
        </div>

        <div class="form-row" style="margin-top:12px">
          <div style="flex:1">
            <label>Last name</label>
            <input class="input" name="last_name" value="<?php echo htmlspecialchars($old['last_name'] ?? '') ?>" required>
          </div>
          <div style="flex:0 0 140px">
            <label>Suffix</label>
            <input class="input" name="suffix" value="<?php echo htmlspecialchars($old['suffix'] ?? '') ?>">
          </div>
        </div>

        <div style="margin-top:12px">
          <label>Email</label>
          <input class="input" type="email" name="email" value="<?php echo htmlspecialchars($old['email'] ?? '') ?>" required>
        </div>

        <div class="form-row" style="margin-top:12px">
          <div style="flex:1">
            <label>Password</label>
            <input class="input" type="password" name="password" required>
          </div>
          <div style="flex:1">
            <label>Confirm password</label>
            <input class="input" type="password" name="password_confirm" required>
          </div>
        </div>

        <div style="margin-top:16px" class="actions">
          <button class="btn" type="submit">Create account</button>
          <a class="btn ghost" href="index.php">Back</a>
        </div>
      </form>
    </div>

    <div class="footer" style="margin-top:14px;">
      Already have an account? <a href="login.php">Login</a>
    </div>
  </div>
</body>
</html>
