<?php
require_once __DIR__ . '/../config/config.php';
require_login();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../public/new_note.php'); exit;
}

$title = trim($_POST['title'] ?? '');
$content = trim($_POST['content'] ?? '');
$csrf = $_POST['csrf'] ?? '';

$_SESSION['note_old'] = ['title' => $title, 'content' => $content];
$errors = [];

if (!check_csrf($csrf)) $errors[] = 'Invalid request.';
if ($title === '' || $content === '') $errors[] = 'All fields are required.';
if (strlen($title) > 200) $errors[] = 'Title too long.';

if ($errors) {
    $_SESSION['note_errors'] = $errors;
    header('Location: ../public/new_note.php'); exit;
}

$ins = $pdo->prepare("INSERT INTO notes (user_id,title,content) VALUES (?,?,?)");
$ins->execute([$_SESSION['user_id'], $title, $content]);

unset($_SESSION['note_old']);
header('Location: ../public/dashboard.php');
exit;
