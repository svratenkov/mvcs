<?php
/*
	AbstractRenderer defines __invoke method for rendering
*/
namespace Vsd\Mvcs\Renderers;
use Vsd\Mvcs\Interfaces\RendererInterface;

abstract class AbstractRenderer implements RendererInterface
{
	public static $rendererResolver;

	/**
	 * Set default renderer
	 *
	 * @param  RendererInterface	$renderer	Renderer instance
	 * 
	 * @return void
	 */
	public static function setDefaultRenderer($renderer)
	{
		static::$defaultRenderer = $renderer;
	}

	/**
	 * Get default renderer
	 *
	 * @return RendererInterface	Renderer instance
	 */
	public static function getDefaultRenderer($renderer)
	{
		return static::$defaultRenderer;
	}

	/**
	 * Resolve renderer given by key or NULL, otherwise returns passed value
	 * 
	 * Renderers are service objects and could be defined by some factory closure like:
	 *  	function() { return new PhpTemplateRenderer(['dir' => 'templatesPath']); }
	 * So any renderer's closure will be automatically executed
	 * to receive an instance of RendererInterface
	 * 
	 * @param	string|NULL	$renderer	Container key or NULL
	 * @return	RendererInterface		Resolved renderer instance
	 */
	public function resolveRenderer($renderer = NULL)
	{
		// Resolve default renderer
		if (is_null($renderer)) {
			if (is_string($this->defaultRenderer)) {
				$this->defaultRenderer = $this->resolver->resolveCallable($this->defaultRenderer);
			//	View::setDefaultRenderer($this->defaultRenderer);
			}
			return $this->defaultRenderer;
		}

		// Resolve a renderer given by container key
		if (is_string($renderer)) {
			return $this->resolver->resolveCallable($renderer);
		}

		// Neither default, nor key - return given renderer as is
		return $renderer;
	}

	/**
	 * Render given template with given data array
	 *
	 * @param  array	$data		Associative array of template data: ['var' => 'value']
	 * @param  mixed	$template	Template of any kind acceptable by renderer
	 * @return string				Rendered HTML code
	 */
	abstract public function render($data, $template);

	/**
	 * Render given template with given data array
	 *
	 * @param  array	$data		Associative array of template data: ['var' => 'value']
	 * @param  mixed	$template	Template of any kind acceptable by renderer
	 * @return string				Rendered HTML code
	 */
	public function __invoke($data, $template)
	{
		return $this->render($data, $template);
	}
}
