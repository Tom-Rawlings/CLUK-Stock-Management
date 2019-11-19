<?php
	
	/*
		Returns an array containing delivery_id and status for all deliveries in the database.
	*/

	require $_SERVER['DOCUMENT_ROOT'] . "/Cluk/php/admin/connect.php";

	$staff_id = $_SESSION["staff_id"];

	$query = "SELECT d.* FROM cluk_delivery AS d, cluk_delivery_has_drivers AS dhd
			WHERE dhd.staff_id = ? AND d.status = 'Delivered';";

	$stmt = $conn->stmt_init();
	$stmt = $conn->prepare($query);
	$stmt->bind_param('i', $staff_id);
	$stmt->execute();
	
	$stmt->bind_result($delivery_id, $status, $date);

	$rows = array();
	while($stmt->fetch()){
		$row = array("delivery_id"=>$delivery_id, "status"=>$status, "date"=>$date); 
		$rows[] = $row;
	}

	echo json_encode($rows);

?>