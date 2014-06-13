<?php

//Home page
$app->get('/', function () use($app){
	$app->render('base.twig', array(
			'app' => $app
	));
})->name("HomePage");


$app->get('/login/', function () use($app){
	$app->render('login.twig', array(
			'app' => $app
	));
})->name("Login");


 require './src/api/api.php';
 
 require './src/controller/usersRoutes.php';