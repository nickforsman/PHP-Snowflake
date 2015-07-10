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

	public function send($status) 
	{
		if (empty($this->settings)) {
			return http_response_code($status);			
		} else {
			if (array_key_exists('header', $this->settings)) {
				foreach ($this->settings as $header) {
					return header("Content-Type: $header $status");
				}
			}
		}
	}
}
