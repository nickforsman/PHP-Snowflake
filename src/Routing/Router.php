<?php

namespace Snowflake\Routing;

class Router 
{
    /**
     * @var array The routes set by the application
     */
	public $routes = [];

    /**
     * @var string The namespace for the controllers
     */
    public $namespace;

    /**
     * Constructor
     * @param array $routes The registered routes for the applicaition
     * @param array $data Optional settings for this class, e.g controller namespace
     */
	public function __construct($routes, $data = []) 
	{
		$this->routes = $routes;

        if (isset($data['namespace'])) {
            $this->setNamespace($data['namespace']);
        }
	}

    /**
     * Returns the requested route
     * @param string $route the route name
     * @return mixed New instance of callback or controller
     */
	public function render($route) 
	{
		if (isset($this->routes[$route])) {
            return $this->call($this->routes[$route]);
        }
	}

    /**
     * Instantiate the route controller or callback
     * @param string $route the route name
     * @return mixed New instance of callback or controller
     * @throws \InvalidArgumentException
     */
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

    /**
     * Calls the route controller
     * @param array $action the settings array
     * @return mixed New instance of controller
     * @throws \Exception
     */
    private function callActionController($action) 
    {
        list($controller, $method) = explode("@", $action['controller']);
        $class = $this->namespace . $controller;
        
        $class = preg_replace('/\s+/', '', $class);

        if (class_exists($class)) {
            $newclass = new $class();
            if (method_exists($newclass, $method)) {
                return call_user_func([$newclass, $method]);
            }
            throw new \Exception("Method $method was not found in class $class", 404);
        }

        throw new \Exception("Controller $class was not found", 404);
    }

    /**
     * Returns the settings array for a route
     * @param string $route The route name
     * @return array | null
     */
	public function getRouteSettings($route) 
	{
		return isset($this->routes[$route]['settings']) ? $this->routes[$route]['settings'] : null;
	}

    /**
     * Gets all routes
     * @return array Routes array
     */
	public function getRoutes() 
	{
		return $this->routes;
	}

    /**
     * Sets the namespace for the applcation
     * @param string $namespace The namespace for the controllers
     */
    public function setNamespace($namespace)
    {
        $this->namespace = $namespace;
    }

}