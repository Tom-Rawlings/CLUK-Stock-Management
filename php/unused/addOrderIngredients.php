<?php

	require $_SERVER['DOCUMENT_ROOT'] . "/Cluk/php/admin/connect.php";


	$order = $_POST["orderValues"];
	$order_id = $_POST["order_id"];


	foreach($order as $x){
		$query = "INSERT INTO order_has_ingredients (order_id, ingredient_id, quantity) VALUES (?, ?, ?);";
		$stmt = $conn->stmt_init();
		$stmt = $conn->prepare($query);
		$stmt->bind_param('iii', $order_id, $x[0], $x[1]);
		$stmt->execute();
	}
	

?>