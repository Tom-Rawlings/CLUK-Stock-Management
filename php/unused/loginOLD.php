<?php

	require 'connect.php';
		
	$email=$_POST["email"];
	$password=$_POST["password"];

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

		/*
		echo "Login succesful<br/>";
		echo "<br/>Welcome ", $email, "<br/>";
		echo "Your password is: ", $password, "<br/>";
		echo "Your staff ID is: ", $_SESSION["staff_id"], "<br/>";
		echo "Your job type is: ", $_SESSION["jobType"], "<br/>";
		*/

		if($jobType == "Restaurant Manager"){
			//Get the restaurant_id that the manager works at and store it as a session variable
			$query = "SELECT restaurant_id FROM restaurant WHERE manager_staff_id = ?;";
			$stmt = $conn->stmt_init();
			$stmt = $conn->prepare($query);
			$stmt->bind_param('i', $staff_id);
			$stmt->execute();
			$stmt->bind_result($restaurant_id);
			$stmt->fetch();
			$_SESSION["restaurant_id"] = $restaurant_id;
			//echo "Restaurant ID = ", $restaurant_id;

			//Load manager page
			header("Location: /Cluk/html/ManagerOrderHomepage.html");
		}else if($jobType == "Delivery Driver"){
			//Load driver page
			header("Location: /Cluk/html/CLUK3.html");
		}else if($jobType == "Warehouse Worker"){
			//Load warehouse page
			header("Location: /Cluk/html/wareHouse.html");
		}else if($jobType == "Restaurant Worker"){
			$query = "SELECT restaurant_id FROM restaurant_has_workers WHERE staff_id = ?;";
			$stmt = $conn->stmt_init();
			$stmt = $conn->prepare($query);
			$stmt->bind_param('i', $staff_id);
			$stmt->execute();
			$stmt->bind_result($restaurant_id);
			$stmt->fetch();
			$_SESSION["restaurant_id"] = $restaurant_id;
			//Load restaurant staff page

			header("Location: /Cluk/html/RestaurantWorker.html");
		}else if($jobType == "Human Resources"){
			header("Location: /Cluk/html/registration.html");
		}else{
			header("Location: /Cluk/html/errorPage.html");
		}

	}else{
		echo "Login failed: User does not exist<br/>";
	}
	
	$stmt->close();

?>
