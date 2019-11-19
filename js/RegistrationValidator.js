
//Password regex taken from "The Polyglot Developer"
//https://www.thepolyglotdeveloper.com/2015/05/use-regex-to-test-password-strength-in-javascript/
document.onkeyup=function(e){
	validatePasswordStrength();
}

function validate(){
	validateEmail();
	validateAddress();
	validatePhonenumber();
	validateName();
}

$(document).ready(function(){
	getSecurityQuestions();
});

var passwordOk = false;
var inputIds = [];
inputIds["#email"] = false;

function validateEmail(){
	var regex = new RegExp(".*@.*\..*");
	var email = $("#email").val();
	if(regex.test(email) && email.length < 45){
		$("#email").css("background-color","green");
		$("#email").css("color","white");
	}else{
		$("#email").css("background-color","red");
		$("#email").css("color","white");
	}
}

function validateName(){
	var nameRegex = new RegExp("[A-Za-z]+[.,\-A-Za-z]*");
	var firstName = $("#firstName").val();
	var lastName = $("#lastName").val();

	if(nameRegex.test(firstName) && firstName.length < 45){
		$("#firstName").css("background-color","green");
		$("#firstName").css("color","white");
	}else{
		$("#firstName").css("background-color","red");
		$("#firstName").css("color","white");
	}

	if(nameRegex.test(lastName) && lastName.length < 45){
		$("#lastName").css("background-color","green");
		$("#lastName").css("color","white");
	}else{
		$("#lastName").css("background-color","red");
		$("#lastName").css("color","white");
	}

}

function validateAddress(){
	//postcode regex from wikipedia
	//https://en.wikipedia.org/wiki/Postcodes_in_the_United_Kingdom
	var postCodeRegex = new RegExp("^([A-Za-z][A-Ha-hK-Yk-y]?[0-9][A-Za-z0-9]?\\s?[0-9][A-Za-z]{2}|[Gg][Ii][Rr]\\s0[Aa]{2})$");
	var addressRegex = new RegExp("[A-Za-z]+[.,\-A-Za-z]*");

	var line1String = $("#Line1").val();
	var line2String = $("#Line2").val();
	var cityString = $("#City").val();
	var postcodeString = $("#Postcode").val();

	if(addressRegex.test(line1String) && line1String.length < 45){
		$("#Line1").css("background-color","green");
		$("#Line1").css("color","white");
	}else{
		$("#Line1").css("background-color","red");
		$("#Line1").css("color","white");
	}

	if(addressRegex.test(line2String) && line2String.length < 45){
		$("#Line2").css("background-color","green");
		$("#Line2").css("color","white");
	}else{
		$("#Line2").css("background-color","red");
		$("#Line2").css("color","white");
	}

	if(addressRegex.test(cityString) && cityString.length < 45){
		$("#City").css("background-color","green");
		$("#City").css("color","white");
	}else{
		$("#City").css("background-color","red");
		$("#City").css("color","white");
	}

	if(postCodeRegex.test(postcodeString) && postcodeString.length < 45){
		$("#Postcode").css("background-color","green");
		$("#Postcode").css("color","white");
	}else{
		$("#Postcode").css("background-color","red");
		$("#Postcode").css("color","white");
	}


}

function validatePhonenumber(){
	var phoneNumber = $("#phonenumber").val();
	var phoneNumberLength = phoneNumber.length;
	console.log("phonenumber = " + phoneNumberLength);
	if(phoneNumberLength >= 11 && phoneNumberLength<= 15){
		$("#phonenumber").css("background-color","green");
		$("#phonenumber").css("color","white");
	}else{
		$("#phonenumber").css("background-color","red");
		$("#phonenumber").css("color","white");
	}
}

function validatePasswordStrength(){
	if(!$("#password").is(':focus')){
		return;
	}
	console.log($("#password").val());

	var password1 = $("#password").val();
	var password2 = $("#password2").val();
	var regex = new RegExp("^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\$%\^&\*])(?=.{8,})");
	if(regex.test(password1) && password1.length < 45){
		$("#password").css("background-color","green");
		$("#password").css("color","white");
		passwordOk = true;

	}else{
		$("#password").css("background-color","red");
		$("#password").css("color","white");
		passwordOk = false;

	}

}

function confirmPassword(){
	if(passwordOk){
		var password1 = $("#password").val();
		var password2 = $("#password2").val();
		if(password2 === password1){
			$("#password").css("background-color","blue");
			console.log("password matches");
			return true;

		}
	}
	return false;
}

function getSecurityQuestions(){
  $.ajax({
    type: "POST",
    //url:"/Cluk/php/queries/getIngredients.php",
    url:"/Cluk/php/queries/getSecurityQuestions.php",
    data: {},
    dataType: "json",
    success: function(rows){
      var textToDisplay = `<select name="questions">`;

      
      $.each(rows, function(key, row){
          textToDisplay += `<option value="${row.question}">${row.question}</option>`

      })

      textToDisplay += `</select>`;

      $("#questions").html(textToDisplay);

    },
    error: function(){
      alert("Error" + "(getSecurityQuestions)");
    }
  });
  
}



/*
<select name="cars">
  <option value="volvo">Volvo</option>
  <option value="saab">Saab</option>
  <option value="fiat">Fiat</option>
  <option value="audi">Audi</option>
</select>
*/