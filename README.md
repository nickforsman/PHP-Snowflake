# PHP-Snowflake
[![Build Status](https://travis-ci.org/nickforsman/PHP-Snowflake.svg?branch=master)](https://travis-ci.org/nickforsman/PHP-Snowflake)

## Snowflake: Simple php microframework
Snowflake is a php microframework, inspired by a random redditor who also created a php microframework.
Snowflake does not use any 3rd party libraries, everything is built from the ground up.
Snowflake is heavily influenced by its many counterparts, Lumen, Slim...etc.

Warning:
> This "framework" should never be used in production...or anywhere else.
> This was just a test applicaiton I created.
> If you want to use real micro frameworks, checkout lumen, slim and silex.

## How it works
#### Start the app
```php
$app = new Snowflake\Snowflake();
```
#### Register a route
```php
$app->get('/home', [], function() {
	echo "Hello World";
});
```
###### You can also register a controller
```php
$app->post('/home', ['controller' => 'HomeController@index']);
```
###### You can also send custom headers
```php
$app->get('/home', ['header' => 'Application/json'], function() {
	return "Hello World";
});
```
#### Inject the router
```php
$app->setRouter(new Snowflake\Routing\Router($app->getRegisteredRoutes()));
```
#### Run the application
```php
$app->start();
```