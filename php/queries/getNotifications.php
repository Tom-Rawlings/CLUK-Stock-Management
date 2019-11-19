<?php

	/*
        Gets all of the Notifications from the staff have notifications table in the database where the status is unread.
	*/

	require $_SERVER['DOCUMENT_ROOT'] . "/Cluk/php/admin/connect.php";

	$staff_id = $_SESSION["staff_id"];


	$query = "SELECT * FROM cluk_notifications WHERE staff_id = ? AND `status`= 'Unread';";
	$stmt = $conn->stmt_init();
	$stmt = $conn->prepare($query);

	$stmt->bind_param('i', $staff_id);
	$stmt->execute();
	
	$stmt->bind_result($notification_id, $staff_id, $displayText, $status);

	$rows = array();
	while($stmt->fetch()){
		$row = array("notification_id"=>$notification_id, "staff_id"=>$staff_id, "displayText"=>$displayText, "status"=>$status); 
		$rows[] = $row; 
	}
	
	echo json_encode($rows);

?>