<?php

require_once 'vendor/autoload.php';

$app = new Snowflake\Snowflake();

$app->get('/home', ['controller' => 'HomeController@index'], function() {
	echo "asdasfgdgfd";
});

$app->start();
