<?php

namespace Snowflake\Http;

use Snowflake\Exceptions\InvalidRequestException;
use Snowflake\Exceptions\UnsupportedMethodException;

class Request 
{

	public $method;
	public $fullUrl;
	public $uri;

	public static $supportedMethods = ['GET', 'POST', 'PUT', 'DELETE'];
	public static $unsupportedMethods = ['PATCH', 'OPTIONS', 'TRACE'];

	public function listen($request) 
	{
		if ( ! is_array($request)) {
			throw new InvalidRequestException("Invalid request", 422);
		}

		if (in_array($request['REQUEST_METHOD'], self::$supportedMethods)) {
			
			$this->method = $request['REQUEST_METHOD'];
			$this->uri = $request['REQUEST_URI'];
			$this->fullUrl = $request['HTTP_HOST'] . $request['REQUEST_URI'];

		} else if (in_array($request['REQUEST_METHOD'], self::$unsupportedMethods)) {
			throw new UnsupportedMethodException("Snowflake does not support this HTTP METHOD", 500);

		} else {
			throw new \Exception("Error Processing Request", 1);
		}
	}

	public function getMethod() 
	{
		return $this->method;
	}

	public function getFullUrl() 
	{
		return $this->fullUrl;
	}

	public function getUri() 
	{
		return $this->uri;
	}
}