<?php

namespace Snowflake\View;

class View 
{

	public $templateDirectory;

	public function __construct($directory = null) 
	{
		$default = __DIR__ . '/../../resources/views/';
		if ($directory) {
			$this->setTemplateDirectory($directory);
		} else {
			$this->setTemplateDirectory($default);
		}
	}

	public function render($template, array $data = null) 
	{
		$template = $this->templateDirectory . $template;

		if ( ! file_exists($template)) {
			throw new \InvalidArgumentException("The template $template was not found in $this->templateDirectory");
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

	public function setTemplateDirectory($directory) 
	{
		$this->templateDirectory = $directory;
	} 

}
