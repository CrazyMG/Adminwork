<?php

$app->post('/api/users/add/', function () use($app){
	
	$json = $app->request()->getBody();
	$user = json_decode($json);
	
	array_walk_recursive($user, function(&$value){
		$value = utf8_decode($value);
	});
	
	$userDB = Model::factory('Users')->create();
	$userDB->name = utf8_decode($user->name);
	$userDB->surname =  utf8_decode($user->surname);
	$userDB->email =  $user->email;
	$userDB->password =  md5($user->password);
	$userDB->role =  $user->role;
	$userDB->thumbnail =  $user->thumbnail;
	$userDB->isActive =  $user->isActive;
	
	try{
		$userDB->save();
		exit('{"success": "true"}');
	}catch(Exception $e){
		exit('{"error": '.$e->getMessage().'}');
	}
	
})->name("API_AddNewUser");