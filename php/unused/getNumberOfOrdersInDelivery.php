<?php

	/*
		Returns the total number of ingredients in the database.
	*/

	require $_SERVER['DOCUMENT_ROOT'] . "/Cluk/php/admin/connect.php";

	$delivery_id = $_POST["delivery_id"];

	$query = "SELECT COUNT(order_id) FROM cluk_delivery_has_orders WHERE delivery_id = ?;";

	$stmt = $conn->stmt_init();
	$stmt = $conn->prepare($query);
	$stmt->bind_param('i', $delivery_id);
	$stmt->execute();

	$stmt->bind_result($returnValue);
	
	
	$rows = array();
	while($stmt->fetch()){
		$row = array("returnValue"=>$returnValue); 
		$rows[] = $row;
	}
	
	echo json_encode($rows);

?>