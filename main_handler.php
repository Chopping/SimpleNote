<?php
    require "polices.php";
    if(isset($_SESSION['user'])){
        $user = $_SESSION['user'];
        $conn = new mysqli($server_name, $username, $password);
        if ($conn->connect_error) {
            die("{\"success\":0,\"msg\":\"$conn->error\"}");
        }

        // 如果是搜索note
        if(isset($_GET['k'])){
            $s_key = $_GET['k'];
            /*value="<?php echo isset($_SESSION['searchKey'])? $_SESSION['searchKey']:''; ?>" */
            $stmt = $conn->prepare("SELECT note_id, title, is_private as state, enable_search as is_enabled_search 
                FROM notesys.t_notes WHERE username=? and enable_search = 1 and content_plain_text like ? 
                order by last_modified_date desc"); 
            $param = "%{$s_key}%";
            $stmt->bind_param("ss", $_SESSION['user'],$param);
            $result = $stmt->execute();
            $resultSet = $stmt->get_result();

            if (!$resultSet) {
                die("{\"success\":0,\"msg\":\"$conn->error\"}");
            }
            if ($resultSet->num_rows > 0) 
            {
                $return_data = array();
                while($row = $resultSet->fetch_assoc()) {
                    array_push($return_data,["title"=>$row["title"],"state"=>$row["state"]==1?"private":"public",
                    "note_id"=>$row["note_id"],"link"=>"view.php?note_id=$row[note_id]",
                    "is_enabled_search"=>$row["is_enabled_search"]]);
                }
                die(json_encode(["data"=>$return_data,"success"=>1]));
            }
            else {
                die("{\"success\":2,\"msg\":\"not find any notes related to the key words!\"}");
            }
        }
        // 修改note 使其可以被搜索
        else if(isset($_GET['note_id'])){
            $stmt = $conn->prepare("SELECT username,enable_search FROM notesys.t_notes WHERE note_id = ?"); 
            $stmt->bind_param("i", $_GET["note_id"]);
            $result = $stmt->execute();
            $resultSet = $stmt->get_result();
            if ($resultSet->num_rows > 0) {
                $row = $resultSet ->fetch_assoc(); 
                if($_SESSION['user'] == $row["username"]){
                    if($row['enable_search'] == 1){
                        die("{\"success\":0,\"msg\":\"Note has been enabled to be searched.\"}");
                    }else{
                        $stmt2 = $conn->prepare("UPDATE notesys.t_notes set enable_search = 1 where note_id = ?"); 
                        $stmt2->bind_param("i", $_GET["note_id"]);
                        $stmt2->execute();

                        $number_of_rows_affected = mysqli_affected_rows($conn);
                        if(isset($number_of_rows_affected) && ($number_of_rows_affected == 1)){
                            die("{\"success\":1,\"msg\":\"Modification Succeed.\"}");
                        }else{
                            die("{\"success\":0,\"msg\":\"Failed to modify the search option in database.\"}");
                        }
                    }     
                }else{
                    die("{\"success\":0,\"msg\":\"You are note allowed to modify this note!\"}");
                }
            }else{
                die("{\"success\":0,\"msg\":\"You are note allowed to modify this note!\"}");
            }
           
        }
        // 如果只是简单的get
        else{
            $stmt = $conn->prepare("SELECT note_id, title, is_private as state, enable_search as is_enabled_search FROM notesys.t_notes WHERE username=? order by last_modified_date desc"); 
            $stmt->bind_param("s", $user);
            $result = $stmt->execute();
            $resultSet = $stmt->get_result();   

            if (!$resultSet) {
                die("{\"success\":0,\"msg\":\"$conn->error\"}");
            }
            if ($resultSet->num_rows > 0) 
            {
                $return_data = array();
                while($row = $resultSet->fetch_assoc()) {
                    array_push($return_data,["title"=>$row["title"],"state"=>$row["state"]==1?"private":"public","note_id"=>$row["note_id"],"link"=>"view.php?note_id=$row[note_id]","is_enabled_search"=>$row["is_enabled_search"]]);
                }
                die(json_encode(["data"=>$return_data,"success"=>1]));
            }
            else {
                die("{\"success\":2,\"msg\":\"You don't have any notes yet! why not <a href='/assign2/create_note.php'>create</a> your first note immediately? <br/>\"}");
            }
        }

        // 结束的时候关闭连接
        $conn->close();

    }else{
        trigger_error('Invalid access');
    }	
?>