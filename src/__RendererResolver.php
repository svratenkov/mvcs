<?php
/*
	ResolverRenderer defines a resolver for nulled and aliased renderers
*/
namespace Vsd\Mvcs\Renderers;
use Vsd\Mvcs\Interfaces\RendererInterface;

abstract class ResolverRenderer extends AbstractRenderer
{
	/**
	 * @var object		Special container keys resolver
	 */
	protected $resolver;

	/**
	 * @var	callable	Default MVCS renderer
	 */
	protected $defaultRenderer;
	
	public static $resolver;

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
}
