var queryErrorText = "There was an error querying the database.";
var rowNumber = 1;
var orders = new Array();
var orderIdsAdded = new Array();
var deliveryDate = "";

$(document).ready(function(){
  setup();
});

function setup(){
  orderIdsAdded = new Array();
  orders = new Array();
  fillOrderTable();
  getDrivers();
  rebuildOrderCart();
  dateDropdownSwitch();

  //dateTesting2();
}


function fillOrderTable(){
  rowNumber = 1;
  $.ajax({
    type: "POST",
    url:"/Cluk/php/queries/getOrdersAvailable.php",
    data: {},
    dataType: "json",
    success: function(rows){
      var textToDisplay = "";
      $.each(rows, function(key, row){
        
        textToDisplay +=     

          `<tr>` +
            `<th scope="row">${rowNumber}</th>` + 
            `<td>${row.order_id}</td>` +
            `<td>${row.line1}, ${row.line2}, ${row.city}, ${row.postcode}</td>` +
            `<td>${row.dateAndTime}</td>` +
            `<td>` +
              `<div class="dropdown">` +
                `<button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Items` +
                `</button>` +
                `<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">` +
                  `<ul id="itemsList${row.order_id}">` +
                  `</ul>` +
                `</div>` +
              `</div>` +
            `</td>` +
            `<td>` +
              `<button id="addBtn${row.order_id}" class="btn btn-secondary" data-toggle="modal" onClick="addOrder(${row.order_id})" data-target="#fullHeightModalRight">Add Order</button>` +
            `</td>` +
          `</tr>`;
          
          order = {order_id: row.order_id, line1: row.line1};
          orders.push(order);
          rowNumber++;

      })
      $("#order-table-body").html(textToDisplay);   
      fillItemsList(0); 

    },
    error: function(){
        alert(queryErrorText + " (fillOrderTable)");
    }
    

  });

}

function fillItemsList(loopCounter){
  var order_id = orders[loopCounter].order_id;
  $.ajax({
    type: "POST",
    url:"/Cluk/php/queries/getOrderIngredients.php",
    data: {order_id},
    dataType: "json",
    success: function(rows){
      
      var textToDisplay = "";
      $.each(rows, function(key, row){
        
        textToDisplay +=     
          `<li>${row.name}: ${row.quantity}</li>`;          

      })
      $("#itemsList" + order_id).html(textToDisplay);
      loopCounter++;

      if(loopCounter < orders.length){
        fillItemsList(loopCounter);
      }

    },
    error: function(){
        alert(queryErrorText + " (fillItemsList)");
    }
    

  });

}


function addOrder(order_id){
  if(orderIdsAdded.includes(order_id)){
    $("#addBtn" + order_id).hide();
  }else{
    orderIdsAdded.push(order_id);
    $("#addBtn" + order_id).hide();
    rebuildOrderCart();
  }
}

function removeOrderFromCart(order_id){
  var indexToRemove = 0;
  for(var i = 0; i < orderIdsAdded.length; i++){
    if(orderIdsAdded[i] == order_id){
      indexToRemove = i;
      break;
    }
  }
  orderIdsAdded.splice(indexToRemove, 1);
  rebuildOrderCart();
  $("#addBtn" + order_id).show();
}

function rebuildOrderCart(){
  var textToDisplay = "";
  for(var i = 0; i < orderIdsAdded.length; i++){
    var orderIndex = findOrderIndexById(orderIdsAdded[i]);
    textToDisplay+=
    `<li>`+
        `Order ID: ${orders[orderIndex].order_id} | Destination: ${orders[orderIndex].line1} `+
        `<input type="button" value="Remove" onClick="removeOrderFromCart(${orders[orderIndex].order_id})">`+
    `</li>`;
  }
  $("#ordersInCart").html(textToDisplay);
  $("#totalOrdersLabel").html(orderIdsAdded.length);
}

function findOrderIndexById(order_id){
  var indexToReturn = 0;
  for(var i = 0; i < orders.length; i++){
    if(orders[i].order_id == order_id){
      indexToReturn = i;
      break;
    }
  }
  return indexToReturn;
}

function cancelOrder(){
  setup();
}


