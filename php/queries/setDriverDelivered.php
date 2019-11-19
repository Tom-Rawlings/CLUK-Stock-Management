<?php

	/*
		Takes an delivery_id and sets it's status as Delivered in delivery_has_drivers
	*/

	require_once($_SERVER['DOCUMENT_ROOT'] . "/Cluk/php/admin/connect.php");

	$delivery_id = $_POST["delivery_id"];

	$query = "SELECT staff_id FROM cluk_delivery_has_drivers WHERE delivery_id = ?;";

	$stmt = $conn->stmt_init();
	$stmt = $conn->prepare($query);
	$stmt->bind_param('i', $delivery_id);
	$stmt->execute();

	$stmt->bind_result($staff_id);
	$stmt->fetch();

	$query = "UPDATE cluk_driver SET `status` = 'Unassigned' WHERE staff_id = ?;";

	$stmt = $conn->stmt_init();
	$stmt = $conn->prepare($query);
	$stmt->bind_param('i', $staff_id);
	$stmt->execute();

	$query = "UPDATE cluk_delivery_has_drivers SET `status` = 'Delivered' WHERE delivery_id = ?;";

	$stmt = $conn->stmt_init();
	$stmt = $conn->prepare($query);
	$stmt->bind_param('i', $delivery_id);
	$stmt->execute();


?>