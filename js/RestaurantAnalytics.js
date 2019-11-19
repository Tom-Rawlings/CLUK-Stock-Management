var queryErrorText = "There was an error querying the database";
var meals = new Array();
var mealNames = new Array();
var mealQuantities = new Array();
var pieColours = ["#F7464A", "#46BFBD", "#FDB45C", "#949FB1", "#4D5360", "#F7464A", "#F7464A" ,"#F7464A" ,"#F7464A"];
var pieHoverColours = ["#FF5A5E", "#5AD3D1", "#FFC870", "#A8B3C5", "#616774","#F7464A" ,"#F7464A" ,"#F7464A" ,"#F7464A"];
var mealsSold = new Array();
var mealNamesToShow = new Array();
var pieColoursToShow = new Array();
var pieHoverColoursToShow = new Array();

createPieLabels();

/*Pulls the names of all meals from the database ready to be added to the pie chart as labels
*/
function createPieLabels(){

  $.ajax({
    type: "POST",
    url:"/Cluk/php/queries/getMealItems.php",
    data: {},
    dataType: "json",
    success: function(rows){
      console.log("Succesfully retrieved meal names");
      $.each(rows, function(key, row){
        meals.push(row);
        mealNames.push(row.item);
        console.log(mealNames[key]);
        //mealQuantities.push(10*key);
        console.log(mealQuantities);
      });
      getMealsSold();
      
    },
    error: function(){
      alert(queryErrorText + "(getMealItems)");
    }
  });

}

/*Queries the database for all meals sold by the restaurant in the last month and returns the meal_id and the count
*/
function getMealsSold(){

  var currentDate = new Date();
  var dateString = ""+currentDate.getYear()+"-"+(currentDate.getMonth()-1)+"-"+currentDate.getDate();


  $.ajax({
    type: "POST",
    url:"/Cluk/php/queries/getMealsSold.php",
    data: {dateString},
    dataType: "json",
    success: function(rows){
      console.log("Succesfully retrieved meal quantities");
      $.each(rows, function(key, row){
        mealsSold = row;
        mealQuantities.push(row.count);
        pieColoursToShow.push(pieColours[key]);
        pieHoverColours.push(pieHoverColours[key]);
        for(var i = 0; i < meals.length; i++){
          if(meals[i].meal_id == mealsSold.meal_id){
            mealNamesToShow.push(meals[i].item);
          }
        }
      });

      createPieChart();
    },
    error: function(){
      alert(queryErrorText + "(getMealsSold)");
    }
  });

}

/*Creates a pie chart using the quantities and meal names pulled from the database
Uses chart.js from bootstrap for the chart graphics.
*/

function createPieChart(){
  var ctxP = document.getElementById("chartPie").getContext('2d');
  var myPieChart = new Chart(ctxP, {
    type: 'pie',
    data: {
      labels: mealNamesToShow,
      datasets: [{
        data: mealQuantities,
        backgroundColor: pieColoursToShow,
        hoverBackgroundColor: pieHoverColoursToShow
      }]
    },
    options: {
      responsive: true
    }
  });
}
