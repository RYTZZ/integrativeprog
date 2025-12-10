<?php
require_once __DIR__ . '/../config/config.php';
require_login();
$user = current_user($pdo);

if (!isset($_GET['id'])) die("Missing note ID");

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
  <title>Edit Note — Student Notes</title>
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
    <div class="container-sm">

      <div class="form-card note-form">
        <h2>Edit Note</h2>
        <div class="form-sub">Update your note details.</div>

        <form action="../src/note_update.php" method="post">
          <input type="hidden" name="id" value="<?php echo $note['id']; ?>">
          <input type="hidden" name="csrf" value="<?php echo htmlspecialchars(csrf_token()); ?>">

          <label>Title</label>
          <input class="input" name="title" value="<?php echo htmlspecialchars($note['title']); ?>" required>

          <label style="margin-top:12px;">Content</label>
          <textarea class="input" name="content" required><?php echo htmlspecialchars($note['content']); ?></textarea>

          <div class="form-actions">
            <button class="btn" type="submit">Save Changes</button>
            <a class="btn ghost" href="dashboard.php">Cancel</a>
            <a class="btn danger" href="delete_note.php?id=<?php echo $note['id']; ?>">Delete</a>
          </div>
        </form>

      </div>

    </div>
  </main>

</div>

</body>
</html>
