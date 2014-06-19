<?php

$app->get('/login/', function () use($app){
	$app->render('login.twig', array(
			'app' => $app
	));
})->name("Login");

$app->post('/login/check/', function() use($app){
	$request = $app->request();
	$email = $request->post('email');
	$pass = $request->post('password');
	
	
// 	array_walk_recursive($postVars, function(&$value){
// 		$value = utf8_encode($value);
// 	});

	$checkLogin = false;
	$userDB = Model::factory('Users')->where('email', $email)->where('password', md5($pass))->findOne();
	if($userDB instanceof Users){
			$checkLogin = true;
	}
	
	if($checkLogin == false){
		$app->redirect($app->urlFor("Login"));
	}else{
		$app->redirect($app->urlFor("HomePage"));
	}
})->name("CheckLogin");