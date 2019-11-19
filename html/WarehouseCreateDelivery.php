<!DOCTYPE html>
<html>

  <head> 

    <!--<link rel="shortcut icon" href="/Cluk/favicon.ico" />-->

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>CLUK Deliveries</title>
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="/Cluk/css/stylesheet.css">
    <link rel="stylesheet" type="text/css" href="/Cluk/css/WarehouseCreateDeliveries.css">
    <link rel="stylesheet" type="text/css" href="/Cluk/css/stylesheetSidebar.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
  </head>

  <body>

    <?php
        include($_SERVER['DOCUMENT_ROOT'] . "/Cluk/html/header.html");
      ?> 

    <div id="main">
      <?php
        include($_SERVER['DOCUMENT_ROOT'] . "/Cluk/html/sideBarWarehouse.html");
      ?> 
      <h4>CREATE A DELIVERY</h4>
      <div class="container-fluid">
        <div class="row">
          <div class="column-sm-4 input-group">
            <input class="form-control" type="text" id="search-input" placeholder="Search" aria-label="Search"><span class="input-group-append">
              <button class="btn btn-outline-secondary" type="button" id="search">
            <i class="fa fa-search" aria-hidden="true"></i>
            </button>
            </span>
              <span class="input-group btn">
			          <button id="modal-but" type="button" class="btn btn-success" data-toggle="modal" data-target="#fullHeightModalRight">Deliveries</button>
              </span>
          </div>
        </div>
      </div>
        
      <table class="table table-sm table-striped">
        <thead class="thead-dark">
          <tr>
            <th scope="col">#</th>
            <th scope="col">Order No.</th>
            <th scope="col">Destination</th>
            <th scope="col">Date</th>
            <th scope="col">Items</th>
            <th scope="col">Add to Delivery</th>
          </tr>
        </thead>
        <tbody id="order-table-body">
          <script src="/Cluk/js/WarehouseCreateDelivery.js"></script>
        </tbody>
      </table>

      <div class="modal fade right" id="fullHeightModalRight" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <!--Add class .modal-full-height and then add class .modal-right (or other classes from list above) to set a position to the modal -->
        <div class="modal-dialog modal-md" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="myModalLabel">Create a Delivery</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="row d-flex justify-content-right align-items-right">
                <div class="body">
                  <ul id="ordersInCart">
                   <!-- orders added to the cart will be inserted here using JavaScript -->
                  </ul>
                </div>
                <div class="container" id="#deliveryDet">
                  <div class="row">
                    <div class="column-sm-4">
                      <div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButtonDrivers" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          Select Driver
                        </button> 
                        <div id="driver-list" class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                          <!--Available Drivers shows here using Javascript-->
                        </div>
                      </div>
                    </div>
                    <br>
                    <div class="column-sm-4">
                      <div class="date">
                        <div class="start_date input-group mb-4">
                          <!--<input class="datepicker" type="date" placeholder="select delivery date" id="deliverydate_datepicker">-->
                            <select class="datepicker" id="date-list">
                              <!--Available delivery dates are shown here using Javascript-->
                            </select>
                          <div class="input-group-append">
                            <span class="fa fa-calendar input-group-text delivery_date_calendar" aria-hidden="true "></span>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div> 
            <div class="modal-footer justify-content-left">
              <a id="cart-popover" class="btn" data-placement="bottom" title="Deliveries Cart">
                <span class="glyphicon glyphicon-shopping-cart"></span>
                <span class="badge"></span>
                Total Orders: 
                <span class="total_orders" id="totalOrdersLabel">0</span>
              </a>
              <button type="button" id="confirm-button" class="btn btn-secondary btn3d" data-dismiss="modal" onClick="confirmOrder()">Confirm Delivery</button>
              <button type="button" id="cancel-button" class="btn btn-secondary btn3d" data-dismiss="modal" onClick="cancelOrder()">Cancel Delivery</button>
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