<?php


$app->get('/login/', function () use($app){
	$app->render('login.twig', array(
			'app' => $app
	));
})->name("Login");

$app->post('/login/check/', function() use($app){
	$request = $app->request();
	$postVars = $request->post();
	$url = $request->getUrl() . $app->urlFor("API_Login");

	array_walk_recursive($postVars, function(&$value){
		$value = utf8_encode($value);
	});
	
	$response = \Httpful\Request::post($url)    // Build a POST request...
	->sendsJson()                               // tell it we're sending (Content-Type) JSON...
	->body(json_encode($postVars))             	// attach a body/payload...
	->send();                                   // and finally, fire that thing off!

	$body = $response->body;
	$resp = json_decode($body);
	
	if(property_exists($resp, "error")){
		session_destroy();
		$app->redirect($app->urlFor("Login"));
	}else{
		$_SESSION['user_role'] = $resp->role;
		$_SESSION['userFirstname'] = $resp->name;
		$_SESSION['userLastname'] = $resp->surname;
		$_SESSION['userThumbnail'] = $resp->thumbnail;
		
		var_dump($_SESSION);
		if(!array_key_exists('pathTo', $_SESSION)){
			$_SESSION['pathTo'] = "/";
		}
		var_dump($_SESSION);
		$app->redirect($_SESSION['pathTo']);
	}
})->name("CheckLogin");