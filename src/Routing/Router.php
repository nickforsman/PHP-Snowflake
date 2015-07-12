<?php

namespace Snowflake\Routing;

class Router 
{
	public $routes = [];

    public $params = [];

    public $namespace = 'Snowflake\\Controllers\\';

	public function __construct($routes, $data = []) 
	{
		$this->routes = $routes;

        if (isset($data['namespace'])) {
            $this->setNamespace($data['namespace']);
        }
	}

	public function render($route) 
	{
		if (isset($this->routes[$route])) {
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
        $class = $this->namespace . $controller;
        
        $class = preg_replace('/\s+/', '', $class);

        if (class_exists($class)) {
            if (method_exists($class, $method)) {
                return call_user_func([$class, $method]);
            }
            throw new \Exception("Method $method was not found in class $class", 404);
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

    public function setNamespace($namespace)
    {
        $this->namespace = $namespace;
    }

}