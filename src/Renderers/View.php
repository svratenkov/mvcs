<?php
/*
	BaseView ::= Renderer + Template + Data

	BaseView properties:
		- Renderer is any callable, default renderer is supported
		- Template is of any type acceptable by renderer
		- Data is an associative array ONLY, not a callable,
			access to individual data items is not supported (see DataView)

	BaseView methods:
		- view properties getters/setters
		- data & renderer resolvers for overloading in descendants
		- rendering methods: render(), renderNested(), __toString()
*/
namespace Vsd\Mvcs\Renderers;
use Vsd\Mvcs\SharedRendererResolver;

class View //extends AbstractRenderer
{
	/**
	 * @var	array	View data - associative [key => value] array
	 */
	protected $data;

	/**
	 * @var mixed	View template of any kind compatible to renderer
	 */
	protected $template;

	/**
	 * UNDECLARED DYNAMIC PROPERTY - presents if assigned only
	 * This behavior supports default renderer possibility and saves property space
	 * 
	 * @var	callable	$renderer	View renderer callable property if it differs from default renderer
	 */
//	public $renderer;

	/**
	 * Construct new view instance
	 * 
	 * @param	array		$data		View associative data array
	 * @param	mixed		$template	View template of any type compatible to renderer
	 * @param	callable	$renderer	View renderer callable
	 * @return	void
	 */
	public function __construct($template = NULL, $data = [], $renderer = NULL)
	{
		$this->setData($data)->setTemplate($template)->setRenderer($renderer);
	}

	/**
	 * Set view template
	 * 
	 * @param	mixed	$template	View template of any type compatible to renderer
	 * @return	$this				Chained return
	 */
	public function setTemplate($template)
	{
		$this->template = $template;

		// Chained return
		return $this;
	}

	/**
	 * Get view template property
	 * 
	 * @return	mixed	View template property
	 */
	public function getTemplate()
	{
		return $this->template;
	}

	/**
	 * Set view data
	 * 
	 * @param	array|callable	$data	View associative data array
	 * @return	$this					Chained return
	 */
	public function setData($data)
	{
		$this->data = $data;

		// Chained return
		return $this;
	}

	/**
	 * Get view data property
	 * 
	 * @return	mixed	View data property
	 */
	public function getData()
	{
		return $this->data;
	}

	/**
	 * Resolve view data property to an assotiative array
	 * Could be overloaded in descendants leaving untouched
	 * direct access to data property by getData()
	 * 
	 * @return	array	View data assotiative array
	public function resolveData($data = NULL)
	{
		return $data ?: $this->getData();
	}
	 */

	/**
	 * Set view renderer property
	 * Supports dynamic renderer property assuming default renderer compatibility
	 * 
	 * @param	callable	$renderer	View renderer callable
	 * @return	$this					Chained return
	 */
	public function setRenderer($renderer = NULL)
	{
		if (empty($renderer)) {
			// Remove dynamic property if it should be set to NULL
			if (isset($this->renderer) or property_exists($this, 'renderer')) {
				unset($this->renderer);
			}
		}
		else {
			$this->renderer = $renderer;
		}

		// Chained return
		return $this;
	}

	/**
	 * Get view renderer property if assigned or default renderer
	 * 
	 * @return	callable	View renderer
	 */
	public function getRenderer()
	{
		return isset($this->renderer) ? $this->renderer : NULL;
	}

	/**
	 * Resolve renderer property to valid callable
	 * Could be overloaded in descendants leaving untouched
	 * direct access to renderer property by getRenderer()
	 * 
	 * @return	callable	View renderer callable
	 */
	public function resolveRenderer()
	{
		return SharedRendererResolver::resolveRenderer($this->getRenderer());
	}

	/**
	 * Render view using its renderer, template and data
	 *
	 * @param	bool	$nested	If TRUE will renderer all nested views to avoid __toString() problems
	 * 
	 * @return	string	Response string, HTML or any other code
	 */
	public function render($nested = TRUE)
	{
		// Get data first - AJAX requests will exit here for the view with dynamic data
		$data = $this->getData();
		if ($nested) {
			$data = static::renderNested($data);
		}

		// Resolve renderer and render this view
		$renderer = $this->resolveRenderer();
		$content = $renderer($data, $this->getTemplate());

		return $content;
	}

	/**
	 * Render recursively all nested views to avoid __toString() effects
	 * 
	 * This method does NOT render the view itself!
	 * This method does NOT alter the view data!
	 * 
	 * @param	array	$data	Associative data array which may contain View objects
	 * @return	array			Rendered view data without any View object
	 */
	public static function renderNested($data)
	{
		foreach ($data as $key => $val) {
			if ($val instanceof ViewInterface) {
				$data[$key] = $val->render(NULL, NULL, TRUE);
			}
		}

		return $data;
	}

	/**
	 * Get the string representation of the view
	 * 
	 * @return	string	String contents (HTML) of the view
	 */
	public function __toString()
	{
		try {
			return $this->render(NULL, NULL, FALSE);	// don't render child views
		}
		catch(\Exception $e) {
			// __toString() method isn't allowed to throw exceptions, so we turn them into NULL
			// Returning none string will rise an ErrorException [4096]: Method __CLASS__::__toString() must return a string value
			// see: https://stackoverflow.com/questions/2429642/why-its-impossible-to-throw-exception-from-tostring
			return;

			// trigger_error() is allowed in __toString()...
		//	trigger_error($e->getMessage().$e->getTraceAsString());
		}
	}
}
