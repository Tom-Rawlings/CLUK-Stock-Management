<?php

	/*
		Returns all orders with status of "ordered" and their destination
	*/

	require $_SERVER['DOCUMENT_ROOT'] . "/Cluk/php/admin/connect.php";

	$query = "SELECT o.*, a.*  FROM cluk_order AS o, cluk_address AS a, cluk_restaurant_has_orders AS rho, cluk_restaurant AS r 
						WHERE o.status = 'ordered' AND o.order_id = rho.order_id AND rho.restaurant_id = r.restaurant_id AND r.address_id = a.address_id;";

	$stmt = $conn->stmt_init();
	$stmt = $conn->prepare($query);
	//$stmt->bind_param('ii', $restaurant_id, $order_id);
	$stmt->execute();
	
	$stmt->bind_result($order_id, $dateAndTime, $status, $address_id, $line1, $line2, $city, $postcode, $lat, $long);

	$rows = array();
	while($stmt->fetch()){
		$row = array("order_id"=>$order_id, "dateAndTime"=> $dateAndTime, "status"=> $status, "address_id"=> $address_id, "line1"=> $line1, "line2"=> $line2, "city"=> $city, "postcode"=> $postcode); 
		$rows[] = $row;
	}
	
	echo json_encode($rows);

?>