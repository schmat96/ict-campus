/**
 * JAVASCRIPT/JQUERY:
 * Sollte der User Javascript ausgeschaltet haben, wird er dank dieser Funktion, zusammen mit dem HTML trotzdem auf
 * submit drücken können, denn diese Funktion wird erst beispielsweise den Button ausschalten.
 * 
 * Ausserdem macht sie eine Anmeldung mit der "Enter"-Taste möglich.
 *
 */
var initializeMancheck = function() {
	document.getElementById("submit").style.border  = "thick solid "+ colorWrong;
	$('#submit').attr("disabled", true);
}

/**
 * JAVASCRIPT/JQUERY:
 * Überprüft ob die einzelne Eingabe nicht leer ist. Sollte sie leer sein wird ein Hilfstext
 * ausgegeben.
 *
 */
function mancheck() {
	var song = document.getElementById("mantext");
	var helpArray = [];
	var checked = 0;
	var songHelpText = "keine leeren Einträge."
	var checked = 0;
	var lastRequest = 0;

	if (song.value!="") {
		checked++;
	} else {
		helpArray.push(songHelpText);
	}

	if (checked >= 1 ) {

		document.getElementById("submit").style.border  = "thick solid "+ colorCorrect;
		$('#submit').removeAttr("disabled");
		document.getElementById("helpText").innerHTML = "";

	} else {
		document.getElementById("submit").style.border  = "thick solid "+ colorWrong;
		$('#submit').attr("disabled", true);
		var text = "";
		for(var i=0; i < helpArray.length; i++) {
			text = text + helpArray[i];
		}
		document.getElementById("helpText").innerHTML = text;
	}
}

/**
 * AJAX
 * @deprecated
 *
 */
function makeSuggestions(text) {
	var data = {};
	$.ajax({
		type: "POST",
		url: "dammed",
		data: data,
		success : function (response)
		{
			console.log(response);
		},
	});
}