

var pwHelpText = "<br> Bitte gib ein gültiges PW ein. Grossbuchstaben, Zahlen und Sonderzeichen";
var	emailHelpText = "<br> Bitte gib eine gültige EMail ein.";

/**
 * JAVASCRIPT/JQUERY:
 * Sollte der User Javascript ausgeschaltet haben, wird er dank dieser Funktion, zusammen mit dem HTML trotzdem auf
 * submit drücken können, denn diese Funktion wird erst beispielsweise den Button ausschalten.
 * 
 * Ausserdem macht sie eine Anmeldung mit der "Enter"-Taste möglich.
 *
 */
var initializeLogin = function () {
	document.getElementById("regPasswort1").style.border  = "thick solid "+ colorWrong;
	document.getElementById("submit").style.border  = "thick solid "+ colorWrong;
	document.getElementById("regEmail").style.border  = "thick solid "+ colorWrong;
	$("#helpText").css('font-size', "0.7em");
	document.getElementById("submit").disabled = true; 

	$(document).keypress(function(e) {
		if(e.which == 13) {

			if ($('#submit').attr('class') == "disabled") {
				showHelp();
			} else {
				document.getElementById("regForm").submit();
			}
		}
	});
}

/**
 * JAVASCRIPT:
 * Diese Methode setzt ein Array aus hilfstexten zusammen, wird die Hilfe aufgerufen.Danach wird
 * der Text angezeigt.
 * 
 * @deprecated
 *
 */
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


/**
 * JAVASCRIPT/JQUERY:
 * Diese Methode überprüft alle Form Texte auf ihre Gültigkeit und nimmt Änderungen an den 
 * jeweiligen Elementen vor (färbt sie Beispielsweise neu ein).
 * Am Schluss der Methode wird noch der Submit Button je nach Eingaben enabled oder disabled.
 *
 */
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

	var data = {};
	data["email"] = email.value;
	data["pw1"] = pw1.value;

	/**
	 * Jedes mal wenn die Formularfelder verändert wurden, wird mithilfe von Ajax die Session-Variabeln verändert, 
	 * damit der User, sollte er das Login verlassen, seine Daten doch noch vorfindet.
	 */

	$.ajax({
		type: "POST",
		url: "savesession",
		data: data,
		success : function (response)
		{
			//alert(response);
		},
	});
}