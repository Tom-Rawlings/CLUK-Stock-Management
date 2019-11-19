var queryErrorText = "There was an error querying the database.";
var delivery_id;
var directionsService;
var directionsDisplay;
var warehouseAddress;
var orders = new Array();
var calculatedRoute = new Array();
var routeCounter = 0;
var numberOfOrdersLeftToDeliver = 0;

$(document).ready(function(){
  
});


function getCurrentDelivery(){
  $.ajax({
    type: "POST",
    url:"/Cluk/php/queries/getDeliveryId.php",
    data: {},
    dataType: "json",
    success: function(rows){
        var textToDisplay = '';
        if(rows.length > 0){
          delivery_id = rows[0].delivery_id;

          checkDriverHasDelivery();
        }else{
          console.log(`No delivery_id returned`);
        }

    },
    error: function(){
        alert(queryErrorText + "(getDeliveryId)");
    }
  });

}

/*


CHECK IF DELIVERY_ID ==NULL


*/
function checkDriverHasDelivery(){
  $.ajax({
    type: "POST",
    url:"/Cluk/php/queries/checkDriverHasDelivery.php",
    data: {delivery_id},
    success: function(hasDelivery){
      console.log(`hasDelivery = ${hasDelivery}`);
      if(!hasDelivery){
        console.log("Driver has no delivery assigned currently");
        $("#orders").html("<h3>You currently have no delivery assigned.</h3>");
        return;
      }
      console.log(`Driver has delivery ${delivery_id}. hasDelivery = ${hasDelivery}`);
      getDestinationsFromDelivery(delivery_id);
      getOrdersFromDelivery(delivery_id);
    },
    error: function(){
        alert(queryErrorText + "(checkDriverHasDelivery)");
    }
  });
}

function getOrderAddress(counter){
  var order_id = orders[counter];
  counter++;
    $.ajax({
    type: "POST",
    url:"/Cluk/php/queries/getOrderAddress.php",
    data: {order_id},
    dataType: "json",
    success: function(rows){

      $(`#address${order_id}`).html(`${rows[0].line1}, ${rows[0].line2}`);
      if(counter < orders.length){
        getOrderAddress(counter);
      }
    },
    error: function(){
        alert(queryErrorText + "(getOrderAddress)");
    }
  });
}

function getDestinationsFromDelivery(delivery_id){
  $.ajax({
    type: "POST",
    url:"/Cluk/php/queries/getDestinationsFromDelivery.php",
    data: {delivery_id},
    dataType: "json",
    success: function(rows){
      var textToDisplay = '';
      var waypts = new Array();
      $.each(rows, function(key, row){
        //var coordinates =  new google.maps.LatLng(row.lat, row.long);
        var coordinates = row.line1 + "," + row.line2;
        waypts.push({
          location: coordinates,
          stopover: true
        });
      });
      calculateAndDisplayRoute(waypts);

      },
      error: function(){
          alert(queryErrorText + "(getDestinationsFromDelivery)");
      }
  });

}

function getOrdersFromDelivery(delivery_id){
  $.ajax({
    type: "POST",
    url:"/Cluk/php/queries/getOrderInfoFromDelivery.php",
    data: {delivery_id},
    dataType: "json",
    success: function(rows){
      var textToDisplay = '';
      $.each(rows, function(key, row){
        textToDisplay += `<h3>Order ${row.order_id} -> <span id="address${row.order_id}"></span>`;
        if(row.status == "Dispatched") {
          textToDisplay+=
          `<input type="button" id="arrivedBttn${row.order_id}" value="Mark as Arrived" onClick="setAsArrived(${row.order_id})">`;
          numberOfOrdersLeftToDeliver++;
        }
        else textToDisplay+=` - Arrived`;
      textToDisplay+= `</h3><div id="order${row.order_id}"></div><br/>`;
        orders.push(row.order_id);
      });
      if(numberOfOrdersLeftToDeliver == 0){
        $("#finishDelivery").html(`<input type="button" id="finishButton" onClick="finishDelivery()" value="Delivery Finished">`);
      }
      $("#orders").html(textToDisplay);
      getOrderAddress(0);
      getOrderIngredients(0);
    },
    error: function(){
        alert(queryErrorText + "(getOrdersFromDelivery)");
    }
  });
}

