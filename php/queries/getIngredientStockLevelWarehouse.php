<?php
	
	/*
		Takes an ingredient id through POST and returns an array of rows containing:
		ingredient name, portion quantity, and category showing the warehouse's stock level.
	*/

	require $_SERVER['DOCUMENT_ROOT'] . "/Cluk/php/admin/connect.php";

	$ingredient_id = $_POST["ingredient_id"];
	$warehouse_id = 1;

	$query = "SELECT i.ingredient_id, i.name, wsi.quantity, i.category 
			FROM cluk_ingredients i, cluk_warehouse_stocks_ingredients wsi 
			WHERE wsi.warehouse_id = ? AND wsi.ingredient_id = i.ingredient_id
            AND i.ingredient_id = ?;";

	$stmt = $conn->stmt_init();
	$stmt = $conn->prepare($query);
	$stmt->bind_param('ii', $warehouse_id, $ingredient_id);
	$stmt->execute();
	
	$stmt->bind_result($ingredient_id, $name, $quantity, $category);

	$rows = array();
	while($stmt->fetch()){
		$row = array("ingredient_id"=>$ingredient_id, "name"=>$name, "quantity"=>$quantity, "category"=>$category); 
		$rows[] = $row;
	}

	echo json_encode($rows);

?>