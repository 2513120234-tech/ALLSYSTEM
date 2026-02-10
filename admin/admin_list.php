<?php
//query user data
$queryUsers = $condb->prepare("SELECT* FROM USERS");
$queryUsers->execute();
$rsUsers = $queryUsers->fetchAll();

// echo '<pre>';
// $queryUsers->debugDumpParams();
// exit;


?>
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Admin Control Panel
              <a href="admin.php?act=add" class="btn btn-primary">+ Add User</a>
            </h1>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            

            <div class="card">
              
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped table-sm">
                  <thead>
                  <tr class="table-info">
                    <th width="5%" class="text-center">No.</th>
                    <th width="50%" class="text-center">Username</th>
                    <th width="10%" class="text-center">Role</th>
                    <th width="15%" class="text-center">Reset Password</th>
                    <th width="10%" class="text-center">Edit</th>
                    <th width="10%" class="text-center">Delete</th>
                  </tr>
                  </thead>
                  <tbody>
                    <?php 
                    $i = 1;
                    foreach($rsUsers as $rowUsers) { ?>
                  <tr>
                    <td align="center"><?php echo $i++ ?></td>
                    <td><?= $rowUsers['username'] ?></td>
                    <td align="center"><?= $rowUsers['role'] ?></td>
                    <td align="center"><a href="admin.php?act=editPwd&user_id=<?= $rowUsers['user_id'] ?>" class="btn btn-secondary btn-sm">Reset Password</a></td>
                    <td align="center"><a href="admin.php?act=edit&user_id=<?= $rowUsers['user_id'] ?>" class="btn btn-warning btn-sm">Edit</a></td>
                    <td align="center"><a href="admin.php?act=delete&user_id=<?= $rowUsers['user_id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Confirm to Delete??')">Delete</a></td>
                  </tr>
                  <?php } ?>
            
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->