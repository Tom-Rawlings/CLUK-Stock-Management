<?php
	
	/*
		Returns an array containing delivery_id and status for all deliveries in the database.
	*/

	require $_SERVER['DOCUMENT_ROOT'] . "/Cluk/php/admin/connect.php";

	$query = "SELECT * FROM cluk_delivery WHERE `status` = 'Delivered';";

	$stmt = $conn->stmt_init();
	$stmt = $conn->prepare($query);
	$stmt->execute();
	
	$stmt->bind_result($delivery_id, $status, $date);

	$rows = array();
	while($stmt->fetch()){
		$row = array("delivery_id"=>$delivery_id, "status"=>$status, "date"=>$date); 
		$rows[] = $row;
	}

	echo json_encode($rows);

?>