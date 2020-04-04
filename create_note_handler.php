<?php
    require "polices.php";
	if(isset($_POST['title'])&&isset($_POST['content'])){
		// Create connection
		$conn = new mysqli($server_name, $username, $password);
		if ($conn->connect_error) {
			die("{\"success\":0,\"msg\":'Connection to database failed'}");
		}
		// $content_handled = 
		if(isset($_POST['p_opt'])&& $_POST['p_opt'] == 1){
			if(! isset($_POST['note_key'])){
				die("{\"success\":0,\"msg\":'Failed to receive your key to encode this paper'}");
			}
			// $stmt = $conn->prepare("INSERT INTO notesys.t_notes(title,content,is_private,username) values(?, aes_encrypt(?,?),?,?);");		
			$stmt = $conn->prepare("call notesys.create_private_note(?,?,?,?);");		
			$stmt->bind_param("ssss", $_POST['title'] , $_POST['content'], $_POST['note_key'], $_SESSION['user']);
			$result = $stmt->execute();
			
			$stmt2 = $conn->prepare("select note_id from notesys.t_notes where title = ?;");		
			$stmt2->bind_param("s", $_POST['title']);

			$result2 = $stmt2->execute();
			$r_set = $stmt2->get_result();
			if ($r_set->num_rows > 0) {
				$row = $r_set ->fetch_assoc(); 
				$oid = $row["note_id"];
				die("{\"success\":1,\"insert_id\":$oid}");
			}
			else {
				die("{\"success\":0,\"msg\":\" $_POST[title] $_POST[content] $_POST[note_key] $_SESSION[user]\"}");
				// die("{\"success\":0,\"msg\":\"Create note failed!\"}");
			}			
		}else{
			$stmt = $conn->prepare("INSERT INTO notesys.t_notes(title,content_plain_text,is_private,username) values(?,?,0,?);");		
			$stmt->bind_param("sss", $_POST['title'] , $_POST['content'], $_SESSION['user']);

			$result = $stmt->execute();
			$number_of_rows_affected = mysqli_affected_rows($conn);
			
			if(isset($number_of_rows_affected) && ($number_of_rows_affected == 1)){
				$oid = mysqli_insert_id($conn); 
                die("{\"success\":1,\"insert_id\":$oid}");
			}else{
				die("{\"success\":0,\"msg\":'Create note failed!'}");
			}
		}
		$conn->close();	
	}
?>