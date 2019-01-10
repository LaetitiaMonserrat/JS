<?php
class Spdo{
	private static $instance = null;
	const DEFAULT_SQL_HOST = 'localhost';
	const DEFAULT_SQL_DTB = 'bvilles';
	const DEFAULT_SQL_USER='root';
	const DEFAULT_SQL_PASS = '';

	public static function getInstance(){  
		if(is_null(self::$instance)){
			self::$instance = new PDO('mysql:dbname='.self::DEFAULT_SQL_DTB.';host='.self::DEFAULT_SQL_HOST,self::DEFAULT_SQL_USER ,self::DEFAULT_SQL_PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
		}
		return self::$instance;
	}
}


/*CONNEXION A LA BDD*/
try{
	$bdd = Spdo::getInstance();
} catch (Exception $e){
	die('Erreur : '.$e->getMessage());
}


/*On récupère l'information de l'input*/
$inputValue = $_GET['inputValue'];

/*Requête préparé*/

$nomVilles = $bdd->prepare("
	SELECT ville_nom, ville_longitude_deg, ville_latitude_deg, ville_code_postal 
	FROM villes 
	WHERE ville_nom LIKE '$inputValue%' limit 10");


//$nomVilles->bindValue('inputValue', $inputValue, PDO::PARAM_STR);

/*On exécute la requête pour aller chercher tous les info des villes*/
 $nomVilles->execute();

$resNomVille = array();
while ($row = $nomVilles->fetch(PDO::FETCH_ASSOC)) {
	
	$resNomVille[] = [
		'nom' => $row['ville_nom'],
		'longitude' => $row['ville_longitude_deg'],
		'latitude' => $row['ville_latitude_deg']
	];
}
	
$nomVilles->closeCursor();

/*header('Content-Type: application/json');*/
$resNomVille = json_encode($resNomVille);
echo $resNomVille;