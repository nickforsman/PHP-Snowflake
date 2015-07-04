<?php

namespace Snowflake;

use Closure;
use Snowflake\Http\Request;
use Snowflake\Http\Response;
use Snowflake\Helpers\Input;
use Snowflake\Routing\Router;

class Snowflake 
{

    const VERSION = '0.0.1'; 

    protected $request;
    protected $router;
    protected $view;
    protected $routes = [];
    protected $input;

    public function __construct() 
    {
        $this->request = new Request();
        $this->view = new View();
        $this->input = new Input();
        $this->input->createFromGlobals();
    }

    public function start() 
    {
        $request = $this->dispatch();

        if ( ! is_null($request)) {
            Response::send(200);
            $this->router->render($request);
        } else {
            Response::send(404);
            $this->getFourOFour();
        }

    }

    public function dispatch() 
    {
        $server = $this->input->key('server');
        if (isset($server)) {
            $this->request->listen($server);
            $method = $this->request->getMethod();
            $uri = $this->request->getUri();
            $route = $method . $uri;
            return array_key_exists($route, $this->routes) ? $route : null; 
        }
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
                <h3>The Requested Route Could Not Be Found!</h3>
                </body>
            </html>
        <?php    
        return ob_end_flush();
    }

    public function get($uri, $settings = [], Closure $callback = null) 
    {
        $this->addRoute('GET', $uri, $settings, $callback);

        return $this;
    }

    public function post($uri, $settings = [], Closure $callback = null) 
    {
        $this->addRoute('POST', $uri, $settings, $callback);

        return $this;
    }

    public function put($uri, $settings = [], Closure $callback = null) 
    {
        $this->addRoute('PUT', $uri, $settings, $callback);

        return $this;
    }
    
    public function delete($uri, $settings = [], Closure $callback = null) 
    {
        $this->addRoute('DELETE', $uri, $settings, $callback);

        return $this;
    }

    protected function addRoute($method, $uri, $settings = [], $function)
    {
        $this->routes[$method.$uri] = ['method' => $method, 'uri' => $uri, 'settings' => $settings, 'function' => $function];
    }

    public function getRegisteredRoutes() 
    {
        return $this->routes;
    }

    public function setRouter($router) 
    {
        $this->router = $router;
    }

    public function render($template, $data = []) 
    {
        $this->view->run($template, $data);
    }

}
