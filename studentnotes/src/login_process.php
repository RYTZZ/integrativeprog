<?php
require_once __DIR__ . '/../config/config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../public/login.php'); exit;
}

$email = trim($_POST['email'] ?? '');
$pw = $_POST['password'] ?? '';
$csrf = $_POST['csrf'] ?? '';

$_SESSION['login_old'] = ['email' => $email];

$errors = [];

if (!check_csrf($csrf)) $errors[] = 'Invalid request (CSRF).';
if ($email === '' || $pw === '') $errors[] = 'Please enter email and password.';

if ($errors) {
    $_SESSION['login_errors'] = $errors;
    header('Location: ../public/login.php'); exit;
}

$stmt = $pdo->prepare("SELECT id, password_hash FROM users WHERE email = ?");
$stmt->execute([$email]);
$user = $stmt->fetch();

if (!$user) {
    $_SESSION['login_errors'] = ['Email not found.'];
    header('Location: ../public/login.php'); exit;
}

if (!password_verify($pw, $user['password_hash'])) {
    $_SESSION['login_errors'] = ['Incorrect password.'];
    header('Location: ../public/login.php'); exit;
}

// success
$_SESSION['user_id'] = (int)$user['id'];
unset($_SESSION['login_old']);
header('Location: ../public/dashboard.php');
exit;
