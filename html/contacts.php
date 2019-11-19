<?php
  /*Page redirect if the user is not logged in*/
  require $_SERVER['DOCUMENT_ROOT'] . '/Cluk/php/admin/checkLogin.php';
?>
<!DOCTYPE html>

<html>

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>CLUK Deliveries</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="/Cluk/css/stylesheet.css">
    <link rel="stylesheet" type="text/css" href="/Cluk/css/stylesheetSidebar.css">
    <link rel="stylesheet" type="text/css" href="/Cluk/css/cart.css">
    <link rel="stylesheet" type="text/css" href="/Cluk/css/RestaurantStockButton.css">
    <link rel="stylesheet" type="text/css" href="/Cluk/css/contact.css">

    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>

  </head>

  <body>

    <?php
      include($_SERVER['DOCUMENT_ROOT'] . "/Cluk/html/header.html");
    ?>

    <?php
      require $_SERVER['DOCUMENT_ROOT'] . '/Cluk/php/admin/getSidebar.php';
    ?>

    <div id="main">
      <div id="section_left">
        <div class="container">
          <!--main paragraph element that contains the table content built through javascript-->
          <p id="tableMain"></p>
          <script type="text/javascript" src="/Cluk/js/Contacts.js"></script>
          <p id="contactInfo"></p>
        </div>
      </div>
      <div id="mapContainer">
      <div id="map">
        <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d587444.648768278!2d-1.8627899881694387!3d54.878924446657045!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sen!2suk!4v1557404017369!5m2!1sen!2suk" width="800" height="600" frameborder="0" style="border:0" allowfullscreen></iframe>
      </div>
      </div>
    </div>

    <?php
      include($_SERVER['DOCUMENT_ROOT'] . "/Cluk/html/Footer.html");
    ?>

    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDwwTJLsTsxrxO88VbS_CYtOF_vilTUCdc&callback=initMap">
    </script>

  </body>
</html>
