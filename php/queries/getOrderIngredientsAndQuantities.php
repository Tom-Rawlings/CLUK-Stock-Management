<?php

	/*
		Takes a restaurant_id and order_id and returns an array of rows containing:	ingredient id and quantity
	*/

	require $_SERVER['DOCUMENT_ROOT'] . "/Cluk/php/admin/connect.php";

	$restaurant_id = $_SESSION["restaurant_id"];
	$order_id = $_POST["order_id"];

	$query = "SELECT i.ingredient_id, ohi.quantity, i.category 
			FROM cluk_ingredients i, cluk_order o, cluk_restaurant_has_orders rho, cluk_order_has_ingredients ohi 
			WHERE rho.restaurant_id = ? AND rho.order_id = ? AND rho.order_id = o.order_id 
			AND o.order_id = ohi.order_id AND ohi.ingredient_id = i.ingredient_id
			ORDER BY o.order_id, i.category;";

	$stmt = $conn->stmt_init();
	$stmt = $conn->prepare($query);
	$stmt->bind_param('ii', $restaurant_id, $order_id);
	$stmt->execute();
	
	$stmt->bind_result($ingredient_id, $quantity, $category);

	$rows = array();
	while($stmt->fetch()){
		$row = array("ingredient_id"=>$ingredient_id, "quantity"=>$quantity, "category"=>$category); 
		$rows[] = $row;
	}
	
	echo json_encode($rows);

?>