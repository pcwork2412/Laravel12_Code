<?php

require_once "../../dbCon.php";
$id=$_GET['id'];

$sql = "SELECT * FROM `tblemployee` where `Id`='$id'";

$result = mysqli_query($db, $sql) or die(mysqli_error($db));
$output = [];

if(mysqli_num_rows($result) > 0){
  while($row = mysqli_fetch_assoc($result)){
    $output[] = $row;
  }
}else{
    $output['empty'] = ['empty'];
}

mysqli_close($db);

echo json_encode($output);

?>