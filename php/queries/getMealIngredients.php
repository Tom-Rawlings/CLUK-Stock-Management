<?php

	/*
		Returns meal id, item name, and price for all meals in the meal table
	*/

	require $_SERVER['DOCUMENT_ROOT'] . "/Cluk/php/admin/connect.php";

	$meal_id = $_POST["meal_id"];

	$query = "SELECT ingredient_id, quantity FROM cluk_meal_has_ingredients WHERE meal_id = ?;";

	$stmt = $conn->stmt_init();
	$stmt = $conn->prepare($query);
	$stmt->bind_param('i', $meal_id);
	$stmt->execute();
	
	$stmt->bind_result($ingredient_id, $quantity);

	$rows = array();
	while($stmt->fetch()){
		$row = array("ingredient_id"=>$ingredient_id, "quantity"=>$quantity);
		$rows[] = $row;
	}
	
	echo json_encode($rows);

?>