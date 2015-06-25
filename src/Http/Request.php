<?php

namespace Snowflake\Http;

use Snowflake\Exceptions\InvalidRequestException;
use Snowflake\Exceptions\UnsupportedMethodException;

class Request 
{

	public $method;
	public $url;

	public static $supportedMethods = ['GET', 'POST', 'PUT', 'DELETE'];
	public static $unsupportedMethods = ['PATCH', 'OPTIONS', 'TRACE'];

	public function listen($request) 
	{
		if ( ! is_array($request)) {
			throw new InvalidRequestException("Invalid request", 422);
		}

		if (in_array($request['REQUEST_METHOD'], self::$supportedMethods)) {
			$this->method = $request['REQUEST_METHOD'];
			$this->route = $request['REQUEST_URI'];
			$this->url = $request['HTTP_HOST'] . $request['REQUEST_URI'];
		} else {
			throw new UnsupportedMethodException("Snowflake does not support this HTTP METHOD", 500);
		}
	}

	public function getMethod() 
	{
		return $this->method;
	}

	public function getUrl() 
	{
		return $this->url;
	}

	public function getRoute() 
	{
		return $this->route;
	}
}