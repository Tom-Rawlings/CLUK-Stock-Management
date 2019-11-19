<?php

	/*
		Takes a postcode and returns an address id 
	*/

	require $_SERVER['DOCUMENT_ROOT'] . "/Cluk/php/admin/connect.php";

	$postcode = $_POST["postcode"];


	$query = "SELECT address_id FROM cluk_address WHERE postcode = ?;";
	$stmt = $conn->stmt_init();
	$stmt = $conn->prepare($query);

	$stmt->bind_param('s', $postcode);
	$stmt->execute();
	
	$stmt->bind_result($address_id);

	$rows = array();
	while($stmt->fetch()){
		$row = array("address_id"=>$address_id); 
		$rows[] = $row; 
	}
	
	echo json_encode($rows);

?>