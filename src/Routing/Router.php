<?php

namespace Snowflake\Routing;

class Router 
{
	public $routes = [];

	public function __construct($routes) 
	{
		$this->routes = $routes;
	}

	public function render($route) 
	{
		// $router->render('GET/home');
	}

	public function getRoutes() 
	{
		return $this->routes;
	}

}