var queryErrorText = "There was an error querying the database.";
var linesCurrentlyEditing = new Array();

$(document).ready(function(){

    getStock();

});

function incrementStock(stockElementId){
    value = $(stockElementId).val;
    value++;
    $(stockElementId).val = value;
}

function decrementStock(stockElementId){
    value = $(stockElementId).val;
    if(value > 0)
        value--;
    $(stockElementId).val = value;
}

function getStock(){
    $.ajax({
        type: "POST",
        //url:"/Cluk/php/queries/getIngredients.php",
        url:"/Cluk/php/queries/getStockForRestaurant.php",
        data: {},
        dataType: "json",
        success: function(rows){
          /*  var textToDisplay = '<p class="d-inline-block" id="stockTable"><table class="table table-sm table-striped">'; */                                                     // Restaurant Stock<br/><br/>';
           var textToDisplay = `<p class="d-inline-block" id="stockTable"><table class="table table-sm table-striped"><thead class="thead-dark"><tr><th>Id</th><th>Ingredient</th><th>Quantity</th><th>Category</th></tr></thead>`;

            $.each(rows, function(key, row){
                textToDisplay += '<tbody><tr><td>'+ row.ingredient_id +'</td><td>' + row.name + '</td><td id="quantity'+row.ingredient_id+'">'+ row.quantity +'</td><td>' +
                    row.category + '</td><td id="buttons' + row.ingredient_id+'">'+
                    '<input class="Stockbutton-E" type="button" id="editButton'+row.ingredient_id+'" value="Edit" onClick="makeEditable('+row.ingredient_id+')"></td></tr>';                                                                                                                                                     //'</table></p> <br/><div id="bottomButtons">' +
                       

            })

            textToDisplay +='</tbody></table></p> <br/><div id="bottomButtons">' +
            '<input class="Stockbutton-A" type="button" id="bottomApply" value="Apply All" onClick="acceptAll()"> ' +
            '<input class="Stockbutton-R" type="button" id="bottomRevert" value="Revert All" onClick="revertAll()"></div>';

            $("#tableMain").html(textToDisplay);
            //$("#bottomButtons").hide();
            document.getElementById("bottomButtons").style.visibility = "hidden";
        },
        error: function(){
            alert(queryErrorText + "(getStock)");
        }
    });

}

function acceptAll(){
    while(linesCurrentlyEditing.length != 0){
        updateIngredientStock(linesCurrentlyEditing[0]);
        revertLine(linesCurrentlyEditing[0]);
    }
}

function revertAll(){
    linesCurrentlyEditing.length = 0;
    getStock();
}

function makeEditable(lineNumber){
    var currentQuantity = $("#quantity"+lineNumber).text();
    console.log("currentQuantity = " + currentQuantity + "| lineNumber = " + lineNumber);
    $("#quantity"+lineNumber).html('<input id="quantityInput'+lineNumber+'" value="'+ currentQuantity + '">');
    var buttonsHtml = '<input class="Stockbutton-A" type="button" id="applyButton" value="Apply" onClick="updateIngredientStock('+lineNumber+')">' +
        '<input class="Stockbutton-R" type="button" id="revertButton" value="Revert" onClick="revertLine('+lineNumber+')">';
    $("#buttons"+lineNumber).html(buttonsHtml);

    linesCurrentlyEditing.push(lineNumber);

    document.getElementById("bottomButtons").style.visibility = "visible";

}

function updateIngredientStock(lineNumber){
    var ingredient_id = lineNumber;
    var quantity = $("#quantityInput"+ingredient_id).val();
    console.log("ingredient_id = "+ingredient_id+"\nquantity = " + quantity)
    $.ajax({
        type: "POST",
        //url:"/Cluk/php/queries/getIngredients.php",
        url:"/Cluk/php/queries/setIngredientStockLevel.php",
        data: {ingredient_id: ingredient_id, quantity:
        quantity},
        //dataType: "json",
        success: function(result){
            revertLine(ingredient_id);
        },
        error: function(){
            alert(queryErrorText + "(updateIngredientStock)");
        }
    });
}

function revertLine(lineNumber){

    var ingredient_id = lineNumber;
    $.ajax({
        type: "POST",
        //url:"/Cluk/php/queries/getIngredients.php",
        url:"/Cluk/php/queries/getIngredientStockLevel.php",
        data: {ingredient_id},
        dataType: "json",
        success: function(rows){
            var textToDisplay = '';

            $.each(rows, function(key, row){
                textToDisplay = row.quantity;


            })

            $("#quantity"+lineNumber).html(textToDisplay);

        },
        error: function(){
            alert(queryErrorText + "(revertLine)");
        }
    });

    $("#buttons"+lineNumber).html('<input class="Stockbutton-E" type="button" id="editButton" value="Edit" onClick="makeEditable('+ingredient_id+')">');

    for(var i = 0; i < linesCurrentlyEditing.length; i++){
        if(linesCurrentlyEditing[i] == ingredient_id)
            linesCurrentlyEditing.splice(i,1);
    }

    if(linesCurrentlyEditing.length == 0){
        document.getElementById("bottomButtons").style.visibility = "hidden";
    }

}
