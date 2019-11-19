<?php

	require $_SERVER['DOCUMENT_ROOT'] . "/Cluk/php/admin/connect.php";
		
	$message=$_POST["message"];
    $staff_id=$_SESSION["staff_id"];

	$query = "SELECT * FROM csc8005_team05.notifications WHERE staff_id= ? AND `status`= 'Unread' AND displayText= ? ;";
	$stmt = $conn->stmt_init();
	$stmt = $conn->prepare($query);
	$stmt->bind_param('is', $staff_id, $message);
	$stmt->execute();

	$stmt->store_result();

    if($stmt->num_rows > 0){
        echo true;
    }else{
        echo false;
    }

	$stmt->close();

?>
