<?php

	/*
		Adds all meals from an order to restaurant_sold_meals
	*/

	require $_SERVER['DOCUMENT_ROOT'] . "/Cluk/php/admin/connect.php";


	$order = $_POST["meals"];
	$restaurant_id = $_SESSION["restaurant_id"];

	foreach($order as $x){
		$query = "INSERT INTO cluk_restaurant_sold_meals (meal_id, restaurant_id, dateAndTime) VALUES (?, ?, Now());";
		$stmt = $conn->stmt_init();
		$stmt = $conn->prepare($query);
		$stmt->bind_param('ii', $x, $restaurant_id);
		$stmt->execute();
	}
	

?>