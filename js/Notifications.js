var queryErrorText = "There was an error querying the database.";

$(document).ready(function(){
   getNotifications();
});

function getNotifications(){
   
    $.ajax({
    type: "POST",
    url:"/Cluk/php/queries/getNotifications.php",
    data: {},
    dataType: "json",
    success: function(rows){
    
        var textToDisplay = '<table>';
        
         $.each(rows, function(key, row){
          
            //textToDisplay+= `<tr><div class="segments"><td><p>${row.displayText}</p></td><td><button id="button_${row.notification_id}" class="button" onClick="dismissNotification(${row.notification_id})">Dismiss</button></td></div></tr>`;
            textToDisplay+= `<tr><td class="notifications"><p>${row.displayText}</p></td><td class="buttons"><button id="button_${row.notification_id}" class="button" onClick="dismissNotification(${row.notification_id})">Dismiss</button></td></tr>`;

        })

        textToDisplay += '</table>';

        $("#notification-list").html(textToDisplay);
        
    },
    error: function(){
        alert(queryErrorText);
    }
    
  });

}

//using the button ID we know the notification id??? or pass the notification id? THen do a query to update that notification.
function dismissNotification(notification_id){
  $.ajax({
    type: "POST",
    url:"/Cluk/php/queries/setNotificationDismissed.php",
    data: {notification_id},
    success: function(){
    
        getNotifications();
        
    },
    error: function(){
        alert(queryErrorText + "(setNotificationDismissed)");
    }
    
  });
}