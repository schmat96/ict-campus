/**
 * Initialisiert die onlclick events für die Sterne. Wirft bei einem onclick Event den Ajax aus
 * damit die Daten in der Datenbank angepasst werden und startet die Animation.
 * 
 * 
 * #TODO: Alternative für non-Javascript User!
 */
var initializeSongList = function () {
	/**
	 * Für jedes Element mit der Klasse .stern
	 */
	$( ".stern" ).each(function(index) {
		$(this).on("click", function(){
			
			/**
			 * Bekommt die id und die Bewertung aus dem dataset der Sterne
			 */
			var data = {};
			data["id"] = this.dataset.id;
			data["bewertung"] = this.dataset.nummer;
			
			/**
			 * Sendet die Daten mithilfe von Ajax an die Datenbank, startet die Animation und
			 * ändert das Bild.
			 * 
			 * #TODO Bewertungen mit 0 sollten auch möglich sein!
			 */
			$.ajax({
				type: "POST",
				url: "updatebewertung",
				data: data,
				success : function (response)
				{
					if (response=="") {
						var num = 0;
						$( ".stern" ).each(function( index ) {
							if (this.dataset.id == data["id"]) {
								if (this.dataset.nummer > data["bewertung"]) {
									this.src = "./bilder/stern.png";
								} else {
									animationSterne(this, num);
									num++;
								}
							}
						});
					} else {
						console.log(response);
					}

				},
			});
		});
	});


	/**
	 * Setzt die Animation für die Sterne zurück und startet sie neu. Ändert auch die Füllung/das Bild der Sterne.
	 */
	function animationSterne(ele, num) {
		ele.src = "./bilder/stern_full.png";
		ele.classList.remove("turning0");
		ele.classList.remove("turning1");
		ele.classList.remove("turning2");
		ele.classList.remove("turning3");
		ele.classList.remove("turning4");
		void ele.offsetWidth;
		ele.classList.add("turning"+num);
	}

}




function showHelp() {

}

/**
 * Wird der Delete Knopf gedrückt und herumgezogen, erscheint der Papierkorp (mit einer Animation, diese Kann ausgeschaltet werden, 
 * indem ele.ClassList.add([..] auskommentiert wird!))
 * @param ev der Auslöser des Events (in unserem Fall der rote Papierkorb)
 * 
 */
function drag(ev) {
	var ele = document.getElementById("papierkorb");
	ele.style.display = "inline";
	ele.classList.remove("papierkorbAni");
	void ele.offsetWidth;
	ele.classList.add("papierkorbAni");
	ev.dataTransfer.setData("text", ev.target.dataset.id);
}

/**
 * Erlaubt das droppen des roten Papierkorbs in den Papierkorb
 * @param ev der Auslöser des Events (in unserem Fall der rote Papierkorb)
 * @returns
 */

function allowDrop(ev) {
	ev.preventDefault();
}

/**
 * Ändert die Position des Papierkorbs je nachdem wo sich unser roter Papierkorb befindet.
 * @param ev
 * @returns
 */
function changeSize(ev) {
	document.getElementById("papierkorb").style.left = (event.pageX-100)+"px";
}

/**
 * Wird der rote Papierkorb NICHT in den grossen Papierkorb verschoben, wird diese Funktion aufgerufen, wobei 
 * der grosse Papierkorb verschwindet.
 * @param ev
 * @returns
 */
function dragEnded(ev) {
	document.getElementById("papierkorb").style.display = "none";
}

/**
 * 
 * @param ev
 * @returns
 */
function drop(ev) {
	ev.preventDefault();
	var data2 = ev.dataTransfer.getData("text");
	console.log(data);
	console.log("dropped");
	var data = {};

	data["id"] = data2;

	$.ajax({
		type: "POST",
		url: "deletesong",
		data: data,
		success : function (response)
		{
			if (response=="") {
				$( ".songlist" ).each(function( index ) {
					if (data["id"] == this.dataset.id) {
						this.parentNode.removeChild(this);
						return;
					}
				});
			} else {
				console.log(response);
			}

		},
	}); 

	document.getElementById("papierkorb").style.display = "none";

}