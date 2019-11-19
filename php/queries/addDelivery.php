<?php

	/*
		Takes a date, set of orders and driver Id from javascript. Changes the delivery status to Dispatched
        and updates the delivery has drivers table to reflect that the driver has a new delivery.
	*/

	require $_SERVER['DOCUMENT_ROOT'] . "/Cluk/php/admin/connect.php";

	
	$date = $_POST["date"];
	$orders = $_POST["orders"];
	$driver_id = $_POST["driver_id"];

	$query = "INSERT INTO cluk_delivery (status, dateAndTime) VALUES ('Dispatched', ?);";
	$stmt = $conn->stmt_init();
	$stmt = $conn->prepare($query);
	$stmt->bind_param('s', $date);
	$stmt->execute();

	$query = "SELECT max(delivery_id) FROM cluk_cluk_delivery;";
	$stmt = $conn->stmt_init();
	$stmt = $conn->prepare($query);
	$stmt->execute();
	$stmt->bind_result($delivery_id);
	$stmt->fetch();

	foreach($orders as $x){
		$query = "INSERT INTO cluk_delivery_has_orders (delivery_id, order_id) VALUES (?, ?);";
		$stmt = $conn->stmt_init();
		$stmt = $conn->prepare($query);
		$stmt->bind_param('ii', $delivery_id, $x);
		$stmt->execute();
	}

	foreach($orders as $x){
		$query = "UPDATE cluk_order SET `status` = 'Dispatched' WHERE order_id = ?;";
		$stmt = $conn->stmt_init();
		$stmt = $conn->prepare($query);
		$stmt->bind_param('i', $x);
		$stmt->execute();
	}

	$query = "UPDATE cluk_driver SET `status` = 'Assigned' WHERE staff_id = ?;";
	$stmt = $conn->stmt_init();
	$stmt = $conn->prepare($query);
	$stmt->bind_param('i', $staff_id);
	$stmt->execute();

	$query = "INSERT INTO delivery_has_drivers (delivery_id, driver_id, status) VALUES (?, ?, 'Dispatched');";
	$stmt = $conn->stmt_init();
	$stmt = $conn->prepare($query);
	$stmt->bind_param('ii', $delivery_id, $driver_id);
	$stmt->execute();
	

/*
	$query = "UPDATE delivery_has_drivers SET delivery_id = ? WHERE staff_id = ?;";
	$stmt = $conn->stmt_init();
	$stmt = $conn->prepare($query);
	$stmt->bind_param('ii',$delivery_id, $driver_id);
	$stmt->execute();
	*/
	
	
	echo ("delivery_id = ".$delivery_id." driver_id = ".$driver_id);

?>