function getOrderIngredients(counter){
  var order_id = orders[counter];
  $.ajax({
    type: "POST",
    url:"/Cluk/php/queries/getOrderIngredients.php",
    data: {order_id},
    dataType: "json",
    success: function(rows){
      var textToDisplay = ``;
      $.each(rows, function(key, row){
        textToDisplay += `${row.name} : ${row.quantity}<br/>`;

      });
      $(`#order${order_id}`).html(textToDisplay);

      if(counter < orders.length-1){
        counter++;
        getOrderIngredients(counter);
      }

    },
    error: function(){
        alert(queryErrorText + "(getOrderIngredients)");
    }
  });
}

function callback(response, status) {
  // See Parsing the Results for
  // the basics of a callback function.
  for(var i = 0; i < response.rows.length; i++){
    var timeSeconds = response.rows[i].elements[i].duration.value;
    var timeMinutes = timeSeconds / 60;
    var timeHours = timeMinutes / 60;
    print(`Journey leg ${i} `+ timeHours);
  }
}

function print(message){
  $("#message").html($("#message").html() + message);
}


function initMap(){
  directionsService = new google.maps.DirectionsService;
  directionsDisplay = new google.maps.DirectionsRenderer;
  var map = new google.maps.Map(document.getElementById('map'), {
    zoom: 10,
    center: {lat: 54.859386, lng: -1.574098} //Chester-le-Street
   });

  directionsDisplay.setMap(map);

  getWarehouseInfo();
  

}

  function getWarehouseInfo(){
    $.ajax({
    type: "POST",
    url:"/Cluk/php/queries/getWarehouseInfo.php",
    data: {},
    dataType: "json",
    success: function(rows){
      getWarehouseAddress(rows[0].address_id);

      },
      error: function(){
          alert(queryErrorText + "(getWarehouseInfo)");
      }
  });

  }

function getWarehouseAddress(address_id){
  $.ajax({
    type: "POST",
    url:"/Cluk/php/queries/getAddress.php",
    data: {address_id},
    dataType: "json",
    success: function(rows){

      warehouseAddress = rows[0];
      getCurrentDelivery();
    },
    error: function(){
        alert(queryErrorText + "(getAddress)");
    }
  });
}

function calculateAndDisplayRoute(waypts) {

  directionsService.route({
    origin: warehouseAddress.line1 + "," + warehouseAddress.line2,
    destination: warehouseAddress.line1 + "," + warehouseAddress.line2,
    waypoints: waypts,
    optimizeWaypoints: true,
    travelMode: 'DRIVING'
  }, function(response, status) {
    if (status === 'OK') {
      directionsDisplay.setDirections(response);
      var route = response.routes[0];
      var summaryPanel = document.getElementById('directions-panel');
      summaryPanel.innerHTML = '';
      // For each route, display summary information.
      for (var i = 0; i < route.legs.length; i++) {
        var routeSegment = i + 1;
        summaryPanel.innerHTML += '<b>Route Segment: ' + routeSegment +
            '</b><br>';
        summaryPanel.innerHTML += route.legs[i].start_address + ' ---> ';
        summaryPanel.innerHTML += route.legs[i].end_address + '<br>';
        summaryPanel.innerHTML += route.legs[i].duration.text + '<br>';
        summaryPanel.innerHTML += route.legs[i].distance.text + '<br><br>';
        console.log(`route.legs[${i}].start_address = ${route.legs[i].start_address}`);
        console.log(`route.legs[${i}].end_address = ${route.legs[i].end_address}`);
        calculatedRoute.push(route.legs[i]);
      }
      checkForDeliverySchedule();
    } else {
      window.alert('Directions request failed due to ' + status);
    }
  });
}

function callback(response, status) {

}


function setAsArrived(order_id){
  if(!confirm(`Are you sure you want to mark order ${order_id} as Arrived?`)){
    return;
  }
  numberOfOrdersLeftToDeliver--;
  if(numberOfOrdersLeftToDeliver <= 0){
    $("#finishDelivery").html(`<input type="button" id="finishButton" onClick="finishDelivery()" value="Delivery Finished">`);
  }
  $.ajax({
    type: "POST",
    url:"/Cluk/php/queries/setAsArrived.php",
    data: {order_id},
    success: function(){
      $(`#arrivedBttn${order_id}`).hide();
    },
    error: function(){
        alert(queryErrorText + "(setAsArrived)");
    }
  });
}

