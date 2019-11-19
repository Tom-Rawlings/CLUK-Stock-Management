<?php

	/*
		Returns all drivers that don't have a delivery assigned to them.
	*/

	require $_SERVER['DOCUMENT_ROOT'] . "/Cluk/php/admin/connect.php";

	$query = "SELECT staff_id FROM cluk_driver WHERE `status` = 'Unassigned';";

	$stmt = $conn->stmt_init();
	$stmt = $conn->prepare($query);
	$stmt->execute();
	
	$stmt->bind_result($staff_id);

	$rows = array();
	while($stmt->fetch()){
		$row = array("staff_id"=>$staff_id); 
		$rows[] = $row;
	}
	
	echo json_encode($rows);

?>