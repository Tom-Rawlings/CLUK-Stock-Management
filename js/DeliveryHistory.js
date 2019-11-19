var queryErrorText = "There was an error querying the database."
var rowNumber = 0;


$(document).ready(function(){
    $("#tableBody").html("");
    getDeliveries();
    
});

function getDeliveries(){
    $.ajax({
        type: "POST",
        url:"/Cluk/php/queries/getDeliveries.php",
        //data: {},
        dataType: "json",
        success: function(rows){
            var textToDisplay = '<tr>';
            if(rows.length > 0) $("#errorText").hide();
            $.each(rows, function(key, row){
                rowNumber++;
                textToDisplay+= `<td>${rowNumber}</td><td>${row.delivery_id}</td>`+
                `<td id="destinations${rowNumber}">DESTINATIONS</td><td>${row.date}</td><td>`+
                `<button type="button" class="btn btn-primary" id="itemsBtn${row.delivery_id}" data-toggle="modal" data-target="#myDeliveryOne" onClick="getOrderIdsFromDelivery(${row.delivery_id}, )">Items</button></td>`+
                `<td><button type="button" class="btn btn-success">${row.status}</button></td></tr>`;
                
                getOrderIdsFromDelivery(row.delivery_id);
                getDestinations(row.delivery_id, rowNumber);
            })
            $("#tableBody").html($("#tableBody").html() + textToDisplay);
            
        },
        error: function(){
            alert(queryErrorText + " (getDeliveriesDelivered)");
        }
    });
}

//
//Items button runs from here to rebuild the popup
///
function getOrderIdsFromDelivery(delivery_id){
    $.ajax({
        type: "POST",
        url:"/Cluk/php/queries/getOrderInfoFromDelivery.php",
        data: {delivery_id},
        dataType: "json",
        success: function(rows){
            $("#itemsDeliveryId").html(`Delivery: ${delivery_id}`);
            var delivery = new Array();
            $.each(rows, function(key, row){
                var order = {order_id: row.order_id, destination: null, delivery_id: delivery_id};
                delivery.push(order);
            })
            $("#itemsContent").html("");
            getOrderIngredients(delivery[0].order_id, delivery[0].delivery_id, delivery, 0);
        },
        error: function(){
            alert(queryErrorText + " (getOrderInfoFromDelivery)");
        }
    });
}


function getDestinations(delivery_id, rowNumber){
    $.ajax({
        type: "POST",
        url:"/Cluk/php/queries/getDestinationsFromDelivery.php",
        data: {delivery_id},
        dataType: "json",
        success: function(rows){
            var textToDisplay = '';

            $.each(rows, function(key, row){
                textToDisplay+= `${row.line1} - `;
            })
            textToDisplay = textToDisplay.substring(0, textToDisplay.length-2);
            $("#destinations"+rowNumber).html(textToDisplay);
           
        },
        error: function(){
            alert(queryErrorText + " (getDestinations)");
        }
    });
}


function getOrderIngredients(order_id, delivery_id, delivery, loopCount){
    $.ajax({
        type: "POST",
        url:"/Cluk/php/queries/getOrderIngredients.php",
        data: {order_id},
        dataType: "json",
        success: function(rows){
            var textToDisplay = `<h4>Order: ${order_id}</h4>`;

            $.each(rows, function(key, row){
                textToDisplay+= `${row.name} ${row.quantity}<br/>`;
            })
            $("#itemsContent").html($("#itemsContent").html()+textToDisplay+"<hr/>");

            if(loopCount < delivery.length-1){
                loopCount++;
                getOrderIngredients(delivery[loopCount].order_id, delivery_id, delivery, loopCount);
            }
        },
        error: function(){
            alert(queryErrorText + " (getOrderIngredients)");
        }
    });
}
