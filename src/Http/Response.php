<?php

namespace Snowflake\Http;

class Response 
{
	public $settings;

	public function __construct($settings = []) 
	{
		if ( ! empty($settings)) {
			$this->settings = $settings;
		}
	}

	public function sendHeader() 
	{
		if (isset($this->settings['header'])) {
			foreach ($this->settings as $header) {
				return header("Content-Type: $header");
			}
		}
	}

	public function sendFourOFour() 
	{
		return http_response_code(404);
	}
}
