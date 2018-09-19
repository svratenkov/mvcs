<?php
/*
	Adds default renderer support for descendants
*/
namespace Vsd\Mvcs\Renderers;

class DefaultRenderer
{
	/**
	 * @var	ResolverInterface	Shared resolver for nulled and special key renderers
	 */
	protected $resolver;

	/**
	 * @var	callable	Default MVCS renderer
	 */
	protected static $defaultRenderer;
	
	/**
	 * Constructor
	 * 
	 * @param	ResolverInterface	$resolver			External PSR container
	 * @param	object|string		$defaultRenderer	Default renderer instance or key
	 * 
	 * @return	void
	 */
	public function __construct($resolver, $defaultRenderer = 'defaultRenderer')
	{
		$this->$resolver = $resolver;
		$this->setDefaultRenderer($defaultRenderer);
	}

	/**
	 * Set given renderer as default
	 *
	 * @param  mixed	$renderer	Renderer instance, callable or special key
	 * 
	 * @return void
	 */
	public function setDefaultRenderer($renderer)
	{
		// Resolve renderer given by special key
		$this->defaultRenderer = $this->resolveRenderer($renderer);
	}

	/**
	 * Get default renderer
	 *
	 * @return RendererInterface	Renderer instance
	 */
	public function getDefaultRenderer()
	{
		return $this->defaultRenderer;
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
		// Resolve nulled renderer
		if (is_null($renderer)) {
			return $this->defaultRenderer;
		}

		// Resolve renderer given by container key
		if (is_string($renderer)) {
			return $this->resolver->resolveCallable($renderer);
		}

		// Neither default, nor key - return given renderer as is
		return $renderer;
	}
}
