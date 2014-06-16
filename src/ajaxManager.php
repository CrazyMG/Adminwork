<?php

require './../vendor/autoload.php';

$properties = parse_ini_file('./../config/adminwork.ini');

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

$isAvailable = false;
switch ($_POST['type']) {
	case 'email': {
		$email = $_POST['email'];
		$userDB = Model::factory('Users')->where('email', $email)->findOne();

		if(!$userDB instanceof Users){
			$isAvailable = true; // or false
		}
		break;
	}
	default: {
		break;
	}
}

//// Finally, return a JSON
echo json_encode(array(
    'valid' => $isAvailable,
));