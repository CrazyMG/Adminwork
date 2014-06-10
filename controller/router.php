<?php

//Home page
$app->get('/', function () use($app){
	$app->render('base.twig', array(
			'app' => $app
	));
})->name("HomePage");

//Bla bla
$app->get('/users/', function () use($app){
	$app->render('users.twig', array(
			'app' => $app
	));
})->name("Users");