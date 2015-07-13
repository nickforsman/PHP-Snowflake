<?php

namespace Snowflake\View;

class View 
{

	/**
	 * @var string template directory
	 */
	public $templateDirectory;

	/**
	 * Constructor
	 * @param $directory The template directory
	 */
	public function __construct($directory = null) 
	{
		$default = __DIR__ . '/../../resources/views/';
		if ($directory) {
			$this->setTemplateDirectory($directory);
		} else {
			$this->setTemplateDirectory($default);
		}
	}

	/**
	 * Renders the template called in the app
	 * @param string $template The template to be rendered
	 * @param array $data Optional variables to template
	 * @return mixed
	 * @throws \InvalidArgumentException
	 */
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

	/**
	 * Echoes out the html file to be rendered
	 */
	public function run($template, $data) 
	{
		echo $this->render($template, $data);
	}

	/**
	 * Sets the template directory
	 */
	public function setTemplateDirectory($directory) 
	{
		$this->templateDirectory = $directory;
	} 

}
