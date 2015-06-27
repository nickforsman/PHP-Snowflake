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

        if ($response === true) {
            Response::send(200);
        } else {
            Response::send(404);
            $this->getFourOFour();
        }

    }

    public function dispatch() 
    {
        $this->request->listen($_SERVER);

        $method = $this->request->getMethod();
        $uri = $this->request->getUri();
        
        $route = $method . $uri;

        return array_key_exists($route, $this->routes) ? true : false; 
    }

    public static function getFourOFour() 
    {
        ob_start();
        ?>
            <!DOCTYPE html>
            <html>
                <head>
                    <meta charset="utf-8"/>
                    <title>Snowflake 404 Page</title>
                </head>
                <body>
                <h1>404</h1>
                <h3>The Requested Route Cloud Not Be Found!</h3>
                </body>
            </html>
        <?php    
        return ob_end_flush();
    }

    public function get($uri, $settings = [], Closure $callback) 
    {
        $this->addRoute('GET', $uri, $settings);

        return $this;
    }

    public function post($uri, $settings = [], Closure $callback) 
    {
        $this->addRoute('POST', $uri, $settings);

        return $this;
    }

    public function put($uri, $settings = [], Closure $callback) 
    {
        $this->addRoute('PUT', $uri, $settings);

        return $this;
    }
    
    public function delete($uri, $settings = [], Closure $callback) 
    {
        $this->addRoute('DELETE', $uri, $settings);

        return $this;
    }        

    protected function addRoute($method, $uri, $settings = [])
    {
        $this->routes[$method.$uri] = ['method' => $method, 'uri' => $uri, 'settings' => $settings];
    }

}
