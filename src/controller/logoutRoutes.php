<?php

$app->get('/logout/', function () use($app){
	session_destroy();
	$app->redirect($app->urlFor("Login"));
})->name("Logout");