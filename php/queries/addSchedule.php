<?php
	/*
		Adds the schedules for the current delivery
	*/

	require $_SERVER['DOCUMENT_ROOT'] . "/Cluk/php/admin/connect.php";

	$startAddressId = $_POST["startAddressId"];
	$endAddressId = $_POST["endAddressId"];
	$time = $_POST["timeInMins"];
	$delivery_id = $_POST["delivery_id"];

	$query = "INSERT INTO cluk_schedule (start_address_id, end_address_id, estimated_time) VALUES (?,?,?);";
	$stmt = $conn->stmt_init();
	$stmt = $conn->prepare($query);
	$stmt->bind_param('iii', $startAddressId, $endAddressId, $time);
	$stmt->execute();


	$query = "SELECT max(schedule_id) FROM cluk_schedule;";
	$stmt = $conn->stmt_init();
	$stmt = $conn->prepare($query);
	$stmt->execute();
	$stmt->bind_result($schedule_id);
	$stmt->fetch();
	$latest_schedule_id = $schedule_id;

	$query = "INSERT INTO cluk_delivery_has_schedules (delivery_id, schedule_id) VALUES (?,?);";
	$stmt = $conn->stmt_init();
	$stmt = $conn->prepare($query);
	$stmt->bind_param('ii', $delivery_id, $latest_schedule_id);
	$stmt->execute();
	
	echo ("".$latest_schedule_id);

?>