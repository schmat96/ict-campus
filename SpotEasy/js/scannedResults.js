/**
 * JQUERY/JAVASCRIPT:
 * Setzt die Canvas Füllung korrekt. Diese werden nach den datasets, welche man mithilfe von PHP gesetzt hat
 * ausgelesen und danach mit dem Maximum berechnet.
 * 
 * Ausserdem wird das Form für den Switch korrekt gesetzt.
 */

var initScannedResults = function() {
	setStuff();
	
}

function setStuff() {
	var width = 0;
	var height = 0;
	var max = 0;

	/**
	 * Setzt das Form für den Switch auf die korrekten Values. Und wirft bei einem onclick event
	 * die Aktion des Forms aus.
	 */
	$('#sliderVal').checked = false;

	$( "#sliderVal" ).on( "click", function() {
		var frm = document.getElementById('switchOP');
		console.log(this.checked);
		if (this.checked) {
			var ele1 = document.getElementById('front');
			var ele2 = document.getElementById('back');
			ele1.classList.remove("flipped");
			ele2.classList.add("flipped");
			
			
		} else {
			var ele1 = document.getElementById('front');
			var ele2 = document.getElementById('back');
			ele1.classList.add("flipped");
			ele2.classList.remove("flipped");
		}
		
		
		
	});
	

	/**
	 * Setzt die Füllung der Canvas mithilfe den Datasets korrekt.
	 */
	$( ".canvas" ).each(function(index) {
		console.log(this.dataset.value);
		

		var canvas = this;
		var ctx = canvas.getContext("2d");

		if (width==0) {
			width = canvas.width;
			height = canvas.height;
			max = this.dataset.value;
		}

		var zaehler = this.dataset.zaehler;
		if (zaehler % 2 == 0){
			ctx.fillStyle = 'rgba(199,178,212,0.5)';
		}
		else{
			ctx.fillStyle = 'rgba(129,93,150,0.5)';
		}

		ctx.fillRect(0,0,width*(this.dataset.value/max),height);
	});
}