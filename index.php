<?php

require_once 'vendor/autoload.php';

$app = new Snowflake\Snowflake();

$app->get('/home', ['controller' => 'HomeController@index'], function() {
	echo "Moi";
});

$app->put('/about', [], function() {
	echo "Hello";
});

$app->start();
