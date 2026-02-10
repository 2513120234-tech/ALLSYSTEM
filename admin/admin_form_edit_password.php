<?php
if (isset($_GET['user_id']) && $_GET['act'] == 'editPwd') {
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
          <h1>Reset Password Form</h1>
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
                      <input type="email" name="username" class="form-control" value="<?php echo $row['username']; ?>" disabled>
                    </div>
                  </div>


                  <div class="form-group row">
                    <label class="col-sm-2">New Password</label>
                    <div class="col-sm-4">
                      <input type="password" name="NewPassword" class="form-control" required placeholder="Enter New password">
                    </div>
                  </div>

                  <div class="form-group row">
                    <label class="col-sm-2">Confirm Password</label>
                    <div class="col-sm-4">
                      <input type="password" name="confirmPassword" class="form-control" required placeholder="Confirm password">
                    </div>
                  </div>

                  <div class="form-group row">
                    <label class="col-sm-2"></label>
                    <div class="col-sm-4">
                      <input type="hidden" name="user_id" value="<?php echo $row['user_id']; ?>">
                      <!-- <button type="submit" class="btn btn-primary btn-lg btn-block"> Add </button>  -->
                      <button type="submit" class="btn btn-warning">Reset</button>
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
              if (isset($_POST['user_id']) && isset($_POST['NewPassword']) && isset($_POST['confirmPassword'])) {

                //ประกาศตัวแปรรับค่าจากฟอร์ม
                $user_id = $_POST['user_id'];
                $NewPassword = $_POST['NewPassword'];
                $confirmPassword = $_POST['confirmPassword'];

                //check password match
                if ($NewPassword != $confirmPassword) {
                  echo '<script>
                    setTimeout(function() {
                    swal({
                      title: "Passwords do not match",
                      text: "Please make sure both passwords are the same.",
                      type: "error"
                    }, function() {
                      window.location = "admin.php?act=editPwd&user_id=' . $user_id . '"; //หน้าที่ต้องการให้กระโดดไป
                    });
                  }, 1000);
                </script>';
                } else {
                  $password = password_hash($_POST['NewPassword'], PASSWORD_ARGON2ID);
                  //sql update
                $stmtUpdate = $condb->prepare("UPDATE  USERS SET password=:password WHERE user_id=:user_id");
                //bindParam
                $stmtUpdate->bindParam(':password', $password, PDO::PARAM_STR);
                $stmtUpdate->bindParam(':user_id', $user_id, PDO::PARAM_INT);
                
                $result = $stmtUpdate->execute();

                $condb = null; //close connect db
                if ($result) {
                    echo '<script>
                    setTimeout(function() {
                    swal({
                      title: "Reset Password Successful",
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
                }//else
              }//if
                
            }//isset
              ?>