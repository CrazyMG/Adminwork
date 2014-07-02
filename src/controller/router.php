<?php

//Home page
$app->get('/', function () use($app){
	$app->applyHook('hook.auth', "/");
	$app->render('base.twig', array(
			'app' => $app
	));
})->name("HomePage");

$app->get('/error404', function () use($app){
	$app->render('error404.twig', array(
			'app' => $app
	));
})->name("Error404");

 require './src/api/api.php';
 
 require './src/controller/loginRoutes.php';
 
 require './src/controller/logoutRoutes.php';
 
 require './src/controller/clientsRoutes.php';
 
 require './src/controller/usersRoutes.php';
 
 require './src/controller/projectsRoutes.php';