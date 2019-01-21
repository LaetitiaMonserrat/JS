<?php 
require('config.php');

/*On récupère l'information de l'input*/
$latMap = $_GET['latMap'];
$longMap = $_GET['longMap'];


/*Requête préparé*/
$structure = $bdd->prepare("
	SELECT * 
	FROM magasin 
	WHERE (latMag BETWEEN()) AND (longMag BETWEEN())
");

/*On exécute la requête pour aller chercher tous les info des villes*/
$structure->execute();

$resStructure = array();
while ($row = $structure->fetch(PDO::FETCH_ASSOC)) {
	
	$resStructure[] = [
		'nom' => $row['ville_nom'],
		'longitude' => $row['ville_longitude_deg'],
		'latitude' => $row['ville_latitude_deg'],
		'cp' => $row['ville_code_postal']
	];
}
	
$structure->closeCursor();

/*header('Content-Type: application/json');*/
$resStructure = json_encode($resStructure);
echo $resStructure;

?>