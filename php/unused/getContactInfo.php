<?php

	/*
		Takes a restaurant_id and returns an array of rows containing: order_id, 
		ingredient name, quantity, and category for all orders from that restaurant.
	*/

	require $_SERVER['DOCUMENT_ROOT'] . "/Cluk/php/admin/connect.php";

	$query = "SELECT * FROM warehouse";
	$stmt = $conn->stmt_init();
	$stmt = $conn->prepare($query);
	$stmt->execute();
	$stmt->bind_result($warehouse_id, $address_id, $phone_number);
	$stmt->fetch();

	$query = "SELECT * FROM cluk_address WHERE address_id = ?;";
	$stmt = $conn->stmt_init();
	$stmt = $conn->prepare($query);
	//$value = 6;
	$stmt->bind_param('i', $address_id);
	$stmt->execute();
	
	$stmt->bind_result($address_id, $line1, $line2, $city, $postcode);

	$rows = array();
	while($stmt->fetch()){
		$row = array("address_id"=>$address_id, "line1" => $line1, "line2" => $line2, "city" => $city, "postcode" => $postcode); 
		$rows[] = $row; 
	}
	
	echo json_encode($rows);

?>