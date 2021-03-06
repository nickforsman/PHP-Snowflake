<?php

namespace Snowflake\Exceptions;

class InvalidRequestException extends \Exception 
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