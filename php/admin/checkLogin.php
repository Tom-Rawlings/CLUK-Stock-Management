<?php
	/*
		Checks to ensure the current user is logged in which is set during the login.
	*/

	require $_SERVER['DOCUMENT_ROOT'] . '/Cluk/php/admin/connect.php';

  if(!isset($_SESSION['loggedIn'])){
    header('Location: /Cluk/html/index.php'); 
  }
?>
