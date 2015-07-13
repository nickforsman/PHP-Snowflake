<?php

namespace Snowflake;

use Snowflake\View\View;
use Snowflake\Http\Request;
use Snowflake\Http\Response;
use Snowflake\Helpers\Input;
use Snowflake\Exceptions\UnResolvableDependencyException;

class Ioc 
{
    /**
     * @var array All dependencies are stored here
     */
	protected static $data = [];

    /**
     * Constructor
     */
	public function __construct() 
	{
        self::register([
            'Input' => function() {
            return new Input();
        }, 'Request' => function() {
            return new Request();
        }, 'Response' => function($settings) {
            return new Response($settings);
        }, 'View' => function() {
            return new View();
        }]
        );
	}

    /**
     * Register dependency to container
     * @param array | string $dependency to be added to container
     * @param array $data optional arguments for the dependency
     */
	public static function register($dependencies, $data = []) 
	{
        if (is_array($dependencies)) {
            foreach ($dependencies as $name => $value) {
                static::$data[$name] = $value;
            }
        } else {
            static::$data[$dependencies] = $data;
        }
	}

    /**
     * Resolves dependency from container
     * @param string $name The dependency to be resolved
     * @param array $args Optional arguments for dependency
     * @return mixed New instance of the dependency
     * @throws UnResolvableDependencyException
     */
	public function resolve($name, $args = []) 
	{
        if (isset(static::$data[$name])) {
            return call_user_func_array(static::$data[$name], $args);
        } else {
            throw new UnResolvableDependencyException("Could not resolve dependency"); 
        }
	}
}
