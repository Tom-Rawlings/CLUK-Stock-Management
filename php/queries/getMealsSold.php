<?php

	/*
		Takes a date through post and returns quantity of each meal sold by the restaurant
	*/

	require $_SERVER['DOCUMENT_ROOT'] . "/Cluk/php/admin/connect.php";

	$dateString = $_POST["dateString"];
	$restaurant_id = $_SESSION["restaurant_id"];

	$query = "SELECT Distinct(meal_id) as meal_id, count(meal_id) as count FROM cluk_restaurant_sold_meals 
					WHERE restaurant_id = ? AND dateAndTime > ? GROUP BY meal_id;";

	$stmt = $conn->stmt_init();
	$stmt = $conn->prepare($query);
	$stmt->bind_param('is', $restaurant_id, $dateString);
	$stmt->execute();
	
	$stmt->bind_result($meal_id, $count);

	$rows = array();
	while($stmt->fetch()){
		$row = array("meal_id"=>$meal_id, "count" => $count); 
		$rows[] = $row;
	}
	
	echo json_encode($rows);

?>