<?php
class Spdo{
	private static $instance = null;
	const DEFAULT_SQL_HOST = 'localhost';
	const DEFAULT_SQL_DTB = 'bvilles';
	const DEFAULT_SQL_USER= 'root';
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