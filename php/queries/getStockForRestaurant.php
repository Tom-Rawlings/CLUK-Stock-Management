<?php
	
	/*
		Takes a restaurant_id through POST and returns an array of rows containing:
		ingredient name, quantity, and category showing the restaurant's stock levels.
	*/

	require $_SERVER['DOCUMENT_ROOT'] . "/Cluk/php/admin/connect.php";

	//$restaurant_id = $_POST["restaurant_id"];
	$restaurant_id = $_SESSION["restaurant_id"];

	$query = "SELECT i.ingredient_id, i.name, rsi.quantity, i.category 
			FROM cluk_ingredients i, cluk_restaurant r, cluk_restaurant_stocks_ingredients rsi 
			WHERE rsi.restaurant_id = ? AND rsi.ingredient_id = i.ingredient_id
            AND r.restaurant_id = ?;";

	$stmt = $conn->stmt_init();
	$stmt = $conn->prepare($query);
	$stmt->bind_param('ii', $restaurant_id, $restaurant_id);
	$stmt->execute();
	
	$stmt->bind_result($ingredient_id, $name, $quantity, $category);

	$rows = array();
	while($stmt->fetch()){
		$row = array("ingredient_id"=>$ingredient_id, "name"=>$name, "quantity"=>$quantity, "category"=>$category); 
		$rows[] = $row;
	}

	echo json_encode($rows);

?>