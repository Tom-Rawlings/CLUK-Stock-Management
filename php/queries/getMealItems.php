<?php

	/*
		Returns meal id, item name, and price for all meals in the meal table
	*/

	require $_SERVER['DOCUMENT_ROOT'] . "/Cluk/php/admin/connect.php";

	$query = "SELECT * FROM cluk_meal;";

	$stmt = $conn->stmt_init();
	$stmt = $conn->prepare($query);
	//$stmt->bind_param('i', $restaurant_id);
	$stmt->execute();
	
	$stmt->bind_result($meal_id, $item, $price, $image_path);

	$rows = array();
	while($stmt->fetch()){
		$row = array("meal_id"=>$meal_id, "item" => $item, "price" => $price, "image_path" => $image_path); 
		$rows[] = $row;
	}
	
	echo json_encode($rows);

?>