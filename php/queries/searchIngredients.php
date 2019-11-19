<?php

	/*
		Takes a search string and returns the ingredients that match the string.
	*/

	require $_SERVER['DOCUMENT_ROOT'] . "/Cluk/php/admin/connect.php";

	$restaurant_id = $_SESSION["restaurant_id"];
	$searchString = $_POST["searchString"];
	$searchString = '%'.$searchString.'%';
	//$searchString = '%let%';
	//$searchString = 'let';


	$query = "SELECT ingredient_id, name, price, unit_size, unit, category FROM cluk_ingredients WHERE name LIKE ?;";

	$stmt = $conn->stmt_init();
	$stmt = $conn->prepare($query);
	$stmt->bind_param('s', $searchString);
	$stmt->execute();
	
	$stmt->bind_result($ingredient_id, $name, $price, $unit_size, $unit, $category);

	$rows = array();
	while($stmt->fetch()){
		$row = array("ingredient_id"=>$ingredient_id, "name"=>$name, "price"=>$price, "unit_size"=>$unit_size, "unit"=>$unit, "category"=>$category); 
		$rows[] = $row;
	}
	
	echo json_encode($rows);

?>