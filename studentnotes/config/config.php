<?php
// config/config.php
declare(strict_types=1);

session_start();

// Update DB credentials as needed
define('DB_HOST', '127.0.0.1');
define('DB_NAME', 'notes_db');
define('DB_USER', 'root');
define('DB_PASS', ''); // set your DB password

$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];

try {
    $pdo = new PDO(
        "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4",
        DB_USER,
        DB_PASS,
        $options
    );
} catch (PDOException $e) {
    // For production, log the error and show a generic message.
    die("Database connection failed: " . $e->getMessage());
}

function csrf_token(): string {
    if (empty($_SESSION['_csrf_token'])) {
        $_SESSION['_csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['_csrf_token'];
}

function check_csrf(string $token): bool {
    return hash_equals($_SESSION['_csrf_token'] ?? '', $token);
}

function is_logged_in(): bool {
    return !empty($_SESSION['user_id']);
}

function require_login(): void {
    if (!is_logged_in()) {
        header('Location: login.php');
        exit;
    }
}

function current_user(PDO $pdo) {
    if (!is_logged_in()) return null;
    $stmt = $pdo->prepare("SELECT id, first_name, middle_name, last_name, suffix, email FROM users WHERE id = ?");
    $stmt->execute([$_SESSION['user_id']]);
    return $stmt->fetch();
}
