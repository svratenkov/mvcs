<?php
/*
	BaseView with default renderer

	Most applications use some prefered view renderer.
	We use static property for such common value.
*/
namespace Vsd\Mvcs\Views\Traits;

trait DefaultRendererViewTrait
{
	/** @var callable Static reference to default renderer callable */
	protected static $defaultRenderer;

	/**
	 * @param	callable	$renderer	Static reference to default renderer callable
	 * @return	void
	 */
	public static function setDefaultRenderer($renderer)
	{
		static::$defaultRenderer = $renderer;
	}

	/** @return callable */
	public static function getDefaultRenderer()
	{
		return static::$defaultRenderer;
	}

	/**
	 * Get view renderer property if assigned or default renderer
	 * 
	 * @return	callable	View renderer
	 */
	public function getRenderer()
	{
		return isset($this->renderer) ? $this->renderer : static::getDefaultRenderer();
	}
}
