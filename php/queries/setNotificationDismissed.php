<?php

	/*
		Takes a notification_id and sets it's status as Delivered
	*/

	require $_SERVER['DOCUMENT_ROOT'] . "/Cluk/php/admin/connect.php";

	$notification_id = $_POST["notification_id"];

	$query = "UPDATE cluk_notifications SET `status`= 'Read' WHERE notification_id = ?;";

	$stmt = $conn->stmt_init();
	$stmt = $conn->prepare($query);
	$stmt->bind_param('i', $notification_id);
	$stmt->execute();

?>