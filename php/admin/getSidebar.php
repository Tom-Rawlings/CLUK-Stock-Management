<?php

  /*
    Gets the correct sidebar for the current users job type
  */

  require $_SERVER['DOCUMENT_ROOT'] . '/Cluk/php/admin/connect.php';

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
      header('Location: '. $_SERVER['DOCUMENT_ROOT'] . "/Cluk/html/index.php");
  }

?>