<?php
require_once __DIR__ . '/../config/config.php';
require_login();
$user = current_user($pdo);

if (!isset($_GET['id'])) {
    header('Location: dashboard.php'); exit;
}
$id = (int)$_GET['id'];

$stmt = $pdo->prepare("SELECT * FROM notes WHERE id = ? AND user_id = ?");
$stmt->execute([$id, $user['id']]);
$note = $stmt->fetch();

if (!$note) {
    header('Location: dashboard.php'); exit;
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title><?php echo htmlspecialchars($note['title']); ?> — Student Notes</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <link rel="stylesheet" href="style.css">
</head>
<body class="dashboard-page">

<div class="app">
  <aside class="sidebar glass">
    <div class="side-header">
      <div class="logo-circle">SN</div>
      <div class="title-block"><div class="title">Student Notes</div></div>
    </div>

    <nav class="nav">
      <a href="index.php" class="nav-item">🏠 Home</a>
      <a href="dashboard.php" class="nav-item">📋 Dashboard</a>
      <a href="new_note.php" class="nav-item">✚ New Note</a>
    </nav>

    <div class="logout-bottom" style="margin-top:auto;">
      <a href="logout.php" style="color:inherit; text-decoration:none;">🔓 Logout</a>
    </div>
  </aside>

  <main class="main">
    <div class="view-note">
      <div class="note-card">
        <h1><?php echo htmlspecialchars($note['title']); ?></h1>
        <div class="meta">Created: <?php echo date('M j, Y • H:i', strtotime($note['created_at'])); ?></div>

        <div class="content"><?php echo nl2br(htmlspecialchars($note['content'])); ?></div>

        <div class="action-bar" style="margin-top:14px;">
          <a class="btn" href="edit_note.php?id=<?php echo $note['id']; ?>">Edit ✏️</a>

          <form action="../src/note_delete.php" method="post" style="display:inline;" onsubmit="return confirm('Delete this note?');">
            <input type="hidden" name="csrf" value="<?php echo htmlspecialchars(csrf_token()); ?>">
            <input type="hidden" name="id" value="<?php echo $note['id']; ?>">
            <button type="submit" class="btn danger">Delete 🗑️</button>
          </form>

          <a class="btn ghost" href="dashboard.php">Back ↩</a>
        </div>
      </div>
    </div>
  </main>
</div>

</body>
</html>
