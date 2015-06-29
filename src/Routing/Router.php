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
		if (array_key_exists($route, $this->routes)) {
            $properties = $this->routes[$route];

            if (isset($properties['function']) && isset($properties['settings']['controller'])) {
                throw new \InvalidArgumentException("You can only define a closure or a controller");
            } else if (isset($properties['function']) && ! isset($properties['settings']['controller'])) {
                return call_user_func($properties['function']);
            } else {
                throw new \InvalidArgumentException("Please define a function or a controller for this route!");
            }
        }
	}

	public function getRoutes() 
	{
		return $this->routes;
	}

}