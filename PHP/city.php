<?php 

require('config.php');

/*On récupère l'information de l'input*/
$inputValue = $_GET['inputValue'];

/*Requête préparé*/
$nameCity = $bdd->prepare("
	SELECT ville_nom, ville_longitude_deg, ville_latitude_deg, ville_code_postal 
	FROM villes 
	WHERE ville_nom 
	LIKE '$inputValue%'
	LIMIT 10");

/*On exécute la requête pour aller chercher tous les info des villes*/
$nameCity->execute();

$resNameCity = array();
while ($row = $nameCity->fetch(PDO::FETCH_ASSOC)) {
	
	$resNameCity[] = [
		'nom' => $row['ville_nom'],
		'longitude' => $row['ville_longitude_deg'],
		'latitude' => $row['ville_latitude_deg'],
		'cp' => $row['ville_code_postal']
	];
}
	
$nameCity->closeCursor();

/*header('Content-Type: application/json');*/
$resNameCity = json_encode($resNameCity);
echo $resNameCity;

?>