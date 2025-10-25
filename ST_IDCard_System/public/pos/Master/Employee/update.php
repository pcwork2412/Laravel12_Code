<?php 
include '../../db_conn.php';
// update data
if (!empty($_POST["first_name"]) && !empty($_POST["last_name"]) && !empty($_POST["email"]) && !empty($_POST["country"]) && !empty($_POST["gender"])) {
    $id = mysqli_real_escape_string($conn, $_POST["id"]);
    $first_name = mysqli_real_escape_string($conn, $_POST["first_name"]);
    $last_name = mysqli_real_escape_string($conn, $_POST["last_name"]);
    $email = mysqli_real_escape_string($conn, $_POST["email"]);
    $country = mysqli_real_escape_string($conn, $_POST["country"]);
    $gender = mysqli_real_escape_string($conn, $_POST["gender"]);

    if ($_FILES["image"]["size"] != 0) {
      // rename the image before saving to database
      $original_name = $_FILES["image"]["name"];
      $new_name = uniqid() . time() . "." . pathinfo($original_name, PATHINFO_EXTENSION);
      move_uploaded_file($_FILES["image"]["tmp_name"], "uploads/" . $new_name);
      // remove the old image from uploads directory
      unlink("uploads/" . $_POST["image_old"]);
    } else {
      $new_name = mysqli_real_escape_string($conn, $_POST["image_old"]);
    }
    $sql = "UPDATE `users` SET `first_name`='$first_name',`last_name`='$last_name',`email`='$email',`image`='$new_name',`country`='$country',`gender`='$gender' WHERE `id`=$id";
    if (mysqli_query($conn, $sql)) {
      echo json_encode([
        "statusCode" => 200,
        "message" => "Data updated successfully 😀"
      ]);
    } else {
      echo json_encode([
        "statusCode" => 500,
        "message" => "Failed to update data 😓"
      ]);
    }
    mysqli_close($conn);
  } else {
    echo json_encode([
      "statusCode" => 400,
      "message" => "Please fill all the required fields 🙏"
    ]);
  }
?>