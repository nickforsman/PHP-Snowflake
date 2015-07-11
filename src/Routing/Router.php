<?php

namespace Snowflake\Routing;

class Router 
{
	public $routes = [];

    public $params = [];

    public static $namespace = 'Snowflake\\Controllers\\';

	public function __construct($routes, $data = []) 
	{
		$this->routes = $routes;

        if (array_key_exists('namespace', $data)) {
            self::$namespace = $data['namespace'];
        }
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
        } else if ( ! isset($action['function']) && isset($action['settings']['controller'])) {
            return $this->callActionController($action['settings']);
        } else {
            throw new \InvalidArgumentException("Please define a function or a controller for this route!");
        }
    }

    private function callActionController($action) 
    {
        list($controller, $method) = explode("@", $action['controller']);
        $class = self::$namespace . $controller;
        
        $class = preg_replace('/\s+/', '', $class);

        if (class_exists($class)) {
            if (method_exists($class, $method)) {
                return call_user_func([$class, $method]);
            }
        }

        throw new \Exception("Controller $class was not found", 404);
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