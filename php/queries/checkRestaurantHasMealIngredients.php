<?php
	/*
		Returns if the given restaurant has a quantity greater than the required quantity.
	*/
	require $_SERVER['DOCUMENT_ROOT'] . "/Cluk/php/admin/connect.php";

	$ingredient_id = $_POST["ingredient_id"];
	$requiredQuantity = $_POST["quantity"];
	$restaurant_id = $_SESSION["restaurant_id"];

	$query = "SELECT quantity FROM cluk_restaurant_stocks_ingredients WHERE restaurant_id = ? AND ingredient_id = ?;";
	$stmt = $conn->stmt_init();
	$stmt = $conn->prepare($query);
	$stmt->bind_param('ii', $restaurant_id, $ingredient_id);
	$stmt->execute();
	$stmt->bind_result($quantity);
	$stmt->fetch();
	if($quantity < $requiredQuantity){
		echo false;
	}else{
		echo true;
	}

?>