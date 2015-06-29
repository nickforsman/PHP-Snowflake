<?php

namespace Snowflake\Http;

class Response 
{
	public static function send($status) 
	{
		return http_response_code($status);
	}
}
