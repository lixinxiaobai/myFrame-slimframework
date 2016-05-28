<?php

$app->get('/hello/{name}', function ($request, $response, $args) {
    $response->write('Hello, ' . $args['name']);
    return $response;
});

$app->get('/', function ($request, $response, $args) {
	
	$tickets = 'hello world';
	$a = NewTable::get_name(1);
    $response = $this->view->render($response, "tickets.html", [
    	"tickets" => $tickets,
    	"a"		  => $a
	]);
});