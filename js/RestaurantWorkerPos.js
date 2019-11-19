var queryErrorText = "There was an error querying the database.";
var meals = new Array();
var numberOfCartItems = 0;
var orderMealIds = new Array();
var orderMealQuantities = new Array();
var orderMealPrices = new Array();
var mealsAvailable = new Array();
var cartTotalPrice = 0.00;



$(document).ready(function(){
  console.log("ready");

  getMealItems();


});

function getMealItems(){
    $.ajax({
    type: "POST",
    url:"/Cluk/php/queries/getMealItems.php",
    data: {},
    dataType: "json",
    success: function(result){
      var htmlToAdd = "<table><tr>";
      var counter = 0;
      $.each(result, function(key, row){
        meals.push(row);
        htmlToAdd += 
        '<td><div class="mealContainers" id="meal' + row.meal_id+'">'+
        `<img id="image${row.meal_id}" src="${row.image_path}" alt="Image of ${row.item}" onClick="addMeal(${key})">` +
        '<p>'+row.item+ ': £'+row.price+'</p>' +
        '</div><td>';
        mealToAdd = {meal_id: row.meal_id, isAvailable: true, price: row.price};
        mealsAvailable.push(mealToAdd);

        if(counter == 2){
          htmlToAdd+= "</tr><tr>";
        }
        if(counter == 5){
          htmlToAdd+= "</tr>"
        }
        counter++;
      })
      htmlToAdd+= "</table>"
      console.log(meals);
      $("#mainContent").html(htmlToAdd);
      checkAllMeals();
    },
    error: function(){
      alert(queryErrorText + "(getMealItems)");
    }
  });
}

function checkAllMeals(){
  for(var i = 0; i < meals.length; i++){
    console.log(`meals ${meals[i].meal_id}`);
    checkMealQuantities(meals[i].meal_id);
  }
}

//
// Check all ingredient quantities in all meals and hide the picture if out of stock
//


function checkMealQuantities(meal_id){
  console.log("Checking meal quantities");
  $.ajax({
    type: "POST",
    url:"/Cluk/php/queries/getMealIngredientsQuantities.php",
    data: {meal_id},
    dataType: "json",
    success: function(rows){
      console.log(rows);
      checkRestaurantHasRequiredStock(meal_id, rows, 0);
    },
    error: function(){
      alert(queryErrorText + "(getMealIngredientsQuantities)");
    }
  });
}

function checkRestaurantHasRequiredStock(meal_id, mealIngredientQuantities, counter){
  var ingredient_id = mealIngredientQuantities[counter].ingredient_id;
  var quantity = mealIngredientQuantities[counter].quantity;
  $.ajax({
    type: "POST",
    url:"/Cluk/php/queries/checkRestaurantHasMealIngredients.php",
    data: {ingredient_id: ingredient_id, quantity: quantity},
    success: function(response){
      counter++;
      if(response){
        console.log("true");
        console.log(`meal ${meal_id} | ${response}`);
        if(counter < mealIngredientQuantities.length){
          checkRestaurantHasRequiredStock(meal_id, mealIngredientQuantities, counter);
        }
      }
      else{
        $(`#image${meal_id}`).css('opacity', '0.1');
        for(var i = 0; i < mealsAvailable.length; i++){
          if(mealsAvailable[i].meal_id == meal_id)
            mealsAvailable[i].isAvailable = false;
        }
        console.log("false");
      }
    },
    error: function(){
      alert(queryErrorText + "(checkRestaurantHasMealIngredients)");
    }
  });
}

function addMeal(key){
  for(var i = 0; i < mealsAvailable.length; i++){
    if(mealsAvailable[i].meal_id == meals[key].meal_id)
      if(mealsAvailable[i].isAvailable == false)
        return;
      else{
        cartTotalPrice += parseFloat(mealsAvailable[i].price);
      }
  }
  var htmlToAdd = $("#cartItems").html();
  htmlToAdd += '<div id="cartItem' +numberOfCartItems+'">'+
  meals[key].item + ' £' + meals[key].price +
  '</div>';
  $("#cartItems").html(htmlToAdd);
  numberOfCartItems++;
  
  //customerOrder.push(1 : 1);
  console.log("meal id=" + meals[key].meal_id)
  var mealFound = false;
  for(var i = 0; i < orderMealIds.length; i++){
    if(orderMealIds[i] == meals[key].meal_id){
      orderMealQuantities[i]++;
      mealFound = true;
      break;
    }
  }
  if(mealFound == false){
    orderMealIds.push(meals[key].meal_id);
    orderMealQuantities.push(1);
  }
  updateCartTotal();
}

function completeOrder(){

  var meals = orderMealIds;
  console.log(`meals 0 = ${meals[0]}`);

  $.ajax({
    type: "POST",
    url:"/Cluk/php/queries/addMealsToRestaurantSoldMeals.php",
    data: {meals: meals},
    success: function(){
      console.log("Succesfully added meals to history");

    },
    error: function(){
      alert(queryErrorText + "(addMealsToRestaurantSoldMeals)");
    }
  });

  subtractMeal(0);
  //find the list of ingredients for each meal
  //subtract 1 from each of their stock levels
  //repeat for each meal
}

function subtractMeal(index){
  console.log("meal id = " + orderMealIds[index])
  var meal_id = orderMealIds[index];

  //console.log(meals[orderMealIds[index]]);
  $.ajax({
    type: "POST",
    url:"/Cluk/php/queries/getMealIngredients.php",
    data: {meal_id},
    dataType: "json",
    success: function(result){
      var debugString = `Ingredient: ${result[0].ingredient_id}`;
      console.log(debugString);
      subtractIngredient(result, 0, index);

    },
    error: function(){
      alert(queryErrorText + "(getMealIngredients)");
    }
  });
}


function subtractIngredient(ingredients, index, mealIndex){
  var ingredient_quantity = ingredients[index].quantity * orderMealQuantities[mealIndex];
  $.ajax({
    type: "POST",
    url:"/Cluk/php/queries/subtractIngredientFromStock.php",
    data: {ingredient_id: ingredients[index].ingredient_id, quantity: ingredient_quantity},
    //dataType: "json",
    success: function(result){



      if(index < ingredients.length-1){
        index++;
        subtractIngredient(ingredients, index, mealIndex);
      }else{
        cancelOrder();
      }


    },
    error: function(){
      alert(queryErrorText + "(getMealItems)");
    }
  });
}


function cancelOrder(){
  orderMealIds = new Array();
  orderMealQuantities = new Array();
  cartTotalPrice = 0.00;
  numberOfCartItems = 0;
  updateCartTotal();
  $("#cartItems").html("");
}

function updateCartTotal(){
  totalPrice = cartTotalPrice.toFixed(2);
  $("#cartTotal").html("Cart Total: £"+totalPrice);
  console.log(cartTotalPrice);
}
