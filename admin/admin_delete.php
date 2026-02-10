<?php
if(isset($_GET['user_id']) && isset($_GET['act']) && $_GET['act']=='delete'){
$id = $_GET['user_id'];

$stmtDelUsers = $condb->prepare('DELETE FROM USERS WHERE user_id=:user_id');
$stmtDelUsers->bindParam(':user_id', $id , PDO::PARAM_INT); //เช็ค Data Type ที่จะเอาไป query
$stmtDelUsers->execute();

$condb = null; //close connect db
if($stmtDelUsers->rowCount() ==1){
        echo '<script>
             setTimeout(function() {
              swal({
                  title: "Delete Data Successfully",
                  type: "success"
              }, function() {
                  window.location = "admin.php"; //หน้าที่ต้องการให้กระโดดไป
              });
            }, 1000);
        </script>';
        exit;
    }else{
       echo '<script>
             setTimeout(function() {
              swal({
                  title: "Error occurred while deleting data",
                  type: "error"
              }, function() {
                  window.location = "admin.php"; //หน้าที่ต้องการให้กระโดดไป
              });
            }, 1000);
        </script>';
    }
}// isset
?>