<?php

namespace Snowflake\Http;

class Response 
{
	public static function send($code) 
	{
		return http_response_code($code);
	}
}