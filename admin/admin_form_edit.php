<?php
if (isset($_GET['user_id']) && $_GET['act'] == 'edit') {
  //single row query
  $stmtUserDetail = $condb->prepare("SELECT* FROM USERS WHERE user_id=?");
  $stmtUserDetail->execute([$_GET['user_id']]);
  $row = $stmtUserDetail->fetch(PDO::FETCH_ASSOC);

  // echo '<pre>';
  // print_r($row);
  // exit;

  //ถ้าคิวรี่ผิดพลาดให้กลับไปหน้า index
  if ($stmtUserDetail->rowCount() != 1) {
    exit();
  }
} //isset
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Edit User Form</h1>
        </div>

      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="card card-outline card-info">
          <div class="card-body">
            <div class="card card-primary">

              <!-- form start -->
              <form action="" method="POST">
                <div class="card-body">
                  <div class="form-group row">
                    <label class="col-sm-2">Username</label>
                    <div class="col-sm-4">
                      <input type="email" name="username" class="form-control" value="<?php echo $row['username']; ?>" required>
                    </div>
                  </div>


                  <div class="form-group row">
                    <label class="col-sm-2">Password</label>
                    <div class="col-sm-4">
                      <input type="password" name="password" class="form-control" value="********" disabled>
                    </div>
                  </div>

                  <div class="form-group row">
                    <label class="col-sm-2">Role</label>
                    <div class="col-sm-4">
                      <select name="role" class="form-control" required>
                        <option value="<?php echo $row['role']; ?>"><?php echo $row['role']; ?></option>
                      <option disabled>-- Select New Role --</option>
                        <option value="admin">admin</option>
                        <option value="member">member</option>
                      </select>
                    </div>
                  </div>

                  <div class="form-group row">
                    <label class="col-sm-2"></label>
                    <div class="col-sm-4">
                      <input type="hidden" name="user_id" value="<?php echo $row['user_id']; ?>">
                      <!-- <button type="submit" class="btn btn-primary btn-lg btn-block"> Add </button>  -->
                      <button type="submit" class="btn btn-warning"> Update </button>
                      <a href="admin.php" class="btn btn-danger">Cancel</a>
                    </div>
                  </div>
                </div>
                <!-- /.card-body -->


              </form>
              
            </div>
          </div>
        </div>
        <!-- /.col-->
      </div>
      <!-- ./row -->

      <!-- ./row -->
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<?php
              if (isset($_POST['user_id']) && isset($_POST['username']) && isset($_POST['role'])) {

                //ประกาศตัวแปรรับค่าจากฟอร์ม
                $user_id = $_POST['user_id'];
                $username = $_POST['username'];
                $role = $_POST['role'];

                // ตรวจ username ซ้ำ (ยกเว้น user_id ตัวเอง)
                $stmtCheck = $condb->prepare(
                    "SELECT user_id FROM users 
                    WHERE username = :username 
                    AND user_id != :user_id"
                  );
                $stmtCheck->bindParam(':username', $username, PDO::PARAM_STR);
                $stmtCheck->bindParam(':user_id', $user_id, PDO::PARAM_INT);
                $stmtCheck->execute();

                if ($stmtCheck->rowCount() > 0) {
                  echo '<script>
                    setTimeout(function() {
                    swal({
                      title: "Username นี้ถูกใช้งานแล้ว",
                      type: "warning"
                    }, function() {
                      window.history.back();
                    });
                  }, 1000);
                  </script>';
                  exit;
                }

                //sql update
                $stmtUpdate = $condb->prepare("UPDATE  USERS SET username=:username, role=:role WHERE user_id=:user_id");
                //bindParam
                $stmtUpdate->bindParam(':user_id', $user_id, PDO::PARAM_INT);
                $stmtUpdate->bindParam(':username', $username, PDO::PARAM_STR);
                $stmtUpdate->bindParam(':role', $role, PDO::PARAM_STR);
                $result = $stmtUpdate->execute();

                $condb = null; //close connect db
                if ($result) {
                  echo '<script>
                    setTimeout(function() {
                    swal({
                      title: "Update Data Successfully",
                      type: "success"
                    }, function() {
                      window.location = "admin.php"; //หน้าที่ต้องการให้กระโดดไป
                    });
                  }, 1000);
                </script>';
                exit;
              } else {
                  echo '<script>
                    setTimeout(function() {
                    swal({
                      title: "Error Updating Data",
                      type: "error"
                    }, function() {
                      window.location = "admin.php"; //หน้าที่ต้องการให้กระโดดไป
                    });
                  }, 1000);
                </script>';
              }
              }
              ?>