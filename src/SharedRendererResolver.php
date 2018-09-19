<?php
/**
 * Shared rederer's resolver - adds support for:
 * 	- default renderer - most applocations use only one or some preferable renderer
 * 	- instantiation of rendererers defined by closures
 * 	- handling an array of already resolved renderers,
 * 	  because MVCS does NOT save to it's container any item resolved from closure
 */
namespace Vsd\Mvcs;
use Vsd\Mvcs\interfaces\RendererInterface;
use Vsd\Mvcs\Renderers\PhpTemplateRenderer;
use Vsd\Mvcs\Exceptions\MvcsException;

class SharedRendererResolver
{
	/**
	 * @var	ResolverInterface	MVCS callables resolver instance
	 */
	protected static $resolver;

	/**
	 * @var	array	Array of resolved renderers
	 */
	protected static $renderers;

	/**
	 * @var	callable	Default MVCS renderer instance
	 */
	protected static $defaultRenderer;

	/**
	 * Init shared renderer resolver
	 * 
	 * @param	Resolver	$resolver			Shared callables resolver
	 * @param	callable	$defaultRenderer	Default renderer callable
	 * 
	 * @return	void
	 */
	public static function init($resolver, $defaultRenderer = NULL)
	{
		static::$resolver = $resolver;
		static::setDefaultRenderer($defaultRenderer);
	}

	/**
	 * Set shared resolver
	 * 
	 * @param	Resolver	$resolver	Shared resolver instance
	 * 
	 * @return	void
	 */
	public static function setResolver($resolver)
	{
		static::$resolver = $renderer;
	}

	/**
	 * Get shared resolver
	 * 
	 * @return	Resolver	$resolver	Shared resolver instance
	 */
	public static function getResolver($resolver)
	{
		return static::$resolver;
	}

	/**
	 * Set given renderer (or PhpTemplateRederer) as default
	 *
	 * @param  mixed	$renderer	Renderer instance, callable or special key
	 * 
	 * @return void
	 */
	public static function setDefaultRenderer($renderer = NULL)
	{
		if (is_null($renderer)) {
			static::$defaultRenderer = new PhpTemplateRenderer();
			return;
		}

		if ($renderer instanceof RendererInterface) {
			static::$defaultRenderer = $renderer;
			return;
		}

		// Resolve renderer given by special key
		if (is_string($renderer)) {
			static::$defaultRenderer = static::resolveRenderer($renderer);
			return;
		}

		throw new MvcsException(__METHOD__."(): Invalid argument passed as default renderer");
	}

	/**
	 * Get default renderer
	 *
	 * @return RendererInterface	Renderer instance
	 */
	public static function getDefaultRenderer()
	{
		return static::$defaultRenderer;
	}

	/**
	 * Resolve renderer given by key or NULL, otherwise returns passed value
	 * 
//	 * Renderers are service objects and could be defined by some factory closure like:
//	 *  	function() { return new PhpTemplateRenderer(['dir' => 'templatesPath']); }
//	 * So any renderer's closure will be automatically executed
//	 * to receive an instance of RendererInterface
	 * 
	 * @param	string|NULL	$key	Container key or NULL
	 * @return	RendererInterface	Resolved renderer instance
	 */
	public static function resolveRenderer($key = NULL)
	{
		// Resolve nulled renderer
		if (is_null($key)) {
			return static::$defaultRenderer;
		}

		// Resolve renderer given by container key
		if (is_string($key)) {
			// Search in `already resolved` array
			if (isset(static::$renderers[$key])) {
				return static::$renderers[$key];
			}

			$entry = static::$resolver->resolveCallable($key);

			// Invoke closure entry
			if ($entry instanceof Closure) {
			//	$entry = $entry->bindTo($context);
				$entry = $entry();
			}

			// Save this renderer to `already resolved` array
			static::$renderers[$key] = $entry;

			return $entry;
		}

		// Neither default, nor key - return given renderer as is
		return $key;
	}
}
