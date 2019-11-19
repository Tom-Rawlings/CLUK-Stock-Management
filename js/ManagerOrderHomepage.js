var totalPrice = 0.00;
var order = new Array();
var orderValues = new Array();
var ingredients = new Array();
var numberOfCategories = 0;
var queryErrorText = "There was an error querying the database.";
var categoryElementIds;
var categories;
var minimumOrder = 2;
var maximumOrder = 500;



$(document).ready(function(){

setupDropdownMenu();

});

function pageReady(){
  
  createAddButtonClickFunctions();

  for(var i = 0; i < ingredients.length; i++){
    console.log(`ingredient_id = ${ingredients[getIngredientIndexById(1)].ingredient_id} | name = ${ingredients[getIngredientIndexById(1)].name}`);
    console.log(`ingredient_id = ${ingredients[getIngredientIndexById(9)].ingredient_id} | name = ${ingredients[getIngredientIndexById(9)].name}`);

  }

}

function setupDropdownMenu(){
  
    $.ajax({
      type: "POST",
      url:"/Cluk/php/queries/getCategories.php",
      data: {},
      dataType: "json",
      success: function(rows){
        console.log(rows.length);
        numberOfCategories = rows.length;
        categoryElementIds = new Array(numberOfCategories);
        categories = new Array(numberOfCategories);
        var textToDisplay = "";
        $.each(rows, function(key, row){
          
          textToDisplay +=                 
            '<div class="row" >' +
              '<div class="column-sm-4">'+
                '<div class="dropdown">' + 
                  '<button class= "cat" data-toggle="collapse" data-target="#drop' + row.category+'"> '+row.category+' </button>' + 
                  '<div id="drop' + row.category+'" class="collapse">' +
                  '<p id="category' + key +'">' +
                '</p>' +
                  '</div>' + 
                '</div>' + 
              '</div>' + 
            '</div>' +
            '<hr>';
            categoryElementIds[key] = ("#category" + key);
            categories[key] = row.category;

        })
        $("#dropdownMenus").html(textToDisplay);    
        fillMenuBody(numberOfCategories, 0, 0);
      },
      error: function(){
          alert(queryErrorText);
      }
      

    });
    console.log("numberOfCategories at end of setupDropdownMenu = " + numberOfCategories);
    return numberOfCategories;
}


function fillMenuBody(numberOfCategories, counter, ingredientIndex){
  var category = categories[counter];
  $.ajax({
    type: "POST",
    url:"/Cluk/php/queries/getIngredientsByCategory.php",
    data: {category},
    dataType: "json",
    success: function(rows){
      var textToDisplay = '<table id="tableIngredients"><tr><th>Item</th><th>Price/Unit</th><th>Quantity</th><th>Units</th></tr>';//<p id="category_inner' + category +'">';                                        //class="d-inline-block"
      
      $.each(rows, function(key, row){
        buttonId = "addButton_" + row.ingredient_id;
        quantityFieldId = "quantityField_" + row.ingredient_id; 
        textToDisplay += 
              "<tr>" + "<td>" + row.name + "</td>" + "<td>" + row.price + "</td>" + "<td>" + row.unit_size + "</td>" + "<td>" + row.unit + "</td>" + 
              '<td><div class="input-group mb-3">' +
                '<input type="number" class="form-control" id="' + quantityFieldId + '" placeholder="quantity" aria-label="quantity" aria-describedby="basic-addon2">' +
                '<div class="input-group-append" id="but_grid">' +
                  '<button class="btn btn-outline-secondary" id="' + buttonId + '" type="button" data-toggle="modal" data-target="#fullHeightModalRight">Add Item</button>' +
                '</div>' +
              '</div></td>' +
             '</tr>';

        ingredients[ingredientIndex] = row;
        ingredientIndex++;

      })

      textToDisplay += "</table>";
      $(categoryElementIds[counter]).html(textToDisplay);

      counter++;
      if(counter < numberOfCategories){
        fillMenuBody(numberOfCategories, counter, ingredientIndex);
      }else{
        pageReady();
      }

    },
    error: function(){
      alert(queryErrorText);
    }
  });
  
}

  //This adds functions to the "Add Item" buttons after
