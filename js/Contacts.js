var queryErrorText = "There was an error querying the database.";
var dropDownHtml = "";
var warehouseInfo;
var restaurantInfo = new Array();
var isReady = false;

$(document).ready(function(){

    setupDropdown();

});

function getWarehouseInfo(){
    $.ajax({
        type: "POST",
        url:"/Cluk/php/queries/getWarehouseInfo.php",
        //data: {},
        dataType: "json",
        success: function(rows){
            var textToDisplay = '';
            var row = rows[0];
            var address_id = 0;
            var phone_number = "";
            $.each(rows, function(key, row){
                textToDisplay+= `warehouse_id = ${row.warehouse_id} | address_id = ${row.address_id} | phone_number = ${row.phone_number}`;
                address_id = row.address_id;
                phone_number = row.phone_number;
                warehouseInfo = row;
            })


            isReady = true;


        },
        error: function(){
            alert(queryErrorText + "(getWarehouseInfo)");
        }
    });
}

function showContactInfo(){
    console.log($("#locationDropdown").val());
    var currentDropdownValue = $("#locationDropdown").val();
    if(currentDropdownValue == "" || isReady == false){
        $("#contactInfo").html("");
    }
    else if(currentDropdownValue == "warehouse"){
        var textToDisplay = `<table class="table table-striped"><tbody><tr><td class="addressHead"><strong>Warhouse ID:</strong></td> <td class="title_id"> ${warehouseInfo.warehouse_id}</td></tr>` +
            `<tr><td class="addressHead"><strong>Warehouse Phone Number:</strong></td> <td class="title_id"> ${warehouseInfo.phone_number}</td></tr>`;
        //$("#contactInfo").html(textToDisplay);
        getAddress(warehouseInfo.address_id, textToDisplay);
    }
    else{
        var restaurantIndex = getRestaurantIndexById(currentDropdownValue);
        var textToDisplay = `<table class="table table-striped"><tbody><tr><th class="addressHead" scope="row">Restaurant ID:</th><td class="title_id"> ${restaurantInfo[restaurantIndex].restaurant_id}</td></tr>` +
            `<tr><th class="addressHead" scope="row">Restaurant Phone Number:</th><td class="title_id"> ${restaurantInfo[restaurantIndex].phone_number}</td></tr>`;
        //$("#contactInfo").html(textToDisplay);
        getAddress(restaurantInfo[restaurantIndex].address_id, textToDisplay);
    }
}

function getRestaurantIndexById(id){
    var indexToReturn = null;
    for(var i = 0; i < restaurantInfo.length; i++){
        if(restaurantInfo[i].restaurant_id == id)
            indexToReturn = i;
    }
    return indexToReturn;
}

function setupDropdown(){


    dropDownHtml+= `<select id="locationDropdown" name="locationDropdown" onchange="showContactInfo()">` +
        `<option value="" selected><p id="loc">Please select a location.</p></option>` +
        `<option value="warehouse">Warehouse</option>`;

    $.ajax({
        type: "POST",
        url:"/Cluk/php/queries/getRestaurantInfo.php",
        data: {},
        dataType: "json",
        success: function(rows){

            $.each(rows, function(key, row){
                dropDownHtml+= `<option value="${row.restaurant_id}">${row.name}</option>`;
                restaurantInfo.push({restaurant_id: row.restaurant_id, name: row.name, address_id: row.address_id, phone_number: row.phone_number});
            })
            console.log("ajax");
            dropDownHtml+= `</select>`;
            $("#tableMain").html(dropDownHtml);
            getWarehouseInfo();

        },
        error: function(){
            alert(queryErrorText + "(getRestaurantInfo)");
        }

    });


}

/*
function displayRestaurantInfo(){
    var textToDisplay = `<table class="table table-striped">`;
    for(var i = 0; i < restaurantInfo.length; i++){
        textToDisplay+= `<tbody><tr><td>${restaurantInfo[i].restaurant_id}</td><td>${restaurantInfo[i].name}</td></tr>`;
    }
    textToDisplay+= `</tbody></table>`;
    $("#contactInfo").html(textToDisplay);
}*/

function getAddress(address_id, html){
    $.ajax({
        type: "POST",
        url:"/Cluk/php/queries/getAddress.php",
        data: {address_id},
        dataType: "json",
        success: function(rows){
            var textToDisplay = html;


            $.each(rows, function(key, row){
                textToDisplay+= `<tr><th class="addressHead">Address Line 1: <td class="title_id">${row.line1}</td></th></tr><tr><th class="addressHead">Address Line 2: <td class="title_id">${row.line2}</td></th></tr><tr><th class="addressHead">City: <td class="title_id">${row.city}</td></th></tr><tr><th class="addressHead">Postcode: <td class="title_id">${row.postcode}</td></th></tr>`;

            })

            textToDisplay+= `</tbody></table>`;

           $("#contactInfo").html(textToDisplay);
          
     // $(`#order${order_id}`).html(textToDisplay);


        },
        error: function(){
            alert(queryErrorText + "(getContact)");
        }
    });

}