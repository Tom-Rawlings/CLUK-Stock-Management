<!DOCTYPE html>

<!--Page redirect if the user is not logged in -->
<?php
  require $_SERVER['DOCUMENT_ROOT'] . '/Cluk/php/admin/checkManager.php';
?>

<html>
<head> <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title>
CLUK Deliveries
</title>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<link rel="stylesheet" type="text/css" href="/Cluk/css/stylesheet.css">
<link rel="stylesheet" type="text/css" href="/Cluk/css/stylesheetDeliveriesList.css">
<!--<link rel="stylesheet" type="text/css" href="/Cluk/css/cart.css">-->
<link rel="stylesheet" type="text/css" href="/Cluk/css/footer.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" />
</head>


 <body>
  <?php
    include($_SERVER['DOCUMENT_ROOT'] . "/Cluk/html/header.html");
  ?> 
  <?php
    include($_SERVER['DOCUMENT_ROOT'] . "/Cluk/html/sideBarDriver.html");
  ?>  
  <div id=main>      
    <h4>CURRENT DELIVERY</h4>

    <div class="container-fluid">
      <div class="row">
        <div class="column-sm-4 input-group">
          <input class="form-control" type="text" id="search-input" placeholder="Search" aria-label="Search">
          <span class="input-group-append">
            <button class="btn btn-outline-secondary" type="button" id="search">
                <i class="fa fa-search"></i>
            </button>
          </span>
        </div>
      </div>
    </div>




    <table class="table table-sm table-striped">
      <thead class="thead-dark">
        <tr>
          <th scope="col">#</th>
          <th scope="col">Delivery ID</th>
          <th scope="col">Destination</th>
          <th scope="col">Date</th>
          <th scope="col">Items</th>
          <th scope="col">Map</th>
          <th scope="col">Status</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <th scope="row">1</th>
          <td>a111</td>
          <td>Alnwick Town Centre, 19 Lagny Street, Alnwick, NE66 1LA</td>
          <td>20-04-2019</td>
          <td>
            <button class= "cat" data-toggle="collapse" data-target="#chickStripes">Items</button>
            <div id="dropChick" class="collapse">
              <div class="item">
                <p class="d-inline-block">Chicken Strips</p>
              </div>
            </div>
          </td>
          <td><a href="file:///Users/lucrezialamanna/Desktop/CLUCK%20HTML/CLUK3.html#">Map</a></td>
          <td><button type="button" class="btn btn-warning">In Progress</button></td>
        </tr>
        <tr>
          <th scope="row">2</th>
          <td>a112</td>
          <td>Newton Aycliffe, 4 Northfield Way, Newton Aycliffe, DL5 6EJ<br> 
              Seaton Burn Services, Fisher Lane, Newcastle upon Tyne, NE13 6BP
          </td>
          <td>20-04-2019</td>
          <td>
            <button class= "cat" data-toggle="collapse" data-target="#chickStripes">Items</button>
            <div id="dropChick" class="collapse">
              <div class="item">
                <p class="d-inline-block">Chicken Strips</p>
              </div>
            </div>
          </td>
          <td><a href="file:///Users/lucrezialamanna/Desktop/CLUCK%20HTML/CLUK3.html#">Map</a></td>
          <td><button typle="button" class="btn btn-success">Delivered</button></td>
        </tr>
        <tr>
          <th scope="row">3</th>
          <td>a113</td>
          <td>Seaton Burn Services, Fisher Lane, Newcastle upon Tyne, NE13 6BP</td>
          <td>20-04-2019</td>
          <td>
            <button class= "cat" data-toggle="collapse" data-target="#chickStripes">Items</button>
            <div id="dropChick" class="collapse">
              <div class="item">
                <p class="d-inline-block">Chicken Strips</p>
              </div>
            </div>
          </td>
          <td><a href="file:///Users/lucrezialamanna/Desktop/CLUCK%20HTML/CLUK3.html#">Map</a></td>
          <td><button type="button" class="btn btn-warning">In Progress</button></td>
        </tr>
      </tbody>
    </table>
  </div>

  <?php
    include($_SERVER['DOCUMENT_ROOT'] . "/Cluk/html/Footer.html");
  ?>   

  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>

  </body>
</html>