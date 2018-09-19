<?php
/**
 * PhpTemplateRenderer defines directory and extension for PHP file templates
 */
namespace Vsd\Mvcs\Renderers;

class PhpTemplateRenderer extends PhpFileRenderer
{
	// Renderer templates dir
	protected $dir;

	// Renderer templates extension
	protected $ext = '.php';

	/**
	 * Construct new renderer instance
	 * 
	 * @param  array  $params	Renderer parameters: templates dir & extension
	 * @return void
	 */
	public function __construct($params = [])
	{
		if (isset($params['dir'])) {
			$dir = $params['dir'];
			if (($path = realpath($dir)) === FALSE) {
				throw new \Exception(__CLASS__.": Can't find templates dir '{$dir}'");
			}
			$this->dir = $path.DIRECTORY_SEPARATOR;
		}

		if (isset($params['ext'])) {
			$this->ext = $params['ext'];
		}
	}

	/**
	 * Render given template with given data array
	 *
	 * @param  array	$data		Associative array of template data: ['var' => 'value']
	 * @param  string	$template	Rendering PHP template alias (the path relative to static::$dir)
	 * @param  object	$context	Template vars context
	 * 
	 * @return string				Rendered HTML code
	 */
	public function render($data, $template, $context = NULL)
	{
		return parent::render($data, $this->dir.$template.$this->ext, $context);
	}
}
