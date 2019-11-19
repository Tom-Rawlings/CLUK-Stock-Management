<?php
	/*
		Logs the user out and unsets all the session variables.
	*/

	require $_SERVER['DOCUMENT_ROOT'] . '/Cluk/php/admin/connect.php';
	session_unset();
	header('Location: /Cluk/html/index.php');
  exit;
?>

