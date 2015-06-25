<?php

namespace Snowflake;

use Closure;
use Snowflake\Http\Request;

class Snowflake 
{

    const VERSION = '0.0.1'; 

    protected $request;

    public function __construct() 
    {
        $this->request = new Request();
    }

    public function start() 
    {
        $response = $this->dispatch();
        Response::send($response);
    }

    public function dispatch() 
    {
        if (isset($_SERVER)) {
            $this->request->listen($_SERVER);
            $method = $this->request->getMethod();
            $route = $this->request->getRoute();
        }
    }

    public function get($uri, $settings = [], Closure $callback) 
    {
        $this->addRoute('GET', $uri, $settings);
    }

    protected function addRoute($method, $uri, $settings)
    {
        
    }

}
