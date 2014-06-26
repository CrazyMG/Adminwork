<?php

$app->get('/clients/', function () use($app){
	$app->applyHook('hook.auth', "/clients/");
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
	if (! $client instanceof Clients) {
		$app->redirect($app->urlFor("Error404"));
	}
	$app->render('client_Profile.twig', array(
			'app' => $app,
			'client' => $client
	));
})->name("ClientProfile");