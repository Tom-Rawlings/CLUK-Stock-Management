<?php

	/*
		Returns the total number of ingredients in the database.
	*/

	require $_SERVER['DOCUMENT_ROOT'] . "/Cluk/php/admin/connect.php";

	$query = "SELECT COUNT(ingredient_id) FROM ingredients;";

	$stmt = $conn->stmt_init();
	$stmt = $conn->prepare($query);
	$stmt->execute();
	
	
	$stmt->bind_result($count);
	$stmt->fetch();
	
	echo $count;

?>