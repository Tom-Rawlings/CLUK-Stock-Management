<?php
	
	/*
		Takes an ingredient id and quantity through POST and updates the warehouse's stock level.
	*/

	require $_SERVER['DOCUMENT_ROOT'] . "/Cluk/php/admin/connect.php";

	$ingredient_id = $_POST["ingredient_id"];
	$quantity = $_POST["quantity"];
	$warehouse_id = 1;

	if($quantity < 0)
		$quantity = 0;

	$query = "UPDATE cluk_warehouse_stocks_ingredients
			SET quantity = ?
			WHERE ingredient_id = ? AND warehouse_id = ?;";

	$stmt = $conn->stmt_init();
	$stmt = $conn->prepare($query);
	$stmt->bind_param('iii', $quantity, $ingredient_id, $warehouse_id);
	$stmt->execute();
	
?>