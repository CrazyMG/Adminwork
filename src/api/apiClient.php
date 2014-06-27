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
			if(isset($client->address)){
				$contactDB = Model::factory('Contacts')->create();
				$contactDB->referent = utf8_decode($client->name);
				$contactDB->address = $client->address;
				$contactDB->phone = $client->phone;
				$contactDB->fax = $client->fax;
				$contactDB->email = $client->email;
				$contactDB->latitude = $client->latitude;
				$contactDB->longitude = $client->longitude;
				$contactDB->isMain = true;
				$contactDB->clientId = $clientDB->clientId;
				$contactDB->save();
			}
			exit('{"success": "true"}');
		}catch(Exception $e){
			exit('{"error": '.$e->getMessage().'}');
		}
})->name("API_AddNewClient");

$app->post('/api/client/contact/add/', function () use($app){
	
	$json = $app->request()->getBody();
	$contact = json_decode($json);

	array_walk_recursive($contact, function(&$value){
		$value = utf8_decode($value);
	});
			$contactDB = Model::factory('Contacts')->create();
			
			$contactDB->referent = utf8_decode($contact->referent);
			$contactDB->email = $contact->email;
			$contactDB->phone = $contact->phone;
			$contactDB->fax = $contact->fax;
			$contactDB->address = $contact->address;
			$contactDB->latitude = $contact->latitude;
			$contactDB->longitude = $contact->longitude;
			$contactDB->isMain = false;
			$contactDB->clientId = $contact->clientId;
			$contactDB->save();

})->name("API_AddNewClientContact");