<?php
	
	/*
		Takes a restaurant_id through POST and returns an array of rows containing:
		ingredient name, portion quantity, and category showing the restaurant's stock levels.
	*/

	require $_SERVER['DOCUMENT_ROOT'] . "/Cluk/php/admin/connect.php";

	$query = "SELECT DISTINCT category FROM cluk_ingredients;";

	$stmt = $conn->stmt_init();
	$stmt = $conn->prepare($query);
	$stmt->execute();
	
	$stmt->bind_result($category);

	$rows = array();
	while($stmt->fetch()){
		$row = array("category"=>$category); 
		$rows[] = $row;
	}

	echo json_encode($rows);

?>