<?php
	
	/*
		Returns all security questions from the database.
	*/

	//require $_SERVER['DOCUMENT_ROOT'] . "/Cluk/php/admin/connect.php";
	require $_SERVER['DOCUMENT_ROOT'] . "/Cluk/php/admin/connect.php";

	$query = "SELECT DISTINCT jobType FROM cluk_staff;";

	$stmt = $conn->stmt_init();
	$stmt = $conn->prepare($query);
	$stmt->execute();
	
	$stmt->bind_result($jobType);

	$rows = array();
	while($stmt->fetch()){
		$row = array("jobType"=>$jobType); 
		$rows[] = $row;
	}

	echo json_encode($rows);

?>