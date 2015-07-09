<?php

namespace Snowflake;

use Snowflake\Http\Request;
use Snowflake\Http\Response;
use Snowflake\Helpers\Input;
use Snowflake\Exceptions\UnResolvableDependencyException;

class Ioc 
{
	protected static $data = [];

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

	public function resolve($name, $args = []) 
	{
        if (array_key_exists($name, static::$data)) {
            return call_user_func_array(static::$data[$name], $args);
        } else {
            throw new UnResolvableDependencyException("Could not resolve dependency"); 
        }
	}
}
