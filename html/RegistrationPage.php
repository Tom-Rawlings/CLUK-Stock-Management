<!DOCTYPE html>

<!--Page redirect if the user is not logged in -->
<?php
  require $_SERVER['DOCUMENT_ROOT'] . '/Cluk/php/admin/checkManager.php';
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Registration Page</title>
    <link rel="stylesheet"  type="text/css" href="2018-19/CSC8005/Team05//website/css/registration.css">
    <link rel="stylesheet" type="text/css" href="2018-19/CSC8005/Team05//website/css/stylesheet.css">
	<link rel="stylesheet" type="text/css" href="2018-19/CSC8005/Team05//website/css/stylesheetSidebar.css">
	<link rel="stylesheet" type="text/css" href="2018-19/CSC8005/Team05//website/css/stylesheetGrid.css">
	<link rel="stylesheet" type="text/css" href="2018-19/CSC8005/Team05//website/css/cart.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

 <body>

  <?php
    include($_SERVER['DOCUMENT_ROOT'] . "/Cluk/html/header.html");
  ?>

<?php
  include($_SERVER['DOCUMENT_ROOT'] . "/Cluk/html/sideBar.html");
?>  

<div id="main">	
	
<div class="RegistrationA">
</div>
<form enctype="multipart/form-data">
    <div class="RegistrationB">
    <div class="RegistrationC">Registration</div>
    <br/>
    <span class="p">*</span>
    <label for="username" class="l">First Name:</label>
    <div class="RegistrationD">
    <input id="username" type="text"  class="RegistrationE">
    </div>
    <br/><br/>
    <span class="p">*</span>
    <label for="username" class="l">Last Name:</label>
    <div class="RegistrationG">
    <input id="username" type="text" class="RegistrationH">
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
        <input id="address" type="text"  class="i">
    </div>
    <br/><br/>
    <span class="p">*</span>
    <label for="email" class="l">Email:</label>
    <div  class="d">
        <input id="email" type="email" class="i">
    </div>
    <br/><br/>

        <input class="button"  type="submit" value="Submit" style="float: right" onclick="window.location.href='http://www.google.com'" >

    </div>
</form>
</div>
<script>

function openNav() {
  document.getElementById("mySidenav").style.width = "250px";
  document.getElementById("main").style.marginLeft = "250px";
  document.body.style.backgroundColor = "rgba(0,0,0,0.4)";
}

function closeNav() {
  document.getElementById("mySidenav").style.width = "0";
   document.getElementById("main").style.marginLeft = "0";
  document.body.style.backgroundColor = "white";
}
</script>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>

 </body>
</html>
