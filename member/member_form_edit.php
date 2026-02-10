<?php
$user_id = $_SESSION['user_id'];

$stmt = $condb->prepare(
  "SELECT username, role FROM users WHERE user_id = ?"
);
$stmt->execute([$user_id]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$row) {
  exit;
}
?>

<div class="content-wrapper">
  <section class="content-header">
    <div class="container-fluid">
      <h1>Edit Username</h1>
    </div>
  </section>

  <section class="content">
    <div class="container-fluid">
      <div class="card">
        <div class="card-body">

          <form method="post">
            <div class="form-group">
              <label>Username</label>
              <input type="email" name="username" class="form-control"
                     value="<?= htmlspecialchars($row['username']); ?>" required>
            </div>

            <div class="form-group">
              <label>Role</label>
              <input type="text" class="form-control"
                     value="<?= $row['role']; ?>" disabled>
            </div>

            <button type="submit" class="btn btn-warning">Update</button>
            <a href="member.php" class="btn btn-secondary">Cancel</a>
          </form>

        </div>
      </div>
    </div>
  </section>
</div>

<?php
if (isset($_POST['username'])) {

  $username = $_POST['username'];

  // เช็ค username ซ้ำ
  $stmtCheck = $condb->prepare(
    "SELECT user_id FROM users 
     WHERE username = ? AND user_id != ?"
  );
  $stmtCheck->execute([$username, $user_id]);

  if ($stmtCheck->rowCount() > 0) {
    echo '<script>swal("Error","Username ถูกใช้แล้ว","warning");</script>';
  } else {

    $stmtUpdate = $condb->prepare(
      "UPDATE users SET username = ? WHERE user_id = ?"
    );
    $stmtUpdate->execute([$username, $user_id]);

    echo '<script>
      swal("Success","Username updated","success")
      .then(()=>{ window.location="member.php"; });
    </script>';
  }
}
?>
