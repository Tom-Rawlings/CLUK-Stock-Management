<?php
  /*Page redirect if the user is not logged in*/
  require $_SERVER['DOCUMENT_ROOT'] . '/Cluk/php/admin/checkLogin.php';
?>

<!DOCTYPE html>

<html>

  <head> 
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, 
    shrink-to-fit=no">

    <title>Notification Center</title>

    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="/Cluk/js/Notifications.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="/Cluk/css/stylesheet.css">
    <link rel="stylesheet" type="text/css" href="/Cluk/css/stylesheetNotification.css">
    <link rel="stylesheet" type="text/css" href="/Cluk/css/stylesheetGrid.css">
    <link rel="stylesheet" type="text/css" href="/Cluk/css/stylesheetMap.css">
  </head>

  <body>

    <?php
      include($_SERVER['DOCUMENT_ROOT'] . "/Cluk/html/header.html");
    ?>

    <?php
      $jobType = $_SESSION["jobType"]; 
        switch ($jobType) {
          case "Restaurant Manager":
          include($_SERVER['DOCUMENT_ROOT'] . "/Cluk/html/sideBarManager.html");
          break;

          case "Restaurant Worker":
            include($_SERVER['DOCUMENT_ROOT'] . "/Cluk/html/sideBarRestaurantWorker.html");
            break;

          case "Warehouse Worker":
            include($_SERVER['DOCUMENT_ROOT'] . "/Cluk/html/sideBarWarehouse.html");
            break;

          case "Delivery Driver":
            include($_SERVER['DOCUMENT_ROOT'] . "/Cluk/html/sideBarDriver.html");
            break;

          case "Human Resources":
            include($_SERVER['DOCUMENT_ROOT'] . "/Cluk/html/sideBarHR.html");
            break;

          default:
            header("Location: /Cluk/html/index.php");
      }

    ?>  

    <div id="main">
      <div class="container">
          <h2>Notification Center</h2>
          <div id="notification-list">
          </div>
      </div>
    </div>

    <?php
      include($_SERVER['DOCUMENT_ROOT'] . "/Cluk/html/footerNotification.html");
    ?>   

  </body>
</html>
