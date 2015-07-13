<?php

namespace Snowflake\Http;

use Snowflake\Exceptions\InvalidRequestException;
use Snowflake\Exceptions\UnsupportedMethodException;

class Request 
{

	/**
	 * @var string The HTTP method
	 */
	public $method;

	/**
	 * @var string The full url e.g http://localhost/home
	 */
	public $fullUrl;

	/**
	 * @var string The uri
	 */
	public $uri;

	/**
	 * @var array The supported Http methods
	 */
	public static $supportedMethods = ['GET', 'POST', 'PUT', 'DELETE'];

	/**
	 * @var array The unsupported Http methods
	 */
	public static $unsupportedMethods = ['PATCH', 'OPTIONS', 'TRACE', 'HEAD'];

	/**
	 * Listens for http requests and proccessess them
	 * @param array $request And array of Http settings
	 * @throws InvalidRequestException
	 * @throws UnsupportedMethodException
	 * @throws \Exception
	 */
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
			throw new \Exception("Error Processing Request", 422);
		}
	}

	/**
	 * Get the http method
	 * @return string Http method
	 */
	public function getMethod() 
	{
		return $this->method;
	}

	/**
	 * Get the full url
	 * @return string http://localhost/home
	 */
	public function getFullUrl() 
	{
		return $this->fullUrl;
	}

	/**
	 * Get the route
	 * @return string The route
	 */
	public function getRoute() 
	{
		return $this->method . $this->uri;
	}

	/**
	 * Get the uri
	 * @return string The uri
	 */
	public function getUri() 
	{
		return $this->uri;
	}

}