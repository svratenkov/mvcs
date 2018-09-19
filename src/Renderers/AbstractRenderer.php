<?php
/*
	AbstractRenderer defines __invoke method for rendering
*/
namespace Vsd\Mvcs\Renderers;
use Vsd\Mvcs\Interfaces\RendererInterface;

abstract class AbstractRenderer implements RendererInterface
{
	/**
	 * Render given template with given data array
	 *
	 * @param  array	$data		Associative array of template data: ['var' => 'value']
	 * @param  mixed	$template	Template of any kind acceptable by renderer
	 * @param  object	$context	Template vars context
	 * 
	 * @return string				Rendered HTML code
	 */
	abstract public function render($data, $template, $context = NULL);

	/**
	 * Render given template with given data array
	 *
	 * @param  array	$data		Associative array of template data: ['var' => 'value']
	 * @param  mixed	$template	Template of any kind acceptable by renderer
	 * @param  object	$context	Template vars context
	 * 
	 * @return string				Rendered HTML code
	 */
	public function __invoke($data, $template, $context = NULL)
	{
		return $this->render($data, $template, $context);
	}
}
