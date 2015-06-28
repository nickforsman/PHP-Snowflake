<?php

require_once __DIR__.'/vendor/autoload.php';

$app = new Snowflake\Snowflake();

$app->get('/home', ['controller' => 'HomeController@index'], function() {
	echo "Moi";
});

$app->put('/about', [], function() {
	echo "Hello";
});

$app->setRouter(new Snowflake\Routing\Router($app->getRegisteredRoutes()));

$app->start();
