<?php

	/*
		Takes a restaurant_id and returns an array of rows containing: order_id, 
		ingredient name, quantity, and category for all orders from that restaurant.
	*/

	require $_SERVER['DOCUMENT_ROOT'] . "/Cluk/php/admin/connect.php";

	$restaurant_id = $_POST["restaurant_id"];

	$query = "SELECT o.order_id, i.name, ohi.quantity, i.category 
			FROM ingredients i, `order` o, restaurant_has_orders rho, order_has_ingredients ohi 
			WHERE rho.restaurant_id = ? AND rho.order_id = o.order_id 
			AND o.order_id = ohi.order_id AND ohi.ingredient_id = i.ingredient_id
			ORDER BY o.order_id, i.category;";

	$stmt = $conn->stmt_init();
	$stmt = $conn->prepare($query);
	$stmt->bind_param('i', $restaurant_id);
	$stmt->execute();
	
	$stmt->bind_result($order_id, $name, $quantity, $category);

	$rows = array();
	while($stmt->fetch()){
		$row = array("order_id"=>$order_id, "name"=>$name, "quantity"=>$quantity, "category"=>$category); 
		$rows[] = $row;
	}
	
	echo json_encode($rows);

?>