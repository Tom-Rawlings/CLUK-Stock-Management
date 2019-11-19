<?php

	/*
		Returns order Ids from a delivery.
	*/

	require $_SERVER['DOCUMENT_ROOT'] . "/Cluk/php/admin/connect.php";

	$delivery_id = $_POST["delivery_id"];

	$query = "SELECT dho.order_id, o.`status` FROM cluk_delivery_has_orders AS dho, cluk_order AS o 
					WHERE dho.delivery_id = ? AND o.order_id = dho.order_id;";

	$stmt = $conn->stmt_init();
	$stmt = $conn->prepare($query);
	$stmt->bind_param('i', $delivery_id);
	$stmt->execute();

	$stmt->bind_result($order_id, $status);
	
	
	$rows = array();
	while($stmt->fetch()){
		$row = array("order_id"=>$order_id, "status"=>$status); 
		$rows[] = $row;
	}
	
	echo json_encode($rows);

?>