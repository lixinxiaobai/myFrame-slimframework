<?php

$app->get('/', function ($request, $response, $args) {
	$tickets = 'hello world';
	$response = $this->view->render($response, "tickets.html", [
			"tickets" => $tickets,
			"cache" => 1
	]);
	return $response;
});

$app->get('/hello/[{name}]', function ($request, $response, $args) {
    $response->write('Hello, ' . $args['name']);
    return $response;
});

