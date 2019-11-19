<?php
	
	/*
		Takes a restaurant_id through POST and returns an array of rows containing:
		ingredient name, portion quantity, and category showing the restaurant's stock levels.
	*/

	require $_SERVER['DOCUMENT_ROOT'] . "/Cluk/php/admin/connect.php";

	$ingredient_id = $_POST["ingredient_id"];
	$quantity = $_POST["quantity"];
	$restaurant_id = $_SESSION["restaurant_id"];

	$query = "UPDATE cluk_restaurant_stocks_ingredients SET quantity = (quantity-?) WHERE ingredient_id = ? AND restaurant_id = ?;";

	$stmt = $conn->stmt_init();
	$stmt = $conn->prepare($query);
	$stmt->bind_param('iii', $quantity, $ingredient_id, $restaurant_id);
	$stmt->execute();
	
	/*$stmt->bind_result($ingredient_id, $name, $portion_quantity, $category);

	$rows = array();
	while($stmt->fetch()){
		$row = array("ingredient_id"=>$ingredient_id, "name"=>$name, "portion_quantity"=>$portion_quantity, "category"=>$category); 
		$rows[] = $row;
	}

	echo json_encode($rows);
	*/

?>