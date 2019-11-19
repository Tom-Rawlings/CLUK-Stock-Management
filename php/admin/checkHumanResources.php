<?php

	require $_SERVER['DOCUMENT_ROOT'] . '/Cluk/php/admin/connect.php';	
	
  if(!isset($_SESSION['loggedIn']) || $_SESSION['jobType'] != "Human Resources"){
    header("Location: /Cluk/html/index.php");
  }
?>
