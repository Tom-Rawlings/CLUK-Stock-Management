<?php

	/*
		Takes a restaurant_id and order_id and returns an array of rows containing:	ingredient name, quantity, and category for that order from that restaurant.
	*/

	//require $_SERVER['DOCUMENT_ROOT'] . "/Cluk/php/admin/connect.php";
	require $_SERVER['DOCUMENT_ROOT'] . "/Cluk/php/admin/connect.php";

	$category = $_POST["category"];

	$query = "SELECT * FROM cluk_ingredients WHERE cluk_ingredients.category = ?;";

	$stmt = $conn->stmt_init();
	$stmt = $conn->prepare($query);
	$stmt->bind_param('s', $category);
	$stmt->execute();
	
	$stmt->bind_result($ingredient_id, $name, $price, $unit_size, $unit, $category, $alert_quantity);

	$rows = array();
	while($stmt->fetch()){
		$row = array("ingredient_id"=>$ingredient_id, "name"=>$name, "price"=>$price, "unit_size"=>$unit_size, "unit"=>$unit, "category"=>$category); 
		$rows[] = $row;
	}
	
	echo json_encode($rows);

?>