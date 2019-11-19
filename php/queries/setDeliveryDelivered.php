<?php

	/*
		Takes an delivery_id and sets it's status as Delivered
	*/

	require $_SERVER['DOCUMENT_ROOT'] . "/Cluk/php/admin/connect.php";

	$delivery_id = $_POST["delivery_id"];

	$query = "UPDATE cluk_delivery SET `status`= 'Delivered' WHERE delivery_id = ?;";

	$stmt = $conn->stmt_init();
	$stmt = $conn->prepare($query);
	$stmt->bind_param('i', $delivery_id);
	$stmt->execute();


?>