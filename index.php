<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>TP préparation projet</title>
	<link rel="stylesheet" href="">
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

	<script src="JS/bibli.js"></script>
	<script>
		let input = document.getElementById('vdf');
		let datalist = document.getElementById('bvilles');

		let done = (r) =>{
			let rep = JSON.parse(r.responseText);

			/*On suprime le contenu de la datalist*/
			datalist.innerHTML="";

			/*On rempli la datalist*/
			for (let i=0; i<rep.length; i++){
				let option = datalist.appendChild(document.createElement('option'));
				option.setAttribute('value', rep[i].nom);
			}
		} 

		let error = () =>{
			return console.log('Nope');
		}

		function rechercheVille(inputValue){
			$get("PHP/config.php", {inputValue:inputValue}, done, error);		
		}

		document.addEventListener('DOMContentLoaded', function(){
			input.addEventListener('keyup', function(){
				if(input.value.length > 2){
					rechercheVille(input.value);
				} else if (datalist.childElementCount) {
					datalist.innerHTML="";
				}
			});
		});
	</script>
</body>
</html>