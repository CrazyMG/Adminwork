<?php
session_start();
$app->get('/users/', function () use($app){
	$app->applyHook('hook.auth', "/users/");
	$app->render('users.twig', array(
			'app' => $app,
			'users' => Model::factory("Users")->find_many()
	));
})->name("Users");

$app->post('/users/add/', function () use($app){
	
	$request = $app->request();
	$postVars = $request->post();
	$url = $request->getUrl() . $app->urlFor("API_AddNewUser");
	
	array_walk_recursive($postVars, function(&$value){
		$value = utf8_encode($value);
	});
	
	$response = \Httpful\Request::post($url)    // Build a POST request...
	->sendsJson()                               // tell it we're sending (Content-Type) JSON...
	->body(json_encode($postVars))             	// attach a body/payload...
	->send();                                   // and finally, fire that thing off!
		
	$body = $response->body;
	$resp = json_decode($body);
	
// 	if(property_exists($resp, "errore")){
// 		$app->render('errore.twig', array(
// 			'app' => $app,
// 			'errore' => $resp->errore
// 		));
// 	}
// 	else if(property_exists($resp, "successo")){
// 		$app->redirect($app->urlFor("Clienti"));
// 	}
})->name("AddUserPost");