<?php 

require('config.php');

/*On récupère l'information de l'input*/
$inputValue = $_GET['inputValue'];

/*Requête préparé*/
$nameCity = $bdd->prepare("
	SELECT nom_Ville, long_Ville, lat_Ville, cp_Ville 
	FROM ville 
	WHERE nom_Ville 
	LIKE '$inputValue%'
	LIMIT 13");

/*On exécute la requête pour aller chercher tous les info des villes*/
$nameCity->execute();

$resNameCity = array();
while ($row = $nameCity->fetch(PDO::FETCH_ASSOC)) {
	
	$resNameCity[] = [
		'nom' => $row['nom_Ville'],
		'longitude' => $row['long_Ville'],
		'latitude' => $row['lat_Ville'],
		'cp' => $row['cp_Ville']
	];
}
	
$nameCity->closeCursor();

/*header('Content-Type: application/json');*/
$resNameCity = json_encode($resNameCity);
echo $resNameCity;

?>