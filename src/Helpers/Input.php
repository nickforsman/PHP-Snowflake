<?php

namespace Snowflake\Helpers;

class Input 
{
	public $attributes = [
		'get' => [],
		'post' => [],
		'cookie' => [],
		'files' => [],
		'server' => [],
	];

	public function createFromGlobals() 
	{
		$this->setAttributes(['get' => $_GET, 'post' => $_POST, 'cookie' => $_COOKIE, 'files' => $_FILES, 'server' => $_SERVER]);
	}

	public function __construct($attributes = []) 
	{
		$this->setAttributes($attributes);
	}

	public function getAttributes() 
	{
		return $this->attributes;
	}

	public function setAttributes($attributes) 
	{
		foreach ($this->attributes as $key => $value) {
			if (isset($attributes[$key])) {
				$this->attributes[$key] = $attributes[$key];
			}
		}
	}

	public function get($key) 
	{
		return $this->getAttributeKey('get', $key);
	}

	public function post($key) 
	{
		return $this->getAttributeKey('post', $key);
	}	

	public function cookie($key) 
	{
		return $this->getAttributeKey('cookie', $key);
	}

	public function files($key) 
	{
		return $this->getAttributeKey('files', $key);
	}

	public function server($key) 
	{
		return $this->getAttributeKey('server', $key);
	}

	public function key($key) 
	{
		return isset($this->attributes[$key]) ? $this->attributes[$key] : null;
	}

	protected function getAttributeKey($attribute, $key) 
	{
		return isset($this->attributes[$attribute][$key]) ? $this->attributes[$attribute][$key] : null;
	}
}