<?php

namespace Snowflake\Http;

class Response 
{
	public $headers;

	public function __construct($headers = []) 
	{
		if ( ! empty($headers)) {
			$this->headers = $headers;
		}
	}

	public function send($status) 
	{
		if (empty($this->headers)) {
			return http_response_code($status);			
		} else {
			foreach ($this->headers as $header) {
				return header("Content-Type: $header $status");
			}
		}
	}
}
