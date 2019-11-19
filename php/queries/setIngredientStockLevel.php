<?php
	
	/*
		Takes a restaurant_id through POST and returns an array of rows containing:
		ingredient name, portion quantity, and category showing the restaurant's stock levels.
	*/

	require $_SERVER['DOCUMENT_ROOT'] . "/Cluk/php/admin/connect.php";

	$ingredient_id = $_POST["ingredient_id"];
	$quantity = $_POST["quantity"];
	$restaurant_id = $_SESSION["restaurant_id"];

	if($quantity < 0)
		$quantity = 0;

	$query = "UPDATE cluk_restaurant_stocks_ingredients
			SET quantity = ?
			WHERE ingredient_id = ? AND restaurant_id = ?;";

	$stmt = $conn->stmt_init();
	$stmt = $conn->prepare($query);
	$stmt->bind_param('iii', $quantity, $ingredient_id, $restaurant_id);
	$stmt->execute();
	
?>