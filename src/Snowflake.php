<?php

namespace Snowflake;

use Closure;
use Snowflake\Ioc;
use Snowflake\View\View;
use Snowflake\Http\Request;
use Snowflake\Http\Response;
use Snowflake\Helpers\Input;
use Snowflake\Routing\Router;

class Snowflake extends Ioc
{

    const VERSION = '0.0.1'; 

    protected $request;
    protected $router;
    protected $view;
    public $routes = [];
    protected $input;
    public $config;

    public function __construct() 
    {
        parent::__construct();
        $this->request = $this->resolve('Request');
        $this->view = $this->resolve('View');
        $this->input = $this->resolve('Input');
        $this->input->createFromGlobals();
    }

    public function start() 
    {
        $request = $this->dispatch($this->input->key('server'));
        $response = $this->resolve('Response', [$this->router->getRouteSettings($request)]);

        if ( ! is_null($request)) {
            $response->sendHeader();
            $this->router->render($request);
        } else {
            $response->sendFourOFour();
            $this->getFourOFour();
        }

    }

    public function dispatch($server) 
    {
        if (isset($server)) {
            $this->request->listen($server);
            $route = $this->request->getRoute();
            return isset($this->routes[$route]) ? $route : null; 
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
        if (isset($settings['controller']) && ! is_null($function)) {
            throw new \InvalidArgumentException("You can only define a closure or a controller");
        }

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

    public function getConfig() 
    {
        return $this->config;
    }

    public function load($config, $value) 
    {
        if (isset($this->config[$config])) {
            $configArray = $this->config[$config];
            if (isset($configArray[$value])) {
                foreach ($configArray as $data => $property) {
                    if ($data === $value) {
                        return $property;
                        break;
                    } 
                }
            } else {
                throw new \Exception("Configuration {$config} does not contain {$value}!");
            }
        }
        throw new \Exception("The configuration file does not contain {$config} configuration.");
    }

}
