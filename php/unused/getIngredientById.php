<?php

	/*
		Takes a restaurant_id and order_id and returns an array of rows containing:	ingredient name, quantity, and category for that order from that restaurant.
	*/

	//require $_SERVER['DOCUMENT_ROOT'] . "/Cluk/php/admin/connect.php";
	require $_SERVER['DOCUMENT_ROOT'] . "/Cluk/php/admin/connect.php";

	$ingredient_id = $_POST["ingredient_id"];

	$query = "SELECT * FROM ingredients WHERE ingredients.ingredient_id = ?;";

	$stmt = $conn->stmt_init();
	$stmt = $conn->prepare($query);
	$stmt->bind_param('i', $ingredient_id);
	$stmt->execute();
	
	$stmt->bind_result($ingredient_id, $name, $price, $unit_size, $unit, $category);

	$rows = array();
	while($stmt->fetch()){
		$row = array("ingredient_id"=>$ingredient_id, "name"=>$name, "price"=>$price, $unit_size=>"unit_size", $unit=>"unit", "category"=>$category); 
		$rows[] = $row;
	}
	
	echo json_encode($rows);

?>