<?php

namespace Snowflake\Exceptions;

class UnsupportedMethodException extends \Exception 
{

	public function __construct($message, $code) 
	{
		parent::__construct($message, $code);
	}

	public function __toString() 
	{
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }

}