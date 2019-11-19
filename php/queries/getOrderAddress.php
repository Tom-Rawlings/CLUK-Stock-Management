<?php

	/*
		Takes an order_id and returns the address that order is going to
	*/

	require $_SERVER['DOCUMENT_ROOT'] . "/Cluk/php/admin/connect.php";

	$order_id = $_POST["order_id"];

	$query = "SELECT a.* FROM cluk_cluk_address AS a, cluk_restaurant AS r, cluk_restaurant_has_orders AS rho
					WHERE rho.order_id = ? AND rho.restaurant_id = r.restaurant_id 
					AND r.address_id = a.address_id;";

	$stmt = $conn->stmt_init();
	$stmt = $conn->prepare($query);
	$stmt->bind_param('i', $order_id);
	$stmt->execute();
	
	$stmt->bind_result($address_id, $line1, $line2, $city, $postcode, $lat, $long);

	$rows = array();
	while($stmt->fetch()){
		$row = array("address_id"=>$address_id, "line1" => $line1, "line2" => $line2, "city" => $city, "postcode" => $postcode, "lat" => $lat, "long" => $long);
		$rows[] = $row; 
	}
	
	echo json_encode($rows);

?>