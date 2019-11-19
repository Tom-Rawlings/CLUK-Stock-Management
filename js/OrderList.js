var listheight = 3;
 var Tid;
    
function clickList(Tid){
    var iSpread;
    var Thebtn = document.getElementById(Tid);
    var OLinfoBox = Thebtn.parentNode;
        var OrderTitle = OLinfoBox.parentNode;
    var ArrowBtn = OLinfoBox.firstChild;
    var line = OrderTitle.nextSibling;
    var spread = line.nextSibling;
    var height = spread.scrollHeight;
    this.disabled = 'disabled'; 
    
    var SpreadStyle = window.getComputedStyle(spread,null);
    var StyleHeight = SpreadStyle.height;
    var HeightNumber = StyleHeight.replace("px","");
        var HeightNumber = parseInt(HeightNumber);

    if(HeightNumber <= 2){
      iSpread = false;
    }else{
      iSpread = true;
    }
    
    if(!iSpread){
    var i = 0;
    var timer = setInterval(function(){
      i = i + listheight;
      spread.style.height = i + 'px';
      if(parseInt(spread.style.height) >= height){
        clearTimeout(timer);
      }
    },5);
    ArrowBtn.innerHTML = '∨';
    this.disabled = '';
    }else{
    var i = height;
    var timer = setInterval(function(){
      i = i - listheight;
      spread.style.height = i + 'px';
      if(i < 0){
        clearTimeout(timer);
      }
    },5);
    ArrowBtn.innerHTML = '>';
    this.disabled = '';
    }
  }
      
var numberOfOrders = 0;
var queryErrorText = "There was an error querying the database.";
var orderElementIds;
var orderId;

$(document).ready(function(){

getOrders();

});

function getOrders(){
  var rows;

  $.ajax({
    type: "POST",
    //url:"/Cluk/php/queries/getIngredients.php",
    url:"/Cluk/php/queries/getOrderInfo.php",
    data: {},
    dataType: "json",
    success: function(rows){
      setupDropdownMenu(rows);
    },
    error: function(){
        alert(queryErrorText + "(getOrders)");
    }
    

  });

}

function setupDropdownMenu(rows){
  
  console.log(rows.length);
  numberOfOrders = rows.length;
  orderElementIds = new Array(numberOfOrders);
  orderId = new Array(numberOfOrders);
  var textToDisplay = "";
  $.each(rows, function(key, row){
    
    textToDisplay +=
    '<div class = "OrderLine">'+
    '<div class="OrderTitle">'+
            '<div class = "OLinfoBox">'+
                '<button class="arrowbutton" id="ABtn'+row.order_id+'" onclick="clickList(this.id)"> > </button>'+
                '<button class="barbutton" id="BBtn'+row.order_id+'" onclick="clickList(this.id)">'+
            '<span class="OLID" id="Nid'+row.order_id+'">'+row.order_id+'</span>'+
            '<span class="OLTimeNDate" id="TD'+row.order_id+'">'+row.dateAndTime+'</span>'+
            '<span class="OLStatus" id="S'+row.order_id+'">'+ row.status +'</span>'+
                '</button>'+
            '</div>'+
            '<div class = "OLbtnBox">';
                if(row.status == "Arrived") textToDisplay+=
                `<button class="OLbtnGreen" id="M$${row.order_id}" onClick="markOrderAsDelivered(${row.order_id})">Received</button>`;
                //'<button class="OLbtnRed" id="C'+row.order_id+'">Cancel</button>'+
                textToDisplay+=
            '</div>'+
    '</div>'+
    '<hr class = "titleLine">'+
    '<div class = "OLspread" id="'+key+'"></div>'+
  '</div>';
      orderElementIds[key] = ("#" + key);
      orderId[key] = row.order_id;

  })

  $("#dropdownMenus").html(textToDisplay);
  fillDropdownContents(0);

}

function fillDropdownContents(counter){
  var order_id = orderId[counter];
  $.ajax({
    type: "POST",
    //url:"/Cluk/php/queries/getIngredients.php",
    url:"/Cluk/php/queries/getOrderForCurrentRestaurant.php",
    data: {order_id},
    dataType: "json",
    success: function(rows){
      var textToDisplay = '<table>';
      textToDisplay += '<tr><th class = "scrollI">Ingredient</th><th class = "scrollQ">Quantity</th><th class = "scrollC">Category</th></tr>';
      
      $.each(rows, function(key, row){
        textToDisplay += '<tr><td class = "scrollI">' + row.name + '</td><td class = "scrollQ">' + row.quantity + '</td><td class = "scrollC">' + row.category + '</td></tr>';
      })

      textToDisplay += '</table>';
      textToDisplay += '<hr class = "titleLine">';
      $(orderElementIds[counter]).html(textToDisplay);

      counter++;
      if(counter < numberOfOrders){
        fillDropdownContents(counter);
      }
    },
    error: function(){
      alert(queryErrorText + "(fillDropdownContents)");
    }
  });
  
}

function searchOrdersInDatabase(searchString){
  $.ajax({
    type: "POST",
    //url:"/Cluk/php/queries/getIngredients.php",
    url:"/Cluk/php/queries/searchOrders.php",
    data: {searchString},
    dataType: "json",
    success: function(rows){
      if(rows.length > 0)
        setupDropdownMenu(rows);
      else
        $("#dropdownMenus").html("No orders to show.");
    },
    error: function(){
        alert(queryErrorText + "(searchOrdersInDatabase)");
    }
    

  });
}


function markOrderAsDelivered(order_id){
    if(!confirm("Are you sure you want to mark this order as delivered?")){
      return;
    }
    $.ajax({
    type: "POST",
    //url:"/Cluk/php/queries/getIngredients.php",
    url:"/Cluk/php/queries/setAsDelivered.php",
    data: {order_id},
    success: function(){
      console.log(`set order ${order_id} to delivered`);
      getIngredientsAndQuantities(order_id);
    },
    error: function(){
        alert(queryErrorText + "(setAsDelivered)");
    }
  
  });
}

function getIngredientsAndQuantities(order_id){
  console.log(`trying to increase stock`);
  $.ajax({
    type: "POST",
    url:"/Cluk/php/queries/getOrderIngredientsAndQuantities.php",
    data: {order_id},
    dataType: "json",
    success: function(rows){
      console.log(`got dem  quantities yooo`);
      updateIngredientStockQuantity(rows, 0);
      
    },
    error: function(){
      alert(queryErrorText + "(getOrderIngredientsAndQuantities)");
    }
  });
  
}

function updateIngredientStockQuantity(ingredients, counter){
    var ingredient_id = ingredients[counter].ingredient_id;
    var quantity = ingredients[counter].quantity;
    $.ajax({
    type: "POST",
    url:"/Cluk/php/queries/addIngredientQuantityToStock.php",
    data: {ingredient_id: ingredient_id, quantity: quantity},
    success: function(){

      console.log(`added ${quantity} of ingredient${ingredient_id} to stock`);

      counter++;
      if(counter < ingredients.length){
        updateIngredientStockQuantity(ingredients, counter);
      }else{
        getOrders();
      }
    },
    error: function(){
      alert(queryErrorText + "(addIngredientQuantityToStock)");
    }
  });
}

document.getElementById('search-input').onkeydown = function(event) {
  if (event.keyCode == 13) {
    if($("#search-input").val() != "")
      searchOrdersInDatabase($("#search-input").val());
    else
      getOrders();
  }
}
