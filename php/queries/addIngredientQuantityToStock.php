<?php
	
	/*
		Takes an ingredient_id and a quantity and increases the 
		current restaurant's stock by the quantity amount
	*/

	require $_SERVER['DOCUMENT_ROOT'] . "/Cluk/php/admin/connect.php";

	$ingredient_id = $_POST["ingredient_id"];
	$quantity = $_POST["quantity"];
	$restaurant_id = $_SESSION["restaurant_id"];

	if($quantity < 0)
		$quantity = 0;

	$query = "UPDATE cluk_restaurant_stocks_ingredients SET quantity = quantity + ? 
						WHERE restaurant_id = ? AND ingredient_id = ?;";

	$stmt = $conn->stmt_init();
	$stmt = $conn->prepare($query);
	$stmt->bind_param('iii', $quantity, $restaurant_id, $ingredient_id);
	$stmt->execute();
	
?>