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
    /**
     * @const string 
     */
    const VERSION = '0.0.1'; 

    /**
     * @var Snowflake\Http\Request
     */
    protected $request;

    /**
     * @var Snowflake\Routing\Router
     */
    protected $router;

    /**
     * @var Snowflake\View\View
     */
    protected $view;

    /**
     * @var Snowflake\Helpers\Input
     */
    protected $input;

    /**
     * @var array application routes
     */
    public $routes = [];

    /**
     * @var array of configurations for Snowflake
     */
    public $config;

    /**
     * Constructor calls parent constructor and resolves 
     * Dependencies from the Ioc container
     */
    public function __construct() 
    {
        parent::__construct();
        $this->request = $this->resolve('Request');
        $this->view = $this->resolve('View');
        $this->input = $this->resolve('Input');
        $this->input->createFromGlobals();
    }

    /**
     * Start the application and listen for http requests
     */
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

    /**
     * Listen for http requests and return route
     * @param array of request settings
     * @return string | null
     */
    public function dispatch($server) 
    {
        if (isset($server)) {
            $this->request->listen($server);
            $route = $this->request->getRoute();
            return isset($this->routes[$route]) ? $route : null; 
        }
    }

    /**
     * 404 page for application
     * Can be called statically
     * App::getFourOFour
     * @return string
     */
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

    /**
     * Get route for application
     * Route will be added to
     * Routes array
     * @param string $uri the uri for the route
     * @param array $settings Optional settings for the array
     * @param mixed $callback An instance of Closure
     * @return this
     */
    public function get($uri, $settings = [], Closure $callback = null) 
    {
        $this->addRoute('GET', $uri, $settings, $callback);

        return $this;
    }
    
    /**
     * Post route for application
     * Route will be added to
     * Routes array
     * @param string $uri the uri for the route
     * @param array $settings Optional settings for the array
     * @param mixed $callback An instance of Closure
     * @return this
     */
    public function post($uri, $settings = [], Closure $callback = null) 
    {
        $this->addRoute('POST', $uri, $settings, $callback);

        return $this;
    }

    /**
     * Put route for application
     * Route will be added to
     * Routes array     
     * @param string $uri the uri for the route
     * @param array $settings Optional settings for the array
     * @param mixed $callback An instance of Closure
     * @return this
     */
    public function put($uri, $settings = [], Closure $callback = null) 
    {
        $this->addRoute('PUT', $uri, $settings, $callback);

        return $this;
    }
    
    /**
     * Delete route for application
     * Route will be added to
     * Routes array 
     * @param string $uri the uri for the route
     * @param array $settings Optional settings for the array
     * @param mixed $callback An instance of Closure
     * @return this
     */
    public function delete($uri, $settings = [], Closure $callback = null) 
    {
        $this->addRoute('DELETE', $uri, $settings, $callback);

        return $this;
    }

    /**
     * Adds routes to routes property array
     * @param string $method HTTP method
     * @param string $uri The uri for the route
     * @param array $settings The Optional array
     * @param mixed $function Optional callback
     * @throws \InvalidArgumentException
     */
    protected function addRoute($method, $uri, $settings = [], $function)
    {
        if (isset($settings['controller']) && ! is_null($function)) {
            throw new \InvalidArgumentException("You can only define a closure or a controller");
        }

        $this->routes[$method.$uri] = ['method' => $method, 'uri' => $uri, 'settings' => $settings, 'function' => $function];
    }

    /**
     * Returns all the routes that are
     * Currently registered in the app
     * @return array The routes array
     */
    public function getRegisteredRoutes() 
    {
        return $this->routes;
    }

    /**
     * Inject the router object
     * The Router object requires
     * The routes from the app
     * And is therefore inject via setter
     * @param mixed $router The router class
     */
    public function setRouter($router) 
    {
        $this->router = $router;
    }

    /**
     * The render method renders view templates
     * @param string $template The file name for the template
     * @param array $data Optional variables passed to view 
     */
    public function render($template, $data = []) 
    {
        $this->view->run($template, $data);
    }

    /**
     * Returns the config array
     * @return array Configuration array
     */
    public function getConfig() 
    {
        return $this->config;
    }

    /**
     * Loads configurations from the
     * Configuration array
     * @param string $config The configuration key to be loaded, e.g 'db'
     * @param string $value The specific value to be loaded with the key, e.g 'host'
     * @return string $property E.g db,host, would return localhost
     * @throws \Exception
     */
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
