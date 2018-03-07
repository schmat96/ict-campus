var pattName = "[a-zA-Z0-9]{5}";
var colorCorrect =  "rgba(0, 255, 0, .3)";
var colorWrong = "rgba(255, 50, 0, .5)";
var pattPW = "^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$";
var pattMail = "[a-zA-Z0-9_]+@[a-zA-Z0-9]+\\.[a-zA-Z0-9]{2}";

var pwHelpText = "<br> Bitte gib ein gültiges PW ein. Grossbuchstaben, Zahlen und Sonderzeichen";
var	emailHelpText = "<br> Bitte gib eine gültige EMail ein.";

function initializeRegister() {
	$("#regForm span").css('color', colorWrong);
	document.getElementById("regPasswort1").style.border  = "thick solid "+ colorWrong;
	document.getElementById("regPasswort2").style.border  = "thick solid "+ colorWrong;
	document.getElementById("regEmail").style.border  = "thick solid "+ colorWrong;
	$("#helpText").css('color', colorWrong);
	$("#helpText").css('font-size', "0.7em");
	
	$(document).keypress(function(e) {
	    if(e.which == 13) {
	    	
	    	if ($('#registerLogo').attr('class') == "disabled") {
	    		showHelp();
	    	} else {
	    		register();
	    	}
	    }
	});

}

function showHelp() {
	var pw1 = document.getElementById("regPasswort1");
	var pw2 = document.getElementById("regPasswort2");
	var email = document.getElementById("regEmail");
	var helpArray = [];
	var checked = 0;
	
	if (pw1.value.match(pattPW)) {
		
	} else {
		helpArray.push(pwHelpText);
	}
	
	if (pw1.value==pw2.value && pw2.value!="") {
		
	} else {
		helpArray.push(pw2HelpText);
	}
	
	if (email.value.match(pattMail)) {
		
	} else {
		helpArray.push(emailHelpText);
	}
	
	var checkedCheckbox = 0;
	var text = "";
	 for(var i=0; i < helpArray.length; i++) {
	        text = text + helpArray[i];
	 }
	 
	 document.getElementById("helpText").innerHTML = text;

}

function checkLogin() {
	document.getElementById("helpText").innerHTML = "";
	var pw1 = document.getElementById("regPasswort1");
	var email = document.getElementById("regEmail");
	
	var checked = 0;

	if (pw1.value.match(pattPW)) {
		pw1.style.border  = "thick solid "+ colorCorrect;
		checked++;
		document.getElementById("passwort1FormHinweis").style.display = "none";
	} else {
		pw1.style.border  = "thick solid "+ colorWrong;
		if ($("#regPasswort1").is(':focus')) {
			document.getElementById("passwort1FormHinweis").innerHTML = pwHelpText;
			document.getElementById("passwort1FormHinweis").style.display = "inline";
		} else {
			document.getElementById("passwort1FormHinweis").style.display = "none";
		}
	}
	
	
	if (email.value.match(pattMail)) {
		email.style.border  = "thick solid "+ colorCorrect;
		document.getElementById("emailFormHinweis").style.display = "none";
		checked++;
	} else {
		email.style.border  = "thick solid "+ colorWrong;
		if ($("#regEmail").is(':focus')) {
			document.getElementById("emailFormHinweis").innerHTML = emailHelpText;
			document.getElementById("emailFormHinweis").style.display = "inline";
		} else {
			document.getElementById("emailFormHinweis").style.display = "none";
		}
	}
	
	
	if (checked == 2) {
		document.getElementById("submit").style.border  = "thick solid "+ colorCorrect;
		$('#submit').removeAttr("disabled");
		
	} else {
		document.getElementById("submit").style.border  = "thick solid "+ colorWrong;
		$('#submit').attr("disabled", true);
		
	}
	
	
}

function login() {
	var info = document.getElementById("Reginformation");
	alert("Erfolgreich registriert");
	info.innerHTML = "Ich mache noch nichts";	
}