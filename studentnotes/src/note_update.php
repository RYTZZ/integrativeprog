<?php
require_once __DIR__ . '/../config/config.php';
require_login();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../public/dashboard.php'); exit;
}

$id = (int)($_POST['id'] ?? 0);
$title = trim($_POST['title'] ?? '');
$content = trim($_POST['content'] ?? '');
$csrf = $_POST['csrf'] ?? '';
$errors = [];

if (!check_csrf($csrf)) $errors[] = 'Invalid request.';
if ($id <= 0) $errors[] = 'Invalid note.';
if ($title === '' || $content === '') $errors[] = 'All fields are required.';

if ($errors) {
    $_SESSION['note_errors'] = $errors;
    header('Location: ../public/edit_note.php?id=' . $id); exit;
}

// ensure owner
$stmt = $pdo->prepare("SELECT id FROM notes WHERE id = ? AND user_id = ?");
$stmt->execute([$id, $_SESSION['user_id']]);
if (!$stmt->fetch()) {
    $_SESSION['note_errors'] = ['Note not found or access denied.'];
    header('Location: ../public/dashboard.php'); exit;
}

$upd = $pdo->prepare("UPDATE notes SET title = ?, content = ? WHERE id = ?");
$upd->execute([$title, $content, $id]);

header('Location: ../public/dashboard.php');
exit;
