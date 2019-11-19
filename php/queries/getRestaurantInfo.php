<?php

	/*
		Takes a restaurant_id and returns an array of rows containing: order_id, 
		ingredient name, quantity, and category for all orders from that restaurant.
	*/

	require $_SERVER['DOCUMENT_ROOT'] . "/Cluk/php/admin/connect.php";

	$query = "SELECT * FROM cluk_restaurant";
	$stmt = $conn->stmt_init();
	$stmt = $conn->prepare($query);
	$stmt->execute();
	$stmt->bind_result($restaurant_id, $name, $capacity, $address_id, $manager_staff_id, $phone_number);


	$rows = array();
	while($stmt->fetch()){
		$row = array("restaurant_id"=>$restaurant_id, "name" => $name, "capacity" => $capacity, "address_id" => $address_id, "manager_staff_id" => $manager_staff_id, "phone_number" => $phone_number); 
		$rows[] = $row; 
	}
	
	echo json_encode($rows);

?>