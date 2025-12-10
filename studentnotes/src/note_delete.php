<?php
require_once __DIR__ . '/../config/config.php';
require_login();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../public/dashboard.php'); exit;
}

$id = (int)($_POST['id'] ?? 0);
$csrf = $_POST['csrf'] ?? '';

if (!check_csrf($csrf) || $id <= 0) {
    header('Location: ../public/dashboard.php'); exit;
}

// delete only if user owns it
$del = $pdo->prepare("DELETE FROM notes WHERE id = ? AND user_id = ?");
$del->execute([$id, $_SESSION['user_id']]);

header('Location: ../public/dashboard.php');
exit;
