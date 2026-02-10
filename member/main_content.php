<?php

$user_id = $_SESSION['user_id'];

$stmtProfile = $condb->prepare(
  "SELECT username, role 
   FROM users 
   WHERE user_id = :user_id"
);
$stmtProfile->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$stmtProfile->execute();
$row = $stmtProfile->fetch(PDO::FETCH_ASSOC);

if (!$row) {
  exit;
}
?>

<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <h1 class="m-0">My Profile</h1>
      </div><!-- /.col -->
    </section>   
      
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="card">
        <div class="card-body">

          <div class="form-group">
            <label>Username</label>
            <input type="text" class="form-control" 
                   value="<?= $row['username']; ?>" disabled>
          </div>

          <div class="form-group">
            <label>Password</label>
            <input type="password" class="form-control" value="********" disabled>
          </div>

          <!-- Role -->
          <div class="form-group mt-3">
            <label>Role</label>
            <input type="text" class="form-control"
                   value="<?= ucfirst($row['role']); ?>" disabled>
          </div>
          
          <a href="member_form_edit.php" class="btn btn-info">
            Edit Username
          </a>

          <a href="member_form_edit_password.php" class="btn btn-warning">
            Reset Password
          </a>

        </div>
      </div>
    </div>
  </section>
</div>