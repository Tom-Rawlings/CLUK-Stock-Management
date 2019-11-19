<?php

	require $_SERVER['DOCUMENT_ROOT'] . "/Cluk/php/admin/connect.php";

	$meal_id = $_POST["meal_id"];
	$restaurant_id = $_SESSION["restaurant_id"];

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

/*
	$hasEnoughStock = true;

	while($stmt->fetch()){
		$query2 = "SELECT quantity FROM restaurant_stocks_ingredients WHERE restaurant_id = ? AND ingredient_id = ?;";
		$stmt2 = $conn->stmt_init();
		$stmt2 = $conn->prepare($query2);
		echo $stmt2;
		$stmt2->bind_param('ii', $restaurant_id, $ingredient_id);
		$stmt2->execute();
		$stmt2->bind_result($quantity);
		if($quantity < $requiredQuantity){
			$hasEnoughStock = false;
		}
	}

	echo $hasEnoughStock;
*/


?>