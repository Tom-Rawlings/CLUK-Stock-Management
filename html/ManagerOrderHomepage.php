<?php
  /*Page redirect if the user is not logged in*/
  require $_SERVER['DOCUMENT_ROOT'] . '/Cluk/php/admin/checkManager.php';
?>

<!DOCTYPE html>

<html>

  <head> 
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>CLUK Deliveries</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="/Cluk/css/stylesheet.css">
    <link rel="stylesheet" type="text/css" href="/Cluk/css/managerHome.css">
    <link rel="stylesheet" type="text/css" href="/Cluk/css/stylesheetSidebar.css">
    <link rel="stylesheet" type="text/css" href="/Cluk/css/stylesheetGrid.css">
    <link rel="stylesheet" type="text/css" href="/Cluk/css/cart.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.8/css/all.css">
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

        <div class="container-fluid">
          <div class="row">
            <div class="column-sm-4 input-group" id="groupSearch">
              <input class="form-control" type="text" id="search-input" placeholder="Search" aria-label="Search"><span class="input-group-append">
                <button class="btn btn-outline-secondary" type="button" id="search">
                    <i class="fa fa-search"></i>
                </button>
              </span>
              <span class="input-group">
                <button id="modal-but" type="button" class="btn btn-success" data-toggle="modal" data-target="#fullHeightModalRight"><i class="fa fa-shopping-cart"></i></button>
                    </span>
            </div>
          </div>
        </div>

        <p id="dropdownMenus"></p>

        <script type="text/javascript" src="/Cluk/js/ManagerOrderHomepage.js"></script>

        <div class="modal fade right" id="fullHeightModalRight" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

          <!--Add class .modal-full-height and then add class .modal-right (or other classes from list above) to set a position to the modal -->
          <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="myModalHead">Order Cart</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <div class="row d-flex justify-content-center align-items-right" id="cart_body">
                  <div class="body">
                    <ul id="productsInCart">
                     <!-- products added to the cart will be inserted here using JavaScript -->
                    </ul>
                  </div>
                 
                </div>
                <div class="modal-footer justify-content-left">
                  <a id="cart-popover" class="btn" data-placement="bottom" title="Shopping Cart">
                    <span><i fa fa-shopping-cart></i> Order total:</span>
                    <span class="total_price" id="totalPriceLabel">£0.00</span>
                  </a>
                  <button type="button" id="confirm-button" class="btn btn-secondary btn3d" data-dismiss="modal" onClick="confirmOrder()">Confirm Order</button>
                  <button type="button" id="cancel-button" class="btn btn-secondary btn3d" data-dismiss="modal" onClick="cancelOrder()">Cancel Order</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php
      include($_SERVER['DOCUMENT_ROOT'] . "/Cluk/html/Footer.html");
    ?> 
  </body>
</html>        