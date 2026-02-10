<?php
$user_id = $_SESSION['user_id'];

$stmt = $condb->prepare(
  "SELECT username FROM users WHERE user_id = ?"
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
      <h1>Reset Password</h1>
    </div>
  </section>

  <section class="content">
    <div class="container-fluid">
      <div class="card">
        <div class="card-body">

          <form method="post">
            <div class="form-group">
              <label>Username</label>
              <input type="email" class="form-control"
                     value="<?= htmlspecialchars($row['username']); ?>" disabled>
            </div>

            <div class="form-group">
              <label>New Password</label>
              <input type="password" name="new_password"
                     class="form-control" required>
            </div>

            <div class="form-group">
              <label>Confirm Password</label>
              <input type="password" name="confirm_password"
                     class="form-control" required>
            </div>

            <button type="submit" class="btn btn-warning">Reset Password</button>
            <a href="member.php" class="btn btn-secondary">Cancel</a>
          </form>

        </div>
      </div>
    </div>
  </section>
</div>

<?php
if (isset($_POST['new_password'], $_POST['confirm_password'])) {

  if ($_POST['new_password'] !== $_POST['confirm_password']) {
    echo '<script>
      swal("Error","Passwords do not match","error");
    </script>';
    exit;
  }

  $hash = password_hash($_POST['new_password'], PASSWORD_ARGON2ID);

  $stmtUpdate = $condb->prepare(
    "UPDATE users SET password = ? WHERE user_id = ?"
  );
  $stmtUpdate->execute([$hash, $user_id]);

  echo '<script>
    swal("Success","Password reset successfully","success")
    .then(()=>{ window.location="member.php"; });
  </script>';
}
?>
