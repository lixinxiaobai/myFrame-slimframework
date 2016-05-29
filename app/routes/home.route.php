<?php

$app->group('/', function () use ($app){

	$app->get('', function ($request, $response) {
		return $response->getBody()->write(date('Y-m-d H:i:s'));
	});

	$app->get('time', function ($request, $response) {
		return $response->getBody()->write(time());
	});

})->add($authenticate);


$app->get('/login',function($request, $response){
	return $this->view->render($response, "login.html");
});

//$app->get('/', function ($request, $response, $args) {
//	$tickets = 'hello world';
//	$response = $this->view->render($response, "tickets.html", [
//			"tickets" => $tickets,
//			"cache" => 1
//	]);
//	return $response;
//});

$app->get('/hello/[{name}]', function ($request, $response, $args) {
    $response->write('Hello, ' . $args['name']);
    return $response;
});

