<?php
	/*
		Checks to ensure the current user is of jobType Driver. Else returns them to login page.
	*/

	require $_SERVER['DOCUMENT_ROOT'] . '/Cluk/php/admin/connect.php';	

  if(!isset($_SESSION['loggedIn']) || $_SESSION['jobType'] != "Delivery Driver"){
    header('Location: /Cluk/html/index.php'); 
  }
?>
