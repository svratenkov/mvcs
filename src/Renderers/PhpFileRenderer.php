<?php
/*
	PhpFileRenderer defines __invoke method for rendering PHP file templates
*/
namespace Vsd\Mvcs\Renderers;

class PhpFileRenderer extends AbstractRenderer
{
	/**
	 * Render given template with given data array
	 *
	 * @param  array	$data		Associative array of template data: ['var' => 'value']
	 * @param  string	$template	Rendering PHP template file abs path
	 * @param  object	$context	Template vars context
	 * @return string				Rendered HTML code
	 */
	public function render($data, $template, $context = NULL)
	{
		// Renderer's closure to isolate template vars
		$renderer = function($__data__, $__template__) {
			ob_start();
			try {
				extract($__data__);
				include $__template__;
			}
			catch (\Exception $e) {
				ob_end_clean();
				throw $e;
			}
			return ob_get_clean();
		};

		// Set closure context if given
		if (NULL !== $context) {
			$renderer = $renderer->bindTo($context);
		}

		// Render data with template
		return $renderer($data, $template);
	}
}
