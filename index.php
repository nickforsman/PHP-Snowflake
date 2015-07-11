<?php

require_once __DIR__.'/vendor/autoload.php';

$app = new Snowflake\Snowflake();

$app->config = require_once __DIR__.'/resources/main.php';

$app->get('/home', [], function() use ($app) {
	
	$data = ['name' => 'John Cena'];
	$app->render('hello.php', $data);
})
->get('/contact', ['controller' => 'HomeController@index'])
->put('/about', [], function() {
	echo "Hello";
});

$app->setRouter(new Snowflake\Routing\Router($app->getRegisteredRoutes()));

$app->start();
