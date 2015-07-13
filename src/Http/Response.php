<?php

namespace Snowflake\Http;

class Response 
{
	/**
	 * @var array Optional settings
	 */
	public $settings;

	/**
	 * Constructor
	 * @param Optional settings for response, e.g [header => application/json]
	 */
	public function __construct($settings = []) 
	{
		if ( ! empty($settings)) {
			$this->settings = $settings;
		}
	}

	/**
	 * Sends headers if headers are set
	 * @return Http header
	 */
	public function sendHeader() 
	{
		if (isset($this->settings['header'])) {
			foreach ($this->settings as $header) {
				return header("Content-Type: $header");
			}
		}
	}

	/**
	 * Returns a 404 status code
	 * @return Http status code
	 */
	public function sendFourOFour() 
	{
		return http_response_code(404);
	}
}
