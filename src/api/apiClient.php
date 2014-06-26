<?php

$app->post('/api/clients/add/', function () use($app){

	$json = $app->request()->getBody();
	$client = json_decode($json);

	array_walk_recursive($client, function(&$value){
		$value = utf8_decode($value);
	});

		$clientDB = Model::factory('Clients')->create();
		$clientDB->organization = utf8_decode($client->name);
		$clientDB->description = $client->description;
		$clientDB->website = $client->website;

		try{
			$clientDB->save();
			exit('{"success": "true"}');
		}catch(Exception $e){
			exit('{"error": '.$e->getMessage().'}');
		}

})->name("API_AddNewClient");