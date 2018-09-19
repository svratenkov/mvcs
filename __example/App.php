<?php
/*
	App class for MVCS example
*/
namespace Vsd\Mvcs\Example;
use Vsd\Mvcs\Controller;

class App
{
	/**
	 * @var	string	Base url
	 */
	public $baseUrl;

	/**
	 * @var	array	Request args (segments) consequtive array
	 */
	public $requestArgs;

	/**
	 * @var	array	App routes array
	 */
	public $routes;

	/**
	 * @var	array	App MVCS config
	 */
	public $config;

	/**
	 * @var	callable|array|string	Current scenario
	 */
	public $scenario;

	/**
	 * @param	array	$routes	Rotes array
	 * @param	array	$config	MVCS config array
	 * 
	 * @return	void
	 */
	public function __construct($routes, $config)
	{
		$this->routes = $routes;
		$this->config = $config;
	}

	/**
	 * Run application
	 * 
	 * @return	string	PHP response
	 */
	public function run()
	{
		// Handle current request
		list($this->baseUrl, $this->requestArgs) = $this->parseRequest();

		// Route current request to its scenario
		$action = array_shift($this->requestArgs);
		$this->scenario = isset($this->routes[$action]) ? $this->routes[$action] : $this->routes['*'];
 
		// Create default MVCS controller with basic MVCS settings
		$this->controller = new Controller($this->config, 'defaultRenderer');

		// Handle matched route action & params
		$content = $this->controller->handle($this->scenario, $this->requestArgs);
de($this);

		// Decorate main response with layout renderer
		// !!! [$content] is an input to THE SCENARIO !!!
		$response = $this->controller->handle('layout:layout > render,layout', [$content]);

/*
		// The same without scenario handler
		$compiler = $this->controller->getResolver()->resolveCallable('layout:layout');
		$data = call_user_func($compiler, $content, $params);

		$layoutView = new View($data, 'layout');
		$response = $layoutView->render();
*/

		return $response;
	}

	//------------------------------------------------------------------------------
	// Http Request handler
	//------------------------------------------------------------------------------

	/**
	 * Parse query request formatted as:
	 * 		[http://localhost]/base/index.php?action/arg1/arg2/...
	 * where:
	 * 		action	- route action name
	 * 		argN	- route action params
	 * 
	 * @return	array	[BaseUri, [Query-Segments]]
	*/
	function parseRequest()
	{
		$args = explode('?', trim($_SERVER['REQUEST_URI'], '/'));
		$base = array_shift($args);

		$args = empty($args) ? ['/'] : explode('/', $args[0]);

		return [$base, $args];
	}

	/*
		Make home url

		Return: array[BaseUri, Query-Segments,... ]
	*/
	function homeUrl()
	{
		$uri = trim($_SERVER['REQUEST_URI'], '/');

		$parts = explode('?', $uri);
		$base = array_shift($parts);

		$uri = isset($parts[0]) ? explode('/', $parts[0]) : [];

		return [$base, $uri];
	}
}