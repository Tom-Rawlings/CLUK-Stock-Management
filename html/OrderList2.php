<!DOCTYPE html>

<!--Page redirect if the user is not logged in -->
<?php
  require $_SERVER['DOCUMENT_ROOT'] . '/Cluk/php/admin/checkManager.php';
?>

<html>


  <head> 
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>CLUK Deliveries</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="/Cluk/css/stylesheet.css">
    <link rel="stylesheet" type="text/css" href="/Cluk/css/stylesheetSidebar.css">
    <link rel="stylesheet" type="text/css" href="/Cluk/css/stylesheetGrid.css">
    <link rel="stylesheet" type="text/css" href="/Cluk/css/cart.css">
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
  </head>

  <body>

    <?php
      include($_SERVER['DOCUMENT_ROOT'] . "/Cluk/html/header.html");
    ?>

    <?php
      include($_SERVER['DOCUMENT_ROOT'] . "/Cluk/html/sideBarManager.html");
    ?>  

    <div id="main">
      <div class="container">
        <div class="row">
          <div class="column-sm-4" id="search">
            <div class="form-inline active-green-3 active-green-4">
              <i class="fas fa-search" aria-hidden="true"></i>
              <input class="form-control" id="search-input" type="text" placeholder="Search" aria-label="Search">
              <span class="glyphicon glyphicon-search form-control-feedback" aria-hidden="true"></span>
            </div>
          </div>
        </div>
        <p id="dropdownMenus"></p>
        <script type="text/javascript" src="/Cluk/js/OrderList.js"></script>
      </div>
    </div>

  </body>

</html>