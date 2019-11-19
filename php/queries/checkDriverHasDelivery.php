<?php
	
	/*
		Returns an array containing delivery_id and status for all deliveries in the database.
	*/

	require $_SERVER['DOCUMENT_ROOT'] . "/Cluk/php/admin/connect.php";

	$staff_id = $_SESSION["staff_id"];

	$query = "SELECT delivery_id FROM cluk_delivery_has_drivers
						WHERE staff_id = ?;";

	$stmt = $conn->stmt_init();
	$stmt = $conn->prepare($query);
	$stmt->bind_param('i', $staff_id);
	$stmt->execute();
	
	$stmt->bind_result($delivery_id);

	$stmt->fetch();

	echo (!$delivery_id == NULL);

?>