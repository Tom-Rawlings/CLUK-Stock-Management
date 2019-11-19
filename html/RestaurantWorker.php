<!DOCTYPE html>

<!--Page redirect if the user is not logged in -->
<?php
  require $_SERVER['DOCUMENT_ROOT'] . '/Cluk/php/admin/checkRestaurantWorker.php';
?>

<html>
	<head>
		<meta charset="utf-8">
		<link rel="shortcut icon" href="/Cluk/images/favicon.ico"/>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="/Cluk/css/stylesheetSidebar.css">
    <link rel="stylesheet" type="text/css" href="/Cluk/css/RestaurantWorkerPOS.css">
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>

		<title>
		CLUCK Deliveries
		</title>

		<link rel="stylesheet" type="text/css" href="/Cluk/css/stylesheet.css">
	</head>

	<body>
		
			<div class="title"><h3 class="company"><img class="resize" src="/Cluk/images/Capture.png" alt="Cluck logo image"/> Cluck Delivery Systems</h3>
			</div>

			<?php
	  		include($_SERVER['DOCUMENT_ROOT'] . "/Cluk/html/sideBarRestaurantWorker.html");
	    ?> 
		 <div id="main">
			<div id="cart">
				<div id="cartItems"></div>
				<input type="button" value="Pay" onClick="completeOrder()">
				<input type="button" value="Cancel" onClick="cancelOrder()">
				<div id="cartTotal">Cart Total:</div>
			</div>

			<p id="mainContent"></p>

			<script type="text/javascript" src="/Cluk/js/RestaurantWorkerPos.js"></script>
		</div>

	</body>

	<style>

	</style>
</html>
