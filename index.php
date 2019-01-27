<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>TP préparation projet</title>
	<link rel="stylesheet" href="http://cdn.leafletjs.com/leaflet/v0.7.7/leaflet.css"/>
	<link rel="stylesheet" href="CSS/style.css">
</head>
<body>
	<form action="" method="get" accept-charset="utf-8">
		<fieldset>
			<legend>Villes de France</legend>
			<label for="vdf"></label>
			<input list="bvilles" type="text" name="vdf" id="vdf" value="">
			<datalist id="bvilles">
			</datalist>
		</fieldset>
	</form>

	<div id="map"></div>

	<script src="http://cdn.leafletjs.com/leaflet/v0.7.7/leaflet.js"></script>
	<script src="JS/bibli.js"></script>
	<script>
/*________________Variables________________*/
		/*Pour la map*/
		var map = L.map('map');
		var osmUrl='http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png';
		var osmAttrib='Map data © OpenStreetMap contributors';
		var osm = new L.TileLayer(osmUrl, {attribution: osmAttrib});


		var memoryReq;
		let input = document.getElementById('vdf');
		let datalist = document.getElementById('bvilles');


		let error = () =>{return console.log('Nope');}
		let findCityDone = (r) =>{
			let rep = JSON.parse(r.responseText);
			let nameCity = input.value.split(';');
/*			let nameTest = nameCity[0][0]
*/
			/*On suprime le contenu de la datalist*/
			datalist.innerHTML="";

			/*On actualise memoryReq que si rep retourne un résultat*/
			if (rep.length !== 0) {memoryReq = rep;}

			console.log(nameCity[0][0]);
			console.log(rep);

			/*Si la requête sql (rep) est vide, on vérifie dans memoryReq (qui est le stockage de la requête sql précédente) sinon on rempli la datalist avec la rep*/
			if(rep.length == 0){
				for (let i=0; i<memoryReq.length; i++){
					if ((nameCity[0].toUpperCase() == memoryReq[i].nom.toUpperCase()) && (nameCity[1] == memoryReq[i].cp)) {
						map.setView([memoryReq[i].latitude, memoryReq[i].longitude], 14);
						/*On appelle une requête ajax pour afficher les magasins*/
						findStructure(/*memoryReq[i].latitude, memoryReq[i].longitude*/);
					}
				}
			} else {
				for (let i=0; i<rep.length; i++){
					/*Si le nom dans l'input correspond au nom d'une ville, on recentre la carte sur la ville*/
					if (nameCity[0][0].toUpperCase() == rep[i].nom.toUpperCase()) {
						map.setView([rep[i].latitude, rep[i].longitude], 14);
						/*On appelle une requête ajax pour afficher les magasins*/
						findStructure(/*rep[i].latitude, rep[i].longitude*/);
					}

					let option = datalist.appendChild(document.createElement('option'));
					option.setAttribute('value', rep[i].nom+';'+rep[i].cp);
				}
			}
		}
		let findStructureDone = (r) =>{
			let rep = JSON.parse(r.responseText);

			

		}
/* ________________Fin variables________________ */

/* ________________Début fonctions________________ */
		function findCity(inputValue){
			$get("PHP/city.php", {inputValue:inputValue}, findCityDone, error);	
		}


		function findStructure(/*latMap, longMap*/){
			console.log(map.getBounds());
			console.log(map.getBounds().getSouthWest().lat);
			console.log(map.getBounds().getSouthWest().lng);
			console.log(map.getBounds().getNorthEast().lat);
			console.log(map.getBounds().getNorthEast().lng);
/*			$get("PHP/structure.php", {latMap:latMap, longMap:longMap}, findStructureDone, error);
*/		}

		 
/* ________________Fin fonctions________________ */

/* ________________Code principal au chargement de la page________________*/
		document.addEventListener('DOMContentLoaded', function(){

			/*On ajoute un évènement sur l'input quand on tape sur le clavier*/
			input.addEventListener('keyup', function(){
				if(input.value.length > 2){
					findCity(input.value);
				} else if (datalist.childElementCount) {
					datalist.innerHTML="";
				}
			});

			/*On ajoute le même évènement sur la datalist au clic*/
			datalist.addEventListener('click', function(){
				if(input.value.length > 2){
					findCity(input.value);
				} else if (datalist.childElementCount) {
					datalist.innerHTML="";
				}
			});

			/*On ajoute le même évènement sur la datalist quand on appuie sur une touche*/
			datalist.addEventListener('keyup', function(){
				if(input.value.length > 2){
					findCity(input.value);
				} else if (datalist.childElementCount) {
					datalist.innerHTML="";
				}
			});

			/* Affichage par défaut de la map*/
			map.setView([47.0, 3.0], 6);
			map.addLayer(osm);
		});
	</script>
</body>
</html>