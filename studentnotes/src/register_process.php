<?php
require_once __DIR__ . '/../config/config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../public/register.php'); exit;
}

$errors = [];
$first = trim($_POST['first_name'] ?? '');
$middle = trim($_POST['middle_name'] ?? '');
$last = trim($_POST['last_name'] ?? '');
$suffix = trim($_POST['suffix'] ?? '');
$email = trim($_POST['email'] ?? '');
$pw = $_POST['password'] ?? '';
$pw2 = $_POST['password_confirm'] ?? '';
$csrf = $_POST['csrf'] ?? '';

$_SESSION['form_old'] = compact('first','middle','last','suffix','email');

if (!check_csrf($csrf)) {
    $errors[] = 'Invalid request (CSRF).';
}
if ($first === '' || $last === '' || $email === '' || $pw === '') {
    $errors[] = 'Please fill in required fields.';
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = 'Please enter a valid email.';
}
if ($pw !== $pw2) {
    $errors[] = 'Passwords do not match.';
}
if (strlen($pw) < 6) {
    $errors[] = 'Password must be at least 6 characters.';
}

if ($errors) {
    $_SESSION['form_errors'] = $errors;
    header('Location: ../public/register.php'); exit;
}

// check duplicate email
$stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
$stmt->execute([$email]);
if ($stmt->fetch()) {
    $_SESSION['form_errors'] = ['Email already registered.'];
    header('Location: ../public/register.php'); exit;
}

// insert
$hash = password_hash($pw, PASSWORD_DEFAULT);
$ins = $pdo->prepare("INSERT INTO users (first_name,middle_name,last_name,suffix,email,password_hash) VALUES (?,?,?,?,?,?)");
$ins->execute([$first,$middle,$last,$suffix,$email,$hash]);

// auto-login
$newId = $pdo->lastInsertId();
$_SESSION['user_id'] = (int)$newId;
unset($_SESSION['form_old']);
header('Location: ../public/dashboard.php');
exit;
