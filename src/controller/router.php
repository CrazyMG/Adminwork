<?php

//Home page
$app->get('/', function () use($app){
	$app->render('base.twig', array(
			'app' => $app
	));
})->name("HomePage");

 require './src/api/api.php';
 
 require './src/controller/loginRoutes.php';
 
 require './src/controller/logoutRoutes.php';
 
 require './src/controller/usersRoutes.php';