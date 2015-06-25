<?php

namespace Snowflake;

use Closure;
use Snowflake\Http\Request;
use Snowflake\Http\Response;

class Snowflake 
{

    const VERSION = '0.0.1'; 

    protected $request;

    protected $routes = [];

    public function __construct() 
    {
        $this->request = new Request();
    }

    public function start() 
    {
        $response = $this->dispatch();
        echo Response::send($response);
    }

    public function dispatch() 
    {
        if (isset($_SERVER)) {
            $this->request->listen($_SERVER);
            $method = $this->request->getMethod();
            $uri = $this->request->getUri();
            
            $route = $method . $uri;

            if (array_key_exists($route, $this->routes)) {
                return $route;
            }
            
        }

        return $this->routes;
    }

    public function get($uri, $settings = [], Closure $callback) 
    {
        $this->addRoute('GET', $uri, $settings);

        return $this;
    }

    protected function addRoute($method, $uri, $settings = [])
    {
        $this->routes[$method.$uri] = ['method' => $method, 'uri' => $uri, 'settings' => $settings];
    }

}