function getDrivers(){
  $.ajax({
    type: "POST",
    url:"/Cluk/php/queries/getDriversAvailable.php",
    data: {},
    dataType: "json",
    success: function(rows){
      
      var textToDisplay = "";
      $.each(rows, function(key, row){
        
        textToDisplay += `<label><input type="radio" name="driver" value="${row.staff_id}">Driver ${row.staff_id}</label><br>`;

      })
      $("#driver-list").html(textToDisplay);

    },
    error: function(){
        alert(queryErrorText + " (getDrivers)");
    }
    
  });
}

function dateDropdown(){
  var date1 = new Date();
  var date2 = new Date();
  console.log(`Today = ${date1.getUTCDay()}`);
  daysOfTheWeek = ["sunday", "monday", "tuesday", "wednesday", "thursday", "friday", "saturday"];

  var i = date1.getUTCDay();
  date1 = findFutureDate(((1-i <= 0) ? 7+(1-i) : (1-i)));
  date2 = findFutureDate(((4-i <= 0) ? 7+(4-i) : (4-i)));

  console.log(`day of the week = ${daysOfTheWeek[i]}`);
  console.log(`date1 = `+ daysOfTheWeek[date1.getUTCDay()]);
  console.log(`date2 = `+ daysOfTheWeek[date2.getUTCDay()]);

  var month = (date1.getMonth()+1 < 10) ? "0"+(date1.getMonth()+1) : "" + (date1.getMonth()+1);
  var day = (date1.getDate() < 10) ? "0"+(date1.getDate()) : "" + (date1.getDate());
  var date1String = `${date1.getFullYear()}-${month}-${day}`;

  month = (date2.getMonth()+1 < 10) ? "0"+(date2.getMonth()+1) : "" + (date2.getMonth()+1);
  day = (date2.getDate() < 10) ? "0"+(date2.getDate()) : "" + (date2.getDate());
  var date2String = `${date2.getFullYear()}-${month}-${day}`;

  var textToDisplay =
    `<option name="dateDropdown" label="${date1.toDateString()}" value="${date1String}">${date1.getDate()}</option>` +
    `<option name="dateDropdown" label="${date2.toDateString()}" value="${date2String}">${date2.getDate()}</option>`;
  
  $("#date-list").html(textToDisplay);

  console.log(date1.toDateString());
  console.log(date1String);
  console.log(date2String);

}


function dateDropdownSwitch(){
  var date1 = new Date();
  var date2 = new Date();
    daysOfTheWeek = ["sunday", "monday", "tuesday", "wednesday", "thursday", "friday", "saturday"];
  console.log(`Today = ${date1.getUTCDay()}`);

  switch(date1.getUTCDay()){
    case 0:
      date1 = findFutureDate(1);
      date2 = findFutureDate(4);
      break;
    case 1:
      date1 = findFutureDate(3);
      date2 = findFutureDate(7);
      break;
    case 2:
        date1 = findFutureDate(2);
        date2 = findFutureDate(6);
      break;
    case 3:
        date1 = findFutureDate(1);
        date2 = findFutureDate(5);
      break;
    case 4:
        date1 = findFutureDate(4);
        date2 = findFutureDate(7);
      break;
    case 5:
        date1 = findFutureDate(3);
        date2 = findFutureDate(6);
      break;
    case 6:
        date1 = findFutureDate(2);
        date2 = findFutureDate(5);
      break;
  }

  var month = (date1.getMonth()+1 < 10) ? "0"+(date1.getMonth()+1) : "" + (date1.getMonth()+1);
  var day = (date1.getDate() < 10) ? "0"+(date1.getDate()) : "" + (date1.getDate());
  var date1String = `${date1.getFullYear()}-${month}-${day}`;

  month = (date2.getMonth()+1 < 10) ? "0"+(date2.getMonth()+1) : "" + (date2.getMonth()+1);
  day = (date2.getDate() < 10) ? "0"+(date2.getDate()) : "" + (date2.getDate());
  var date2String = `${date2.getFullYear()}-${month}-${day}`;

  var textToDisplay =
    `<option name="dateDropdown" label="${date1.toDateString()}" value="${date1String}">${date1.getDate()}</option>` +
    `<option name="dateDropdown" label="${date2.toDateString()}" value="${date2String}">${date2.getDate()}</option>`;
  
  $("#date-list").html(textToDisplay);

  console.log(date1.toDateString());
  console.log(date1String);
  console.log(date2String);

}

