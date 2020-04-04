<?php
require "polices.php";
if (isset($_POST["user_name"]) && isset($_POST["password"])) {
  if(is_null($_POST["user_name"]) || is_null($_POST["password"]) || empty($_POST["password"]) || empty($_POST["user_name"])){
    die("{\"success\":0,\"msg\":\"empty username or password are not allowed!\"}");
  }

  // Create connection
  $conn = new mysqli($server_name, $username, $password);
  // Check connection
  if ($conn->connect_error) {
    die("{\"success\":0,\"msg\":\"$conn->connect_error\"}");
  }
  $stmt_pre = $conn->prepare("SELECT username, salt FROM notesys.t_user WHERE username=?"); 
	$stmt_pre->bind_param("s", $_POST["user_name"]);
	$result_pre = $stmt_pre->execute();
	$resultSet_pre = $stmt_pre->get_result();   

  if (!$resultSet_pre) {
    die("{\"success\":0,\"msg\":\"$conn->error\"}");
  }

  $salt = '';

  if ($resultSet_pre->num_rows > 0) {
    $row_pre = $resultSet_pre->fetch_assoc(); 
    $salt = $row_pre["salt"];
  }else{
    die("{\"success\":0,\"msg\":\"Your account is under invalid state.\"}");
  }

  $stmt = $conn->prepare("SELECT username FROM notesys.t_user WHERE pwd=SHA2(CONCAT(?, ?),'256')"); 
	$stmt->bind_param("ss", $_POST["password"], $salt);
	$result = $stmt->execute();
	$resultSet = $stmt->get_result();   

  if (!$resultSet) {
    die("{\"success\":0,\"msg\":\"$conn->error\"}");
  }

  if ($resultSet->num_rows > 0) {
    $row = $resultSet ->fetch_assoc(); 
    $_SESSION['user'] = $row["username"];
    die("{\"success\":1,\"msg\":\"Welcome back! $row[username]\"}");
  }
  else {
    die("{\"success\":0,\"msg\":\"Invalid username/password!\"}");
  }  

	$conn->close();
}else{
  die("{\"success\":0,\"msg\":\"empty username or password are not allowed!\"}");
}
?>