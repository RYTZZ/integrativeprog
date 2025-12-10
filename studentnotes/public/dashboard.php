<?php
require_once __DIR__ . '/../config/config.php';
require_login();

$user = current_user($pdo);

// Fetch user notes
$stmt = $pdo->prepare("SELECT * FROM notes WHERE user_id=? ORDER BY created_at DESC");
$stmt->execute([$user['id']]);
$notes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Dashboard — Student Notes</title>
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
        <div class="subtitle">Welcome, <?php echo htmlspecialchars($user['first_name']); ?></div>
      </div>
    </div>

    <nav class="nav">
      <a href="dashboard.php" class="nav-item active">Dashboard</a>
      <a href="new_note.php" class="nav-item">New Note</a>
      <a href="logout.php" class="nav-item logout">Logout</a>
    </nav>
  </aside>


  <!-- Main -->
  <main class="main">

    <h1 style="margin-bottom:20px; font-size:26px; font-weight:700;">
      Your Notes
    </h1>

    <?php if (empty($notes)) : ?>
      <div class="form-card" style="text-align:center; padding:40px;">
        <h2>No Notes Yet</h2>
        <p style="opacity:.7; margin-bottom:18px;">Click the button below to create your first note.</p>
        <a href="new_note.php" class="btn">Create Note</a>
      </div>
    <?php else : ?>

    <div class="notes-list">

      <?php foreach($notes as $note): ?>
      <a class="note-card" href="view_note.php?id=<?php echo $note['id']; ?>">
        <div class="note-title">
          <?php echo htmlspecialchars($note['title']); ?>
        </div>

        <div class="note-date">
          <?php echo date("M d, Y • h:i A", strtotime($note['created_at'])); ?>
        </div>

        <div class="note-preview">
          <?php 
            echo nl2br(htmlspecialchars(
              mb_strimwidth($note['content'], 0, 160, "…")
            ));
          ?>
        </div>
      </a>
      <?php endforeach; ?>

    </div>

    <?php endif; ?>

  </main>

</div>

</body>
</html>
