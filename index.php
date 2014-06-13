<?php

require 'vendor/autoload.php';

require_once './vendor/j4mie/idiorm/idiorm.php';
require_once './vendor/j4mie/paris/paris.php';

$properties = parse_ini_file('./config/adminwork.ini');

// Checks for integrity of data from config file.
try {
	$dbName = $properties['db.name'];
}catch(Exception $e){
	echo $e->getMessage("Database name in your adminwork.ini is invalid.");
}
try {
	$host = $properties['mysql.host'];
}catch(Exception $e){
	echo $e->getMessage("Host name in your adminwork.ini is invalid.");
}
try {
	$user = $properties['mysql.user'];
}catch(Exception $e){
	echo $e->getMessage("User in your adminwork.ini is invalid.");
}
try {
	$password = $properties['mysql.password'];
}catch(Exception $e){
	$password = '';
}

$link = mysql_connect($host, $user, $password);
try{
	mysql_query("create database if not exists $dbName", $link);
}catch(Exception $e){
	$e->getMessage();
}

ORM::configure('mysql:host='.$host.';dbname='.$dbName);
ORM::configure('username', $user);
ORM::configure('password', $password);
ORM::configure('logging', true);

try{
	$db = ORM::get_db();
	

}catch(Exception $e){
	echo $e->getMessage();
}

//Istance Twig and enable the extensions for debugging
$twigView = new \Slim\Extras\Views\Twig();
$twigView::$twigExtensions = array(new Twig_Extension_Debug());
$twigView::$twigOptions = array('debug' => true);

// Istance of application
$app = new \Slim\Slim(array(
	'view' => $twigView
));

require_once 'src/createDatabase.php';
require 'src/controller/router.php';

$app->run();

