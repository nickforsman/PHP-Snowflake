<?php

namespace Snowflake\Core\Http;

class Request 
{

	public static methods = ['GET', 'POST', 'PUT', 'DELETE'];

	public function listen($request) 
	{
		return $request;
	}
}