function dateTesting(){
  var date1 = new Date();
  var date2 = new Date();
  console.log(`Today = ${date1.getUTCDay()}`);
  daysOfTheWeek = ["sunday", "monday", "tuesday", "wednesday", "thursday", "friday", "saturday"];
  offset = [4,5,6,0,1,2,3];
  for(var i = 0; i < daysOfTheWeek.length; i++){
      switch(i){
      case 0:
        date1 = findFutureDate(1 + offset[i]);
        date2 = findFutureDate(4 + offset[i]);
        break;
      case 1:
        date1 = findFutureDate(3 + offset[i]);
        date2 = findFutureDate(7 + offset[i]);
        break;
      case 2:
          date1 = findFutureDate(2 + offset[i]);
          date2 = findFutureDate(6 + offset[i]);
        break;
      case 3:
          date1 = findFutureDate(1 + offset[i]);
          date2 = findFutureDate(5 + offset[i]);
        break;
      case 4:
          date1 = findFutureDate(4 + offset[i]);
          date2 = findFutureDate(7 + offset[i]);
        break;
      case 5:
          date1 = findFutureDate(3 + offset[i]);
          date2 = findFutureDate(6 + offset[i]);
        break;
      case 6:
          date1 = findFutureDate(2 + offset[i]);
          date2 = findFutureDate(5 + offset[i]);
        break;

    }
      console.log(`day of the week = ${daysOfTheWeek[i]}`);
      console.log(`date1 = `+ daysOfTheWeek[date1.getUTCDay()]);
      console.log(`date2 = `+ daysOfTheWeek[date2.getUTCDay()]);
  }

}

function dateTesting2(){
  var date1 = new Date();
  var date2 = new Date();
  var currentDay = date1.getUTCDay();
  console.log(`Today = ${currentDay}`);
  daysOfTheWeek = ["sunday", "monday", "tuesday", "wednesday", "thursday", "friday", "saturday"];
  offset = [3,4,5,6,0,1,2];
  console.log("-------------dateTesting2-------------");
  for(var i = 0; i < daysOfTheWeek.length; i++){

      date1 = findFutureDate(((1-i < 0) ? 7+(1-i) : (1-i))  + offset[currentDay]);
      date2 = findFutureDate(((4-i < 0) ? 7+(4-i) : (4-i)) + offset[currentDay]);

      console.log(`day of the week = ${daysOfTheWeek[i]}`);
      console.log(`date1 = `+ daysOfTheWeek[date1.getUTCDay()]);
      console.log(`date2 = `+ daysOfTheWeek[date2.getUTCDay()]);
  }
  console.log("-------------------------------------");
}


function findFutureDate(daysAhead) {
  var date = new Date();
  date.setDate(date.getDate() + daysAhead);
  return date;
}

function confirmOrder(){
  //Perform validation
  var valid = true;
  if(orderIdsAdded.length < 1){
    alert("There are no orders in the delivery");
    valid = false;
  }
  if($("input[name='driver']:checked").val() == null){
    alert("There is no driver selected");
    valid = false;
  }else{
    console.log($("input[name='driver']:checked").val());
  }
  if(valid){
    addDelivery($("option[name='dateDropdown']:selected").val(), $("input[name='driver']:checked").val());
  }
  console.log("Selected Date = " +$("option[name='dateDropdown']:selected").val());
}


function addDelivery(date, driver_id){
  console.log(`date = ${date}`);
  $.ajax({
    type: "POST",
    url:"/Cluk/php/queries/addDelivery.php",
    data: {date:date, orders:orderIdsAdded, driver_id:driver_id},
    dataType: "text",
    success: function(delivery_id){
      
      console.log(`delivery add: ${delivery_id}`);

    },
    error: function(){
        alert(queryErrorText + " (addDelivery)");
    }
    
  });
}