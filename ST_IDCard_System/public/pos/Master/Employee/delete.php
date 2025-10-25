<?php 
include '../../db_conn.php';
$id = $_POST["id"];
  $delete_image = $_POST["delete_image"];

  $sql = "DELETE FROM users WHERE `id`=$id";

  if (mysqli_query($conn, $sql)) {
    // remove the image
    unlink("uploads/" . $delete_image);
    echo json_encode([
      "statusCode" => 200,
      "message" => "Data deleted successfully 😀"
    ]);
  } else {
    echo json_encode([
      "statusCode" => 500,
      "message" => "Failed to delete data 😓"
    ]);
  }
?>