<?php

	/*
		Takes a restaurant_id and returns an array of rows containing: order_id, 
		ingredient name, quantity, and category for all orders from that restaurant.
	*/

	require $_SERVER['DOCUMENT_ROOT'] . "/Cluk/php/admin/connect.php";

	$restaurant_id = $_SESSION["restaurant_id"];

	$query = "SELECT DISTINCT o.order_id, o.dateAndTime, o.status
			FROM cluk_order o, cluk_restaurant_has_orders rho
			WHERE rho.restaurant_id = ? AND o.order_id = rho.order_id
			ORDER BY o.dateAndTime;";

	$stmt = $conn->stmt_init();
	$stmt = $conn->prepare($query);
	$stmt->bind_param('i', $restaurant_id);
	$stmt->execute();
	
	$stmt->bind_result($order_id, $dateAndTime, $status);

	$rows = array();
	while($stmt->fetch()){
		$row = array("order_id"=>$order_id, "dateAndTime" => $dateAndTime, "status" => $status); 
		$rows[] = $row;
	}
	
	echo json_encode($rows);

?>