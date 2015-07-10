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
            return $this->call($this->routes[$route]);
        }
	}

    protected function call($action) 
    {
        if (isset($action['function']) && ! isset($action['settings']['controller'])) {
            return call_user_func($action['function']);
        } else {
            throw new \InvalidArgumentException("Please define a function or a controller for this route!");
        }
    }

	public function getRouteSettings($route) 
	{
		return isset($this->routes[$route]['settings']) ? $this->routes[$route]['settings'] : null;
	}

	public function getRoutes() 
	{
		return $this->routes;
	}

}