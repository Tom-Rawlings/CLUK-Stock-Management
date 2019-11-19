<?php

	/*
		Gets ingredients from an order
	*/

	require $_SERVER['DOCUMENT_ROOT'] . "/Cluk/php/admin/connect.php";

	$order_id = $_POST["order_id"];

	$query = "SELECT i.name, ohi.quantity FROM cluk_ingredients AS i, cluk_order_has_ingredients AS ohi
			WHERE ohi.order_id = ? AND ohi.ingredient_id = i.ingredient_id;";

	$stmt = $conn->stmt_init();
	$stmt = $conn->prepare($query);
	$stmt->bind_param('i', $order_id);
	$stmt->execute();
	
	$stmt->bind_result($name, $quantity);

	$rows = array();
	while($stmt->fetch()){
		$row = array("name"=>$name, "quantity"=>$quantity); 
		$rows[] = $row;
	}
	
	echo json_encode($rows);

?>