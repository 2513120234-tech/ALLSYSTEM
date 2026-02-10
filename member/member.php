<?php
  session_start();
  require_once '../config/condb.php';
  require_once 'member_auth.php';
  include 'header.php';
  include 'navbar.php';
  include 'sidebar_menu.php';

  $act = (isset($_GET['act']) ? $_GET['act'] : '');

  if($act == 'edit'){
    include 'member_form_edit.php';
  }else if($act == 'editPwd'){
    include 'member_form_edit_password.php';
  }else{
    include 'main_content.php';  
  }

  include 'footer.php';
?>

  

 