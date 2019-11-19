<?php

	/*
		Takes a restaurant_id and returns an array of rows containing: order_id, 
		ingredient name, quantity, and category for all orders from that restaurant.
	*/

	require $_SERVER['DOCUMENT_ROOT'] . "/Cluk/php/admin/connect.php";

	$query = "SELECT * FROM cluk_warehouse";
	$stmt = $conn->stmt_init();
	$stmt = $conn->prepare($query);
	$stmt->execute();
	$stmt->bind_result($warehouse_id, $address_id, $phone_number);

	$rows = array();
	while($stmt->fetch()){
		$row = array("warehouse_id" => $warehouse_id, "address_id"=>$address_id, "phone_number" => $phone_number); 
		$rows[] = $row; 
	}
	
	echo json_encode($rows);

?>