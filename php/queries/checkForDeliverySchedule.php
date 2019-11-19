<?php

    /*
		checks to see if a driver has a delivery
	*/

	require $_SERVER['DOCUMENT_ROOT'] . "/Cluk/php/admin/connect.php";

	$delivery_id = $_POST["delivery_id"];

	$query = "SELECT delivery_id FROM cluk_delivery_has_schedules WHERE delivery_id = ?;";
	$stmt = $conn->stmt_init();
	$stmt = $conn->prepare($query);
	$stmt->bind_param('i', $delivery_id);
	$stmt->execute();

	$stmt->store_result();
	if($stmt->num_rows > 0){
		echo true;
	}else{
		echo false;
	}


?>