function getAddressIds(){
  var routeLeg = calculatedRoute[routeCounter];

  var start_address;
  var end_address;
  var splitArray = routeLeg.start_address.split(",");
  var postcode = splitArray[splitArray.length-2];
  var postcodeStartIndex;
  var spacesCounted = 0;
  for(var i = postcode.length-1; i > 0; i--){
    if(postcode[i] == ' '){
      spacesCounted++;
      if(spacesCounted == 2){
        postcodeStartIndex = i;
        break;
      }
    }
  }
  var startPostcode = postcode.substring(postcodeStartIndex+1);

  var splitArray = routeLeg.end_address.split(",");
  var postcode = splitArray[splitArray.length-2];
  var postcodeStartIndex;
  var spacesCounted = 0;
  for(var i = postcode.length-1; i > 0; i--){
    if(postcode[i] == ' '){
      spacesCounted++;
      if(spacesCounted == 2){
        postcodeStartIndex = i;
        break;
      }
    }
  }
  var endPostcode = postcode.substring(postcodeStartIndex+1);
  console.log(`startpostcode = ${startPostcode} | endPostcode = ${endPostcode}`);
  if(startPostcode == "DH2 1SS"){
    startPostcode = "DH2 1AB";
  }
  if(endPostcode == "DH2 1SS"){
    endPostcode = "DH2 1AB";
  }

  getStartAddressIdByPostcode(startPostcode, endPostcode, routeLeg.duration.value);

}

function checkForDeliverySchedule(){
    $.ajax({
    type: "POST",
    url:"/Cluk/php/queries/checkForDeliverySchedule.php",
    data: {delivery_id},
    success: function(result){
      if(result){
        return;
      }else{
        getAddressIds();
      }
    },
    error: function(){
        alert(queryErrorText + "(checkForDeliverySchedule)");
    }
  });
}

function getStartAddressIdByPostcode(startPostcode, endPostcode, time){
  console.log("startPostcode = " +  startPostcode);
  var postcode = startPostcode;
  $.ajax({
    type: "POST",
    url:"/Cluk/php/queries/getAddressIdByPostcode.php",
    data: {postcode},
    dataType: "json",
    success: function(rows){
      var startAddressId = rows[0].address_id;
      getEndAddressIdByPostcode(startAddressId, endPostcode, time);
    },
    error: function(){
        alert(queryErrorText + "(startAddress)");
    }
  });
}

function getEndAddressIdByPostcode(startAddressId, endPostcode, time){
  var postcode = endPostcode;

  $.ajax({
    type: "POST",
    url:"/Cluk/php/queries/getAddressIdByPostcode.php",
    data: {postcode},
    dataType: "json",
    success: function(rows){
      var endAddressId = rows[0].address_id;
      addSchedule(startAddressId, endAddressId, time);
    },
    error: function(){
        alert(queryErrorText + "(endAddress)");
    }
  });
}  


function addSchedule(startAddressId, endAddressId, time){
  var timeInMins = time/60;
  console.log(`startAddressId = ${startAddressId}, endAddressId = ${endAddressId}, time = ${timeInMins}`);

  $.ajax({
    type: "POST",
    url:"/Cluk/php/queries/addSchedule.php",
    data: {startAddressId: startAddressId, endAddressId: endAddressId, timeInMins: timeInMins, delivery_id: delivery_id},
    success: function(result){
      routeCounter++;
      console.log(`final result ${result}`);
      if(routeCounter < calculatedRoute.length){
        getAddressIds();
      }
    },
    error: function(){
        alert(queryErrorText + "(endAddress)");
    }

  });
}

function finishDelivery(){
  if(!confirm("Are you sure you want to finish the delivery?")){
    return;
  }
  $("#finishButton").hide();
  $.ajax({
    type: "POST",
    url:"/Cluk/php/queries/setDeliveryDelivered.php",
    data: {delivery_id},
    success: function(){
      console.log(`delivery ${delivery_id} delivered`);
    },
    error: function(){
        alert(queryErrorText + "(setDeliveryDelivered)");
    }

  });
}
