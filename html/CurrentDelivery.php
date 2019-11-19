<!DOCTYPE html>

<!--Page redirect if the user is not logged in -->
<?php
  require $_SERVER['DOCUMENT_ROOT'] . '/Cluk/php/admin/checkDeliveryDriver.php';
?>

<html>
  <head> 
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>
      CLUK Deliveries
    </title>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="/Cluk/css/stylesheet.css">
    <link rel="stylesheet" type="text/css" href="/Cluk/css/stylesheetSidebarDrivers.css">
    <link rel="stylesheet" type="text/css" href="/Cluk/css/stylesheetGrid.css">
    <link rel="stylesheet" type="text/css" href="/Cluk/css/stylesheetMap.css">


  </head>

   <body>


    <?php
      include($_SERVER['DOCUMENT_ROOT'] . "/Cluk/html/header.html");
    ?>


    <?php
      include($_SERVER['DOCUMENT_ROOT'] . "/Cluk/html/sideBarDriver.html");
    ?>  

    <div id="main">
        
    <!--</div>-->
    <div id="map"></div>
    <div id="directions-panel"></div>
    <div id="orders"></div>
    <div id="finishDelivery"></div>

    </div>

    <script src="/Cluk/js/DriverMap.js"></script>
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDF0kheJ5c9jYY5hmP-Skes7Ku33mNMK_I&callback=initMap">
    </script>

  </body>
</html>