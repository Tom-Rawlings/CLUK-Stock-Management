<?php
  /*Page redirect if the user is not logged in*/
  require $_SERVER['DOCUMENT_ROOT'] . '/Cluk/php/admin/checkHumanResources.php';
?>

<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Registration Page</title>

    <link rel="stylesheet" type="text/css" href="/Cluk/css/registration.css">
    <link rel="stylesheet" type="text/css" href="/Cluk/css/stylesheet.css">
	<link rel="stylesheet" type="text/css" href="/Cluk/css/stylesheetSidebar.css">
	<link rel="stylesheet" type="text/css" href="/Cluk/css/stylesheetGrid.css">
	<link rel="stylesheet" type="text/css" href="/Cluk/css/cart.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>


</head>
<body>

  <?php
    include($_SERVER['DOCUMENT_ROOT'] . "/Cluk/html/header.html");
  ?>

<?php
  include($_SERVER['DOCUMENT_ROOT'] . "/Cluk/html/sideBarHR.html");
?>  

<!--<div id="main">	-->
    <div class="centeredContainer">
	
<div class="RegistrationA">
</div>
<form enctype="multipart/form-data">
    <div class="RegistrationB">
    <div class="RegistrationC">Registration</div>
    <br/>
    <span class="p">*</span>
    <label for="firstName" class="l">First Name:</label>
    <div class="RegistrationD">
    <input id="firstName" type="text"  class="RegistrationE">
    </div>
    <br/><br/>
    <span class="p">*</span>
    <label for="lastName" class="l">Last Name:</label>
    <div class="RegistrationG">
    <input id="lastName" type="text" class="RegistrationH">
    <span class="RegistrationI"></span>
    </div>
    <br/><br/>
    <span class="p">*</span>
    <label for="phonenumber" class="l">Phone Number:</label>
    <div  class="d">
        <input id="phonenumber" type="number" class="i">
    </div>
    <br/><br/>
    <span class="p">*</span>
    <label for="address" class="l">Address:</label>
    <div  class="d">
        <input id="Line1" type="text" name="Line1" placeholder="Line1" class="i"><br/>
        <br>
            &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp<input id="Line2" type="text"  name="Line2" placeholder="Line2" class="i"><br/>
        <br>
            &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp<input id="City" type="text"  name="City" placeholder="City" class="i"><br/>
        <br>
            &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp<input id="Postcode" type="text"  name="Postcode" placeholder="Postcode" class="i">

    </div>
    <br/><br/>
    <span class="p">*</span>
    <label for="email" class="l">Email:</label>
    <div  class="d">
        <input id="email" type="email" class="i">
    </div>
    <br/><br/>
    <span class="p">*</span>
    <label for="password" class="l">Password:</label>
    <div  class="d">
        <input id="password" type="password" class="i">
    </div>
    <br/><br/>
    <span class="p">*</span>
    <label for="password2" class="l">Confirm Password:</label>
    <div  class="d">
        <input id="password2" type="password" class="i">
    </div>

    <div id="questions">
        <p>Please select a security question.</p>
    </div>

        <input class="submitButton" type="submit" value="Submit" style="float: right" onclick="window.location.href='http://www.google.com'" >
        <input class="submitButton" type="button" value="Validate" style="float:left" onclick="validate()">


    </div>

</form>
</div>
<script type="text/javascript" src="/Cluk/js/RegistrationValidator.js"></script>

 </body>
</html>
