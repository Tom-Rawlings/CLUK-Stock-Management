<?php

	/*
		Takes an order_id and sets it's status as Arrived
	*/

	require $_SERVER['DOCUMENT_ROOT'] . "/Cluk/php/admin/connect.php";

	$order_id = $_POST["order_id"];

	$query = "UPDATE cluk_order SET `status`= 'Arrived' WHERE order_id = ?;";

	$stmt = $conn->stmt_init();
	$stmt = $conn->prepare($query);
	$stmt->bind_param('i', $order_id);
	$stmt->execute();


?>