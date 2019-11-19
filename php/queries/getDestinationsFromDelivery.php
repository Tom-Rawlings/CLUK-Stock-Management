<?php
	
	/*
		Returns an array containing delivery_id and status for all deliveries in the database.
	*/

	require $_SERVER['DOCUMENT_ROOT'] . "/Cluk/php/admin/connect.php";

	$delivery_id = $_POST["delivery_id"];

	$query = "SELECT DISTINCT a.* FROM cluk_address AS a, cluk_restaurant AS r, cluk_restaurant_has_orders AS rho, cluk_order AS o, cluk_delivery_has_orders AS dho, cluk_delivery AS d
		WHERE d.delivery_id = ? AND d.delivery_id = dho.delivery_id AND dho.order_id = o.order_id AND o.order_id = rho.order_id AND rho.restaurant_id = r.restaurant_id AND r.address_id = a.address_id;";

	$stmt = $conn->stmt_init();
	$stmt = $conn->prepare($query);
	$stmt->bind_param('i', $delivery_id);
	$stmt->execute();
	
	$stmt->bind_result($address_id, $line1, $line2, $city, $postcode, $lat, $long);

	$rows = array();
	while($stmt->fetch()){
		$row = array("line1"=>$line1, "line2" => $line2, "lat" => $lat, "long" => $long); 
		$rows[] = $row;
	}

	echo json_encode($rows);

?>