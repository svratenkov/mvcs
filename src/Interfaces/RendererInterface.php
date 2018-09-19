<?php
/**
 * RendererInterface
 * 
 * Could be used for Renderer object identification through instanceof
 */
namespace Vsd\Mvcs\Interfaces;

interface RendererInterface
{
	/**
	 * Render given template with given data array using given parameters
	 *
	 * @param  array	$data		Array of data
	 * @param  mixed	$template	Template of any kind compatible to renderer
	 * @return string				Rendered HTML code
	 */
	public function render($data, $template);

	/**
	 * Renderer's invoker
	 *
	 * @param  array	$data		Array of data
	 * @param  mixed	$template	Template of any kind compatible to renderer
	 * @return string				Rendered HTML code
	 */
	public function __invoke($data, $template);
}
