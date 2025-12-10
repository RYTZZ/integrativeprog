<?php
require_once __DIR__ . '/../config/config.php';
require_login();
$user = current_user($pdo);

if (!isset($_GET['id'])) die("Missing ID");

$id = $_GET['id'];

$stmt = $pdo->prepare("SELECT * FROM notes WHERE id=? AND user_id=?");
$stmt->execute([$id, $user['id']]);
$note = $stmt->fetch();

if (!$note) die("Note not found");
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Delete Note — Student Notes</title>
  <link rel="stylesheet" href="style.css">
</head>

<body class="dashboard-page">

<div class="app">

  <!-- Sidebar -->
  <aside class="sidebar glass">
    <div class="side-header">
      <div class="logo-circle">SN</div>
      <div class="title-block">
        <div class="title">Student Notes</div>
        <div class="subtitle">Your private notes</div>
      </div>
    </div>

    <nav class="nav">
      <a href="dashboard.php" class="nav-item">Dashboard</a>
      <a href="new_note.php" class="nav-item">New Note</a>
      <a href="logout.php" class="nav-item logout">Logout</a>
    </nav>
  </aside>


  <!-- Main -->
  <main class="main">

    <div class="confirm-delete">
      <h3>Delete this note?</h3>
      <p>This action cannot be undone.</p>

      <form action="../src/note_delete.php" method="post">
        <input type="hidden" name="id" value="<?php echo $note['id']; ?>">
        <input type="hidden" name="csrf" value="<?php echo htmlspecialchars(csrf_token()); ?>">

        <div class="form-actions" style="justify-content:center;">
          <button class="btn danger" type="submit">Delete</button>
          <a href="dashboard.php" class="btn ghost">Cancel</a>
        </div>
      </form>
    </div>

  </main>

</div>

</body>
</html>
