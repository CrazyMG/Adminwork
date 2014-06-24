<?php
session_start();
$app->post('/api/login', function () use($app){
	
	$json = $app->request()->getBody();
	$credentials = json_decode($json);
	
	array_walk_recursive($credentials, function(&$value){
		$value = utf8_decode($value);
	});
	
	
	try{
		$userDB = Model::factory('Users')->where('email', $credentials->email)->where('password', md5($credentials->password))->findOne();
		if($userDB instanceof Users){

			exit('{"success": "true",
				   "role": "'.$userDB->role.'",
				   "name": "'.$userDB->name.'",
				   "surname": "'.$userDB->surname.'",
				   "thumbnail": "'.$userDB->thumbnail.'"}');
		}else{
			session_destroy();
			exit('{"error": "false"}');
		}
	}catch(Exception $e){
		exit('{"error": "'.$e->getMessage().'"}');
	}
})->name("API_Login");