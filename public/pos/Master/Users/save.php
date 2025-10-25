<?php
require_once "../../dbCon.php";
$input = file_get_contents('php://input');
$decode = json_decode($input, true);
    
  
  $UserId=$decode["UserId"];
  $Name=$decode["Name"];
  $Email =$decode["Email"];
  $Mobile=$decode["Mobile"];
  $Password=$decode["Password"];
  
 $TranType = $decode["TranType"];
 $Id = $decode["Id"];

 if($TranType==0)
 {
   
  $query= "INSERT INTO `tblemployee`( `UserId`, `Name`, `Email`, `Mobile`, `Password`) VALUES ('$UserId','$Name','$Email','$Mobile','$Password')";
    if(mysqli_query($db, $query)) {
        
     echo json_encode(array('insert'=>'success'));

    } 
    else {
       echo json_encode(array('insert'=>'failed'));
    }
 }

elseif($TranType==1)
{
   $query1="UPDATE `tblemployee` SET `UserId`='$UserId',
                                  `Name`='$Name',
                                  `Email`='$Email',
                                  `Mobile`='$Mobile',
                                  `Password`='$Password'


  
where `id`='$Id'";
if(mysqli_query($db,$query1 ))
{

echo json_encode(array('insert'=>'success'));


} else {
echo("Error description: " . mysqli_error($db));

echo json_encode(array('insert'=>'failled'));
}
}

mysqli_close($db);
?>