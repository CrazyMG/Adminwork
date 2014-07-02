<?php

$app->get('/clients/', function () use($app){
	$app->render('clients.twig', array(
			'app' => $app,
			'clients' => Model::factory("Clients")->find_many()
	));
})->name("Clients");

$app->post('/clients/add/', function () use($app){
	$request = $app->request();
	$postVars = $request->post();
	$url = $request->getUrl() . $app->urlFor("API_AddNewClient");

	array_walk_recursive($postVars, function(&$value){
		$value = utf8_encode($value);
	});

		$response = \Httpful\Request::post($url)    // Build a POST request...
		->sendsJson()                               // tell it we're sending (Content-Type) JSON...
		->body(json_encode($postVars))             	// attach a body/payload...
		->send();                                   // and finally, fire that thing off!

		$body = $response->body;
		$resp = json_decode($body);
		
})->name("AddClientPost");

$app->get('/clients/:id', function ($id) use($app){
	$client = Model::factory('Clients')->find_one($id);
	$projects = Model::factory('Projects')->where('clientId', $id)->find_many();
	$contacts = Model::factory('Contacts')->where('clientId', $id)->where('isMain', false)->find_many();
	$main_contact = Model::factory('Contacts')->where('clientId', $id)->where('isMain', true)->findOne();
	$users = Model::factory('Users')->find_many();
	
	if (! $client instanceof Clients) {
		$app->redirect($app->urlFor("Error404"));
	}
	$app->render('client_Profile.twig', array(
			'app' => $app,
			'users' => $users,
			'client' => $client,
			'projects' => $projects,
			'contacts' => $contacts,
			'main_contact' => $main_contact
	));
})->name("ClientProfile");

$app->post('/client/contact/add/', function () use($app){
	$request = $app->request();
	$postVars = $request->post();
	$url = $request->getUrl() . $app->urlFor("API_AddNewClientContact");

	array_walk_recursive($postVars, function(&$value){
		$value = utf8_encode($value);
	});
		
		$response = \Httpful\Request::post($url)    // Build a POST request...
		->sendsJson()                               // tell it we're sending (Content-Type) JSON...
		->body(json_encode($postVars))             	// attach a body/payload...
		->send();          
		
		$body = $response->body;
		$resp = json_decode($body);
		
})->name("AddContactPost");