function createAddButtonClickFunctions(){

  for(var i = 0; i < ingredients.length; i++){
    //Click function that will run when a quantity is added to the cart (add button clicked)
    $("#addButton_" + ingredients[i].ingredient_id).click(function(){
      var id = $(this).attr('id');
      //split string is the ingredient index at the end of the button ID.
      var splitString = id.split("_");
      var currentIngredientId = splitString[1];
      console.log(`currentIngredientId ${currentIngredientId}`);
      var quantity = document.getElementById("quantityField_" + currentIngredientId).value;
      var orderItem = null;

      if(quantity < minimumOrder || quantity > maximumOrder){
        alert(`Order quantities must be between ${minimumOrder} and ${maximumOrder}`);
        return;
      }

      for(var o in order){
        if(order[o].ingredient_id == currentIngredientId){
          orderItem = order[o];
          break;
        }
      }

      if(orderItem == null){
        var ingredientIndex = getIngredientIndexById(currentIngredientId);
        console.log(`currentIngredientId ${currentIngredientId} | ingredientIndex ${ingredientIndex}`);
        orderItem = {ingredient_id: currentIngredientId, ingredient_name : ingredients[ingredientIndex].name, ingredient_price: ingredients[ingredientIndex].price, ingredient_quantity: quantity, cartEntryId: "#cartEntry_" + currentIngredientId, textId: "#cartEntryText_" + currentIngredientId};
        console.log(`ingredients[ingredientIndex].name ${ingredients[ingredientIndex].name}`);
        order.push(orderItem);

        addCartEntry(ingredients[ingredientIndex].ingredient_id, quantity);
        rebuildCart();
         
     
      }else{
        orderItem.ingredient_quantity = quantity;
        $(orderItem.textId).html(orderItem.ingredient_name + " Quantity: " + orderItem.ingredient_quantity);
      }

      updateCartTotal();

    });
    
  }

}

function getIngredientIndexById(ingredientId){
  var indexToReturn = null;
  for(var i = 0; i < ingredients.length; i++){
    if(ingredients[i].ingredient_id == ingredientId){
      indexToReturn = i;
    }
  }
  return indexToReturn;
}

function addCartEntry(ingredientId, quantity){
  document.getElementById("productsInCart").innerHTML += "" + 
  `<li id="cartEntry_${ingredientId}" class="product">`+
  	`<div id="cartEntryText_${ingredientId}">`+
  		`${ingredients[getIngredientIndexById(ingredientId)].name} Quantity: ${quantity}`+
  	`</div>` + 
    `<div class="input-group" id="cart_input">`+
     `<span id="more" class="input-group-btn">`+
        `<button class="btn btn-success btn-number" id="more_but${ingredientId}" onClick="incrementCartItemQuantity(${ingredients[getIngredientIndexById(ingredientId)].ingredient_id})" type="button" data-type="plus" data-field="quant[2]">`+
          `&#10133;`+
        `</button>`+
      `</span>`+
     /* `<input type="text" class="form-control input-number" id="product_span" name="name" min="1">`+*/
      `<span id="less" class="input-group-btn>`+
        `<button class="btn btn-danger btn-number" id="less_but${ingredientId}" onClick="decrementCartItemQuantity(${ingredientId})" type="button" data-type="minus" data-field="quant[2]">`+
          `&#10134;`+
        `</button>`+
      `</span>`+
      `<span id="cancel" class="input-group-btn>`+
      `<button class="btn btn-outline-secondary" id="cancel_but${ingredientId}" onClick="removeCartItem(${ingredientId})" type="btn">`+
        `X`+
      `</button>`+
    `</div>`+
  `</li>`;
}

function rebuildCart(){
	$("#productsInCart").html("");
	for(var i = 0; i < order.length; i++){
		addCartEntry(order[i].ingredient_id, order[i].ingredient_quantity);
	}
  updateCartTotal();
}

function incrementCartItemQuantity(id){
  var orderIndex = findIngredientIndexInOrder(id);
  if(parseInt(order[orderIndex].ingredient_quantity) < maximumOrder){
    var quantity = parseInt(order[orderIndex].ingredient_quantity) + 1;
    console.log(`order[orderIndex].textId).html ${order[orderIndex].textId}`);
    $(order[orderIndex].textId).html(`${ingredients[getIngredientIndexById(id)].name} Quantity: ${quantity}`);
    order[orderIndex].ingredient_quantity = quantity;
  }else{
    alert(`The maximum order quantity is ${maximumOrder}`);
  }
  updateCartTotal();
}

function decrementCartItemQuantity(id){
  var orderIndex = findIngredientIndexInOrder(id);
  if(parseInt(order[orderIndex].ingredient_quantity) > minimumOrder){
    var quantity = parseInt(order[orderIndex].ingredient_quantity) - 1;
    console.log(`order[orderIndex].textId).html ${order[orderIndex].textId}`);
    $(order[orderIndex].textId).html(`${ingredients[getIngredientIndexById(id)].name} Quantity: ${quantity}`);
    order[orderIndex].ingredient_quantity = quantity;
  }else{
    alert(`The minimum order quantity is ${minimumOrder}`);
  }
  updateCartTotal();
}

function removeCartItem(id){
  id = findIngredientIndexInOrder(id);
  var removed = order.splice(id, 1);
  var outputText;
  for(var i = 0; i < removed.length; i++){
    outputText = "i=" + i + " - "+ removed[i].inredient_name + " | ";
  }
  console.log(`order.splice(${id},1) = ` + outputText);
  rebuildCart();
}

function cancelOrder(){
  order = new Array();
  rebuildCart();
}

function findIngredientIndexInOrder(ingredientId){
  var indexToReturn = null;
  for(var i = 0; i < order.length; i++){
    if(order[i].ingredient_id == ingredientId){
      indexToReturn = i;
    }
  }
  if(indexToReturn == null)
    console.log("indexToReturn = null");
  return indexToReturn;
}


function confirmOrder(){
  //$("#confirm-button")
  if(order.length == 0){
   alert("Cart is empty");
   return;
  }

  if(!confirm("Are you sure you want to confirm this order?")){
    return;
  }

  for(var i = 0; i < order.length; i++){
    var orderLineToAdd = [order[i].ingredient_id, order[i].ingredient_quantity];
    orderValues.push(orderLineToAdd);
  }


  $.ajax({
    type: "POST",
    url:"/Cluk/php/queries/addOrder.php",
    data: {orderValues},
    dataType: "text",
    success: function(order_id){
      var textToDisplay = "Your order ID is " + order_id;
      
      alert(textToDisplay);

    },
    error: function(){
      alert(queryErrorText + " (confirmOrder)");
    }
  });
  
}

function updateCartTotal(){
  totalPrice = 0;
  for(var o in order){
    totalPrice += order[o].ingredient_price * order[o].ingredient_quantity;
  }
  totalPrice = totalPrice.toFixed(2);
  $("#totalPriceLabel").html("£"+totalPrice);

}

function searchIngredients(searchString){
  console.log(searchString);
  $.ajax({
    type: "POST",
    url:"/Cluk/php/queries/searchIngredients.php",
    data: {searchString},
    dataType: "json",
    success: function(rows){
      var textToDisplay = 
            '<div class="row" >' +
              '<div class="column-sm-4">'+
                '<div class="dropdown">' + 
                  '<p id="category">' +
                  '</p>' +
                '</div>' + 
              '</div>' + 
            '</div>'
      $("#dropdownMenus").html(textToDisplay);
      textToDisplay = '<table><p class="d-inline-block" id="category_inner">';
      ingredients = new Array();
      $.each(rows, function(key, row){
        buttonId = "addButton_" + key;
        quantityFieldId = "quantityField_" + key; 
        textToDisplay += 
            "<tr>" + "<td>" + row.name + "</td>" + "<td>" + row.price + "</td>" + "<td>" + row.unit_size + "</td>" + "<td>" + row.unit + "</td>" + 
              '<td><div class="input-group mb-3">' +
                '<input type="number" class="form-control" id="' + quantityFieldId + '" placeholder="quantity" aria-label="quantity" aria-describedby="basic-addon2">' +
                '<div class="input-group-append">' +
                  '<button class="btn btn-outline-secondary" id="' + buttonId + '" type="button" data-toggle="modal" data-target="#fullHeightModalRight">Add Item</button>' +
                '</div>' +
              '</div></td>' +
              '</p></tr>';

        ingredients[key] = row;

      })

      textToDisplay += "</table>";
      $("#category").html(textToDisplay);
      pageReady();
    },
    error: function(){
      alert(queryErrorText + "(searchIngredients)");
    }
  });
}

document.getElementById('search-input').onkeydown = function(event) {
  if (event.keyCode == 13) {
    if($("#search-input").val() != "")
      searchIngredients($("#search-input").val());
    else
      setupDropdownMenu();
  }
}


$("#add").click(function(){
  var productId = $("#chick_pieces").val();
  
  var data = {
    'chick_pieces': productId,
    
  }
});