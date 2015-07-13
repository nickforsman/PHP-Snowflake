<?php

namespace Snowflake\Helpers;

class Input 
{
	/**
	 * @var array An array of the PHP superglobals
	 */
	public $attributes = [
		'get' => [],
		'post' => [],
		'cookie' => [],
		'files' => [],
		'server' => [],
	];

	/**
	 * Registers super globals the attributes array
	 */
	public function createFromGlobals() 
	{
		$this->setAttributes(['get' => $_GET, 'post' => $_POST, 'cookie' => $_COOKIE, 'files' => $_FILES, 'server' => $_SERVER]);
	}

	/**
	 * Constructor
	 * @param array An array of custom attributes
	 */
	public function __construct($attributes = []) 
	{
		$this->setAttributes($attributes);
	}

	/**
	 * Get attributes
	 * @return array The attributes array
	 */
	public function getAttributes() 
	{
		return $this->attributes;
	}

	/**
	 * Sets custom attributes
	 * @param array $attributes Custom attributes
	 */
	public function setAttributes($attributes) 
	{
		foreach ($this->attributes as $key => $value) {
			if (isset($attributes[$key])) {
				$this->attributes[$key] = $attributes[$key];
			}
		}
	}

	/**
	 * Returns a value for the get key
	 * @param string $key The key value
	 * @return string The value for the key
	 */
	public function get($key) 
	{
		return $this->getAttributeKey('get', $key);
	}

	/**
	 * Returns a value for the post key
	 * @param string $key The key value
	 * @return string The value for the key
	 */
	public function post($key) 
	{
		return $this->getAttributeKey('post', $key);
	}	

	/**
	 * Returns a value for the cookie key
	 * @param string $key The key value
	 * @return string The value for the key
	 */
	public function cookie($key) 
	{
		return $this->getAttributeKey('cookie', $key);
	}

	/**
	 * Returns a value for the files key
	 * @param string $key The key value
	 * @return string The value for the key
	 */
	public function files($key) 
	{
		return $this->getAttributeKey('files', $key);
	}

	/**
	 * Returns a value for the server key
	 * @param string $key The key value
	 * @return string The value for the key
	 */
	public function server($key) 
	{
		return $this->getAttributeKey('server', $key);
	}

	/**
	 * Get the whole key array
	 * @param string $key The key to get
	 * @return array | null
	 */
	public function key($key) 
	{
		return isset($this->attributes[$key]) ? $this->attributes[$key] : null;
	}

	/**
	 * Returns a value for the set attribute
	 * @param string $attribute The attribute to access
	 * @param string $key The key value
	 * @return string | null
	 */
	protected function getAttributeKey($attribute, $key) 
	{
		return isset($this->attributes[$attribute][$key]) ? $this->attributes[$attribute][$key] : null;
	}
}