<?php

	/*
		Takes the email and password from the user and checks it via sha1 encription.
        Using a prepared statement runs a query into mysql and sets the header location to redirect each user.
        Saves their staff id and jobtype for future use. Also sets logged in status for the session to true.
	*/

	require 'connect.php';
		
	$email=$_POST["email"];
	$password=$_POST["password"];
	$password=sha1($password);

	$_SESSION['loggedIn'] = false;


	$query = "SELECT email, password, staff_id, jobType FROM cluk_staff WHERE email = ? AND password = ?";
	$stmt = $conn->stmt_init();
	$stmt = $conn->prepare($query);
	$stmt->bind_param('ss', $email, $password);
	$stmt->execute();

	$stmt->store_result();
	if($stmt->num_rows == 1){
		//User has successfully logged in
   	$_SESSION['loggedIn'] = true;  

		$stmt->bind_result($email, $password, $staff_id, $jobType);
		$stmt->fetch();
		$_SESSION["staff_id"]=$staff_id;
		$_SESSION["jobType"]=$jobType;


		if($jobType == "Restaurant Manager"){
			//Get the restaurant_id that the manager works at and store it as a session variable
			$query = "SELECT restaurant_id FROM cluk_restaurant WHERE manager_staff_id = ?;";
			$stmt = $conn->stmt_init();
			$stmt = $conn->prepare($query);
			$stmt->bind_param('i', $staff_id);
			$stmt->execute();
			$stmt->bind_result($restaurant_id);
			$stmt->fetch();
			$_SESSION["restaurant_id"] = $restaurant_id;
			//echo "Restaurant ID = ", $restaurant_id;

			//Load manager page
			header("Location: ../../html/ManagerOrderHomepage.php");
		}else if($jobType == "Delivery Driver"){
			//Load driver page
			header("Location: ../../html/CurrentDelivery.php");
		}else if($jobType == "Warehouse Worker"){
			header("Location: ../../html/wareHouse.php");
		}else if($jobType == "Restaurant Worker"){
			$query = "SELECT restaurant_id FROM cluk_restaurant_has_workers WHERE staff_id = ?;";
			$stmt = $conn->stmt_init();
			$stmt = $conn->prepare($query);
			$stmt->bind_param('i', $staff_id);
			$stmt->execute();
			$stmt->bind_result($restaurant_id);
			$stmt->fetch();
			$_SESSION["restaurant_id"] = $restaurant_id;
			//Load restaurant staff page

			header("Location: ../../html/RestaurantWorker.php");
		}else if($jobType == "Human Resources"){
			header("Location: ../../html/registration.php");
		}

	}else{
		echo "Login failed: User does not exist<br/>";
	}
	
	$stmt->close();

?>
