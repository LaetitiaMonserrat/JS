<?php 
require('config.php');

/*On récupère l'information de l'input*/
$latMapMin = $_GET['latMapMin'];
$latMapMax = $_GET['latMapMax'];
$longMapMin = $_GET['longMapMin'];
$longMapMax = $_GET['longMapMax'];


/*Requête préparé*/
if (isset($_GET['type']) && isset($_GET['categorie'])){
	$categorie = $_GET['categorie'];
	$structure = $bdd->prepare("
		SELECT * 
		FROM magasin 
		WHERE (lat_Mag BETWEEN $latMapMin AND $latMapMax) 
		AND (long_Mag BETWEEN $longMapMin AND $longMapMax)
		AND id_Type = '$type'
		AND id_Categorie = '$categorie'
	");
} else if (isset($_GET['type'])) {
	$type = $_GET['type'];
	$structure = $bdd->prepare("
		SELECT * 
		FROM magasin 
		WHERE (lat_Mag BETWEEN $latMapMin AND $latMapMax) 
		AND (long_Mag BETWEEN $longMapMin AND $longMapMax)
		AND id_Type = '$type'
	");
} else {
	$structure = $bdd->prepare("
		SELECT * 
		FROM magasin 
		WHERE (lat_Mag BETWEEN $latMapMin AND $latMapMax) 
		AND (long_Mag BETWEEN $longMapMin AND $longMapMax)
	");
}


/*On exécute la requête pour aller chercher tous les info des villes*/
$structure->execute();

$resStructure = array();
while ($row = $structure->fetch(PDO::FETCH_ASSOC)) {
	
	$resStructure[] = [
		'nom' => $row['nom_Mag'],
		'longitude' => $row['long_Mag'],
		'latitude' => $row['lat_Mag']
	];
}
	
$structure->closeCursor();

/*header('Content-Type: application/json');*/
$resStructure = json_encode($resStructure);
echo $resStructure;

?>