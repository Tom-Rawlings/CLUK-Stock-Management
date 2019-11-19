<!DOCTYPE html>

<html>
	<head>
		<title>CLUCK Deliveries</title>

		<link rel="stylesheet" type="text/css" href="/Cluk/css/stylesheet.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.8/css/all.css">

		<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
	</head>

	<body>
	 
	  <?php
	    include($_SERVER['DOCUMENT_ROOT'] . "/Cluk/html/headerLogin.html");
	  ?>

		<div id="mainLogin">
			<div class="bg"></div>


		<!--<form class="box" action="/Cluk/php/admin/login.php" method="post">-->
		<script src="/Cluk/js/Login.js"></script>
		<form onsubmit="return validate();" class="box" action="/Cluk/php/admin/login.php" method="post">
			<h2>Restaurant Login</h2>

			<p>Email</p>
			<input type="text" id="email" name="email" placeholder="yourEmail">

			<p>Password</p>
			<input type="password" id="password" name="password" placeholder="yourPassword123">

			<input class="submitButton" type="submit" name="" value="Login">


			<input class="submitButton" type="button" name="" value="Forgotten Password?" onclick="window.location.href = '/Cluk/html/forgottenpassword.html';">
			<p id="errorText"></p>
			<div id="exampleCredentials">
				<table>
					<tr>
						<th>Login Type</th><th>Email</th><th>Password</th>
					</tr>
					<tr>
						<td>Warehouse Worker</td><td>warehouse@cluk.com</td><td>warehouse1</td>
					</tr>
					<tr>
						<td>Manager</td><td>manager@cluk.com</td><td>manager`</td>
					</tr>
					<tr>
						<td>Delivery Driver</td><td>driver@cluk.com</td><td>driver1</td>
					</tr>
					<tr>
						<td>Restaurant Worker</td><td>worker1@cluk.com</td><td>worker1</td>
					</tr>
				</table>
			</div>
		</form>
		</div>

    <?php
      include($_SERVER['DOCUMENT_ROOT'] . "/Cluk/html/Footer.html");
		?> 

	</body>
</html>
