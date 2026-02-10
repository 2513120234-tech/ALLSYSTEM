<?php
  require_once 'header.php';
  require_once 'navbar.php';
  require_once 'sidebar_menu.php';

  $act = (isset($_GET['act']) ? $_GET['act'] : '');

  if($act == 'add'){
    require_once 'admin_form_add.php';
  }else if($act == 'delete'){
    require_once 'admin_delete.php';
  }else if($act == 'edit'){
    require_once 'admin_form_edit.php';
  }else if($act == 'editPwd'){
    require_once 'admin_form_edit_password.php';
  }else {
    require_once 'admin_list.php';
  }

  require_once 'footer.php';
?>

  

 