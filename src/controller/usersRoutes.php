<?php

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
})->name("AddUserPost");

$app->get('/users/:id', function ($id) use($app){
	$user = Model::factory('Users')->find_one($id);
	$contact = Model::factory('Contacts')->where('userId', $id)->findOne();

	if (! $user instanceof Users) {
		$app->redirect($app->urlFor("Error404"));
	}
	$app->render('user_Profile.twig', array(
			'app' => $app,
			'user' => $user,
			'contact' => $contact
	));
})->name("UserProfile");