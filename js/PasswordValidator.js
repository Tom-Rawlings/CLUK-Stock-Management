
//Password regex taken from "The Polyglot Developer"
//https://www.thepolyglotdeveloper.com/2015/05/use-regex-to-test-password-strength-in-javascript/
document.onkeyup=function(e){
	validate();
}

var passwordOk = false;
var inputIds = [];
inputIds["#email"] = false;

function emailValidate(){
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

function validate(){
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
