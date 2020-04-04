<?php
    require "polices.php";

    if(! isset($_POST['note_id']) || is_null($_POST['note_id'])){
        die("{\"success\":0,\"msg\":\"Parameter of request lost !\"}");
    }

    $conn = new mysqli($server_name, $username, $password);
    $stmt = $conn->prepare("SELECT title,content_plain_text as content,is_private,username FROM notesys.t_notes WHERE note_id = ?"); 
    $stmt->bind_param("i", $_POST["note_id"]);
    $result = $stmt->execute();
    $resultSet = $stmt->get_result();

    if ($resultSet->num_rows > 0) {
        $row = $resultSet ->fetch_assoc(); 
        if($_SESSION['user'] == $row["username"]){
            if(isset($_POST['key'])){
                // 获取到用户填写的key 进行解密显示
                $stmt2 = $conn->prepare("SELECT BINARY AES_DECRYPT(content,?, initial_vector) <=> BINARY content_plain_text as is_matched FROM notesys.t_notes WHERE note_id = ?");
                $stmt2->bind_param("si", $_POST['key'],$_POST["note_id"]);
                $result2 = $stmt2->execute();
                $resultSet2 = $stmt2->get_result();
                if ($resultSet2->num_rows > 0)
                {
                    $row2 = $resultSet2 ->fetch_assoc();
                    if(isset($row2['is_matched'])&&$row2['is_matched'] == 1){
                        $a = array();
                        $a["success"] = 1;               
                        $a["content"] = $row['content'];
                        die(json_encode($a));
                    }else{
                        die("{\"success\":0,\"msg\":\"Key might be wrong, to check you input whether it is correct or not\"}");
                    }
                }else{
                    die("{\"success\":0,\"msg\":\"cannot find the data of this note.\"}");
                }
            }else{
                $a = array();
                $a["success"] = 1;
                $a["title"] = $row['title'];
                $a["is_private"] = $row['is_private'];
                
                if(1 == $row["is_private"]){
                    $a["content"] = base64_encode($row['content']);
                }else{                  
                    $a["content"] = $row['content'];
                }
                die(json_encode($a));
            }      
        }else{
            die("{\"success\":0,\"msg\":\"You are note allowed to view this note!\"}");
        }
    }else{
        die("{\"success\":0,\"msg\":\"You are note allowed to view this note!\"}");
    }
?>