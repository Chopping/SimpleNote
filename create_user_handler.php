<?php
require "init.php";
$sensitive_words = [';','\'','\"','any','all'];
// 注册界面不需要校验用户是否事先登录了.
if (isset($_POST["user_name"]) && isset($_POST["password"])) {
    foreach ($sensitive_words as $value) {
        if(strpos($_POST["username"], $value) !== false){
            die("{\"success\":0,\"msg\":\"empty username or password is not allowed!\"}");
        }
    }
    // Create connection
    $conn = new mysqli($server_name, $username, $password);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
        die("{\"success\":0,\"msg\":\"$conn->connect_error\"}");
    }
    $new_user = $_POST["user_name"];
    $new_pwd = $_POST["password"];
    // 调用预设的存储过程 进行用户存储
    $stmt = $conn->prepare("call notesys.create_user(?,?)");

    $stmt->bind_param("ss", $new_user, $new_pwd);
    $result = $stmt->execute();
    $resultSet1 = $stmt->get_result();
    $number_of_rows_affected = mysqli_affected_rows($conn);
    if (isset($number_of_rows_affected) && ($number_of_rows_affected == 1)) {
        $_SESSION['user'] = $_POST["user_name"];
        die("{\"success\":1,\"msg\":\"Succeed in creating user : $new_user\"}");
    } else {
        die("{\"success\":0,\"msg\":\"Failed in creating : $new_user \"}");
    }
    $conn->close();
}

?>