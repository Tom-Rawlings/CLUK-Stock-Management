<?php
	
	/*
		Takes a takes a message to update the staff notifications tables.
	*/

	require $_SERVER['DOCUMENT_ROOT'] . "/Cluk/php/admin/connect.php";

    $message = $_POST["message"];
	$staff_id = $_SESSION["staff_id"];

	$query = "INSERT INTO `notifications`(`staff_id`,`displayText`, `status`) VALUES (?,?,'Unread');";

	$stmt = $conn->stmt_init();
	$stmt = $conn->prepare($query);
	$stmt->bind_param('is', $staff_id, $message);
	$stmt->execute();
	
?>