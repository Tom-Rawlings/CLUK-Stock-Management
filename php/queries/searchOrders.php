<?php

	/*
		Takes a restaurant_id and returns an array of rows containing: order_id, 
		ingredient name, quantity, and category for all orders from that restaurant.
	*/

	require $_SERVER['DOCUMENT_ROOT'] . "/Cluk/php/admin/connect.php";

	$restaurant_id = $_SESSION["restaurant_id"];
	$searchString = $_POST["searchString"];

	$stringParts = explode(",",$searchString);
	if(sizeof($stringParts) == 1){
		$date1 = $stringParts[0] . " 00:00:00";
		$date2 = $stringParts[0] . " 23:59:59";
	}else{
		$date1 = $stringParts[0] . " 00:00:00";
		$date2 = $stringParts[1] . " 23:59:59";
	}

	$query = "SELECT DISTINCT o.order_id, o.dateAndTime, o.status
			FROM cluk_order o, restaurant_has_orders rho
			WHERE rho.restaurant_id = ? AND (o.status = ? OR o.dateAndTime BETWEEN ? AND ? OR o.order_id = ?)
			ORDER BY o.dateAndTime;";

	$stmt = $conn->stmt_init();
	$stmt = $conn->prepare($query);
	$stmt->bind_param('issss', $restaurant_id, $searchString, $date1, $date2, $searchString);
	$stmt->execute();
	
	$stmt->bind_result($order_id, $dateAndTime, $status);

	$rows = array();
	while($stmt->fetch()){
		$row = array("order_id"=>$order_id, "dateAndTime" => $dateAndTime, "status" => $status); 
		$rows[] = $row;
	}
	
	echo json_encode($rows);

?>