<?php
	
	/*
		Returns all security questions from the database.
	*/

	//require $_SERVER['DOCUMENT_ROOT'] . "/Cluk/php/admin/connect.php";
	require $_SERVER['DOCUMENT_ROOT'] . "/Cluk/php/admin/connect.php";

	$query = "SELECT * FROM cluk_question;";

	$stmt = $conn->stmt_init();
	$stmt = $conn->prepare($query);
	$stmt->execute();
	
	$stmt->bind_result($question_id, $question);

	$rows = array();
	while($stmt->fetch()){
		$row = array("question_id"=>$question_id, "question"=>$question); 
		$rows[] = $row;
	}

	echo json_encode($rows);

?>