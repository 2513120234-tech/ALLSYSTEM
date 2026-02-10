<?php

//start session
session_start();

//Connect database
require_once 'config/condb.php';



//Check input from form
if (isset($_POST['username'], $_POST['password']) && $_POST['action'] === 'login') {

    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmtLogin = $condb->prepare("
        SELECT user_id, password, role 
        FROM users 
        WHERE username = :username
    ");
    $stmtLogin->bindParam(':username', $username, PDO::PARAM_STR);
    $stmtLogin->execute();

    if ($stmtLogin->rowCount() === 1) {

        $row = $stmtLogin->fetch(PDO::FETCH_ASSOC);

        if (password_verify($password, $row['password'])) {
            require_once 'activity_log.php';
            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['role']    = $row['role'];

            logActivity($condb, $row['user_id'], $row['role'], 'login');

            if ($_SESSION['role'] === 'admin') {
                header('Location: admin/');
                exit;
            } else if($_SESSION['role'] === 'member') {
                header('Location: member/');
                exit;
            }
            
                
        }else{ 
            require_once 'activity_log.php';

            logActivity($condb, $row['user_id'], $row['role'], 'login_failed');

            echo '<script>
                setTimeout(function() {
                swal({
                    title: "Error!",
                    text: "Username or Password is incorrect.",
                    type: "warning"
                }, function() {
                    window.location = "login.php";
                });
            }, 1000);
            </script>';

        } //else password_verify
    } //if rowCount
} //if isset

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Log in</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="assets/dist/css/style.css">
    <!-- SweetAlert2 -->
    <script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">
</head>

<body class="img js-fullheight" style="background-image: url(assets/dist/img/bg.jpg);">
    <?php
        if (isset($_GET['error']) && $_GET['error'] === 'unauthorized') {
            echo '<script>
                setTimeout(function() {
                swal({
                    title: "You are not authorized!",
                    text: "Please login to continue.",
                    type: "error"
                }, function() {
                    window.location = "login.php";
                });
            }, 1000);
            </script>';
        }
    ?>
    <section class="ftco-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6 col-lg-4">
                    <div class="login-wrap p-0">
                        <h3 class="mb-4 text-center">Log in to start your session</h3>

                        <form action="" method="post" class="signin-form">
                            <div class="form-group">
                                <input type="email"
                                    name="username"
                                    class="form-control"
                                    placeholder="Email"
                                    required>
                            </div>

                            <div class="form-group">
                                <input type="password"
                                    name="password"
                                    class="form-control"
                                    placeholder="Password"
                                    required>
                            </div>
                            <div class="form-group">
                                <button type="submit"
                                    name="action"
                                    value="login"
                                    class="form-control btn btn-primary submit px-3">Log In</button>
                            </div>
                        <!-- /.col -->
                        </form>

                        <div class="social-auth-links text-center mb-3">
                            <hr>
                            <p>Login Logout Authentication</p>
                        </div>
                    <!-- /.login-card-body -->
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /.login-box -->
    <script src="assets/dist/js/jquery.min.js"></script>
<script src="assets/dist/js/popper.js"></script>
<script src="assets/dist/js/bootstrap.min.js"></script>
<script src="assets/dist/js/main.js"></script>
</body>

</html>