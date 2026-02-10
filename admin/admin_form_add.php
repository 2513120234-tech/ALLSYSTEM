<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Add User Form</h1>
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
                      <input type="email" name="username" class="form-control" required placeholder="Email as username">
                    </div>
                  </div>
                

                <div class="form-group row">
                    <label class="col-sm-2">Password</label>
                    <div class="col-sm-4">
                      <input type="password" name="password" class="form-control" required placeholder="Enter password">
                    </div>
                  </div>
                
                  <!-- สิทธิ์การใช้งานระบบ -->
                <div class="form-group row">
                    <label class="col-sm-2">Role</label>
                    <div class="col-sm-4">
                      <select name="role" class="form-control" required>
                        <option value="">-- Select Role --</option>
                        <option value="admin">admin</option>
                        <option value="member">member</option>
                      </select>
                    </div>
                  </div>

                <div class="form-group row">
                    <label class="col-sm-2"></label>
                    <div class="col-sm-4">
                    <!-- <button type="submit" class="btn btn-primary btn-lg btn-block"> Add </button>  -->
                      <button type="submit" class="btn btn-primary"> Save </button>
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
              

                if(isset($_POST['username']) && isset($_POST['password']) && isset($_POST['role']) ) {
                    //echo 'ถูกเงื่อนไข ส่งข้อมูลมาได้';
                    //ประกาศตัวแปรรับค่าจากฟอร์ม
                    $username = $_POST['username'];
                    $password = password_hash($_POST['password'],PASSWORD_ARGON2ID);
                    $role = $_POST['role'];//สิทธิ์การใช้งานระบบ

                    //Check double username
                    //single row query
                    $stmtUserDetail = $condb->prepare("SELECT username FROM USERS WHERE username=:username");
                    //bindParam
                    $stmtUserDetail->bindParam(':username', $username, PDO::PARAM_STR);
                    $stmtUserDetail->execute();
                    $row = $stmtUserDetail->fetch(PDO::FETCH_ASSOC);
                    
                    if ($stmtUserDetail->rowCount() == 1) {
                      echo '<script>
                        setTimeout(function() {
                          swal({
                              title: "Username Duplicate!",
                              text: "Please use another username.",
                              type: "error"
                          }, function() {
                            window.location = "admin.php?act=add"; //หน้าที่ต้องการให้กระโดดไป
                          });
                        }, 1000);
                      </script>';
                    } else {
                      //sql insert
                    $stmtInsertUsers = $condb->prepare("INSERT INTO USERS (username, password, role) 
                    VALUES (:username, :password, :role)");
                    
                    //bindParam
                    $stmtInsertUsers->bindParam(':username', $username, PDO::PARAM_STR);
                    $stmtInsertUsers->bindParam(':password', $password, PDO::PARAM_STR);
                    $stmtInsertUsers->bindParam(':role', $role, PDO::PARAM_STR);
                    $result = $stmtInsertUsers->execute();
                    
                    $condb = null; //close connect db
                    if($result){
                      echo '<script>
                            setTimeout(function() {
                              swal({
                                title: "Insert Data Successfully",
                                type: "success"
                              }, function() {
                                  window.location = "admin.php"; //หน้าที่ต้องการให้กระโดดไป
                              });
                            }, 1000);
                          </script>';
                    } else{
                      echo '<script>
                        setTimeout(function() {
                          swal({
                              title: "Error Insert Data",
                              type: "error"
                          }, function() {
                            window.location = "admin.php"; //หน้าที่ต้องการให้กระโดดไป
                          });
                        }, 1000);
                      </script>';
                      }//else
                    }//if
          
                    
                } //isset
              
              ?>
