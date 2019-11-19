var emailErrorMessage = "Please enter a valid email address.";
var passwordErrorMessage = "Please enter your password.";
var emailRegex = new RegExp(".*@.*\..*");


function validate(){
	
	var email = $("#email").val();
	var password = $("#password").val();
	var errorHtml = "";
	var valid = true;

	if(email == "" || emailRegex.test(email) == false || email.length > 45){
		errorHtml+= emailErrorMessage + "<br/>";
		valid = false;
	}
	if(password == ""){
		errorHtml+= passwordErrorMessage;
		valid = false;
	}

	$("#errorText").html(errorHtml);

	if(valid){
    $.ajax({
      type: "POST",
      url:"/Cluk/php/admin/loginCheck.php",
      data: {email: email, password: password},
      dataType: "json",
      async: false,
      success: function(rows){
      	console.log("ajax successful");
          var textToDisplay = '';
          if(rows[0].returnValue == false){
          	//email and password don't match
          	valid = false;
          	$("#errorText").html("Email and password don't match");
          }
          
      },
      error: function(){
          alert(queryErrorText + " (loginCheck)");
      }
    });
	}

	return valid;
}

