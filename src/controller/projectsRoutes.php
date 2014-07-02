<?php
$app->post('/projects/add/', function() use($app){
	$request = $app->request();
	$postVars = $request->post();
	$url = $request->getUrl() . $app->urlFor("API_AddNewProject");
	
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
		//gestisci error
	}else{
		//gestisci successo
	}
})->name("AddProject");