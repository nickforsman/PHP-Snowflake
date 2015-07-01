<?php

namespace Snowflake;

class View 
{

	public $directory = 'resources/views/';

	public function render($template, array $data = null) 
	{
		$template = $this->directory . $template;

		if ( ! file_exists($template)) {
			throw new \InvalidArgumentException("The template $template was not found in $this->directory");
		} else {
			extract($data);
			ob_start();
			require $template;
			return ob_get_clean();
		}
	}

	public function run($template, $data) 
	{
		echo $this->render($template, $data);
	}

}
