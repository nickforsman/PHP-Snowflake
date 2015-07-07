<?php

require_once __DIR__.'/vendor/autoload.php';

$app = new Snowflake\Snowflake();

$app->get('/home', ['header' => 'Application/json'], function() use ($app) {
	
	$data = ['name' => 'John Cena'];

	$app->render('hello.php', $data);
});

$app->get('/contact', [], function() {
	echo "Not moi";
});

$app->put('/about', [], function() {
	echo "Hello";
});

$app->setRouter(new Snowflake\Routing\Router($app->getRegisteredRoutes()));

$app->start();
