<?php
	
	/*
		Takes a restaurant_id through POST and returns an array of rows containing:
		ingredient name, portion quantity, and category showing the restaurant's stock levels.
	*/

	//require $_SERVER['DOCUMENT_ROOT'] . "/Cluk/php/admin/connect.php";
	require $_SERVER['DOCUMENT_ROOT'] . "/Cluk/php/admin/connect.php";

	$query = "SELECT * FROM cluk_ingredients;";

	$stmt = $conn->stmt_init();
	$stmt = $conn->prepare($query);
	$stmt->execute();
	
	$stmt->bind_result($ingredient_id, $name, $price, $unit_size, $unit, $category);

	$rows = array();
	while($stmt->fetch()){
		$row = array("ingredient_id"=>$ingredient_id, "name"=>$name,"price"=>$price, "unit_size"=>$unit_size, "unit"=>$unit,"category"=>$category); 
		$rows[] = $row;
	}

	echo json_encode($rows);

?>