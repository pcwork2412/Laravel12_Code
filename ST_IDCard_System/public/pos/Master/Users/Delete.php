<?php

require_once '../../dbCon.php';
$id=$_GET['id'];

$sql = "Delete From `tblemployee` where `Id`='$id'";

if(mysqli_query($db, $sql)) {
        
    echo json_encode(array('insert'=>'success'));
    

   } else {
    echo("Error description: " . mysqli_error($db));
      echo json_encode(array('insert'=>'failled'));
   }

mysqli_close($db);

//echo json_encode($output);

?>