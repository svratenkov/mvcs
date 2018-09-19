<?php
/*
	Scenario handles a chain of primitive actions.
*/
namespace Vsd\Mvcs;
use Vsd\Mvcs\Interfaces\RendererInterface;
use Vsd\Mvcs\Renderers\View;

class Scenario
{
	/**
	 * @var ContainerInterface External PSR container {get(),has()} to resolve callables
	 */
	protected $container;

	/**
	 * @var object	MVCS patterns parser
	 */
	protected $parser;

	/**
	 * @var object	Callables invoker
	 */
	protected $invoker;

	/**
	 * @var object	Special container keys resolver
	 */
	protected $resolver;

	/**
	 * Constructor
	 * 
	 * @param	PsrContainer|array	$container			External PSR container
	 * @param	object|string		$defaultRenderer	Default renderer instance or key
	 * 
	 * @return	void
	 */
	public function __construct($container = NULL, $defaultRenderer = NULL)
	{
		// Setup container
		$this->setContainer($container);

		// Create components
		$this->invoker = new Invoker($this);
		$this->parser = new Parser();
		$this->resolver = new Resolver($this->container, $this->parser);

		// Initialize shared renderer resolver
		SharedRendererResolver::init($this->resolver, $defaultRenderer);
	}

	/**
	 * Handle given MVCS scenario definition with given request params
	 * 
	 * Scenario could be defined in other ways:
	 * 	- any PHP callable: closure, [object|class, method], 'class::method', invokable
	 * 	- an array of MVCS actions
	 * 	- special pattern string: 'converter[>converter]...'
	 * 
	 * @param	mixed	$scenario	Scenario definition
	 * @param	array	$params		Route params array
	 * 
	 * @return	string				PHP response: html, view, json-encode, ...
	 */
	public function play($scenario, $params = [])
	{
		// Resolve string scenario definition
		if (is_string($scenario)) {
			$scenario = $this->parser->parseChain($scenario);
		}

		// If scenario defined as an array of chained filters - play them
		if (is_array($scenario)) {
			return $this->playScenario($scenario, $params);
		}

		// Assume the scenario is a callable - invoke it
		return $this->invoker->invoke($scenario, $params);
	}

	/**
	 * Play given scenario
	 * 
	 * @param	string	$scenario	Scenario filters chain pattern
	 * @param	array 	$input		Input data to scenario filters chain
	 * 
	 * @return	array				Output data responsed by the last filter in scenario chain
	 */
	public function playScenario($scenario, $data = [])
	{
		// Play filters chain starting with given input data (or request params)
		foreach ($scenario as $action) {
			$data = $this->playAction($action, $data);
		}

		return $data;
	}

	/**
	 * Play given scenario action with given input
	 * 
	 * Действия сценария играют разные роли в зависимости от места в цепочке.
	 * Первый фильтр - компилятор модели. Вход: параметры запроса, variadic list,
	 * выход: данные модели - ассоциативный массив ['var' => 'value'].
	 * Все остальные фильтры - собственно фильтры данных модели.
	 * Их вход и выход: ассоциативный массив даннах модели (преобразованные).
	 * Последний фильтр - декоратор. Вход: данные модели, выход: СТРОКА ответа (а не массив).
	 * 
	 * @param	string	$action	Action string pattern or a core array definition
	 * @param	array	$input	Input data array to the filter
	 * 
	 * @return	array|string	Output of scenario action (array or string for last filter)
	 */
	public function playAction($action, $input = [])
	{
		// Filter name and args (sequental array only!)
		$args = $this->parser->parseArgs($action);
		$name = array_shift($args);

		$callable = $this->resolveAction($name);

		// Prepare paremeters for action callable
		$params = array_merge($this->prepareActionInput($input), $args);

		// Call action
		$output = $this->invoker->invoke($callable, $params);

		return $output;
	}

	/**
	 * Resolve an action given by name to a callable
	 * 
	 * @param	string	$name	Action name
	 * 
	 * @return	callable		Action callable
	 */
	public function resolveAction($name)
	{
		// Find specified action in the special keys or in this controller methods
		if (is_null($callable = $this->resolver->resolveSpecialCallable($name))) {
			if (! method_exists($this, $name)) {
				throw new \Exception(__METHOD__."(): Can't find MVCS action named `{$name}`");
			}
			$callable = [$this, $name];
		}

		return $callable;
	}

	/**
	 * Prepare action input
	 * 
	 * Any scenario action is a variadic function (with variable parameters)
	 * It accepts SEQUENTIAL PARAMETER LIST ONLY
	 * It's first parameter is always an output of previous filter
	 * However an output of any action could be an assoc array or of any type
	 * So we must correctly prepare params list depending on output
	 * 
	 * @param	array	$input	An input params list (an output of prev action in the chain)
	 * 
	 * @return	array			Action params sequential list
	 */
	public function prepareActionInput($input)
	{
		// If input is empty
		if (empty($input)) {
			return [];
		}

		// If non-empty then input must be an array
		else if (! is_array($input)) {
			return [$input];
		}

		// If input is NOT a sequential list but is an assoc array
		// Smth like data converter or decorator with additional args
		// Insert input array at the begining of args list
		else if (! isset($input[0])) {
			return [$input];
		}

		// Here input is a sequential list (such as request params)
		// Smth like a model compiler with additional params
		// Then we will combine input LIST and args LIST
	//	else {
	//		$input = $input;	// nothing to do!!!
	//	}

		// Insert prepared input at the begining of args list 
		return $input;
	}

	//-----------------------------------------------------------------------------
	// MVCS system (embedded) actions
	//-----------------------------------------------------------------------------

	/**
	 * Compile given data with given compiler callable
	 * 
	 * @param	callable	$compiler	Compiler callable
	 * @param	array		$data		Input data to be compiled
	 * 
	 * @return	array					Compiled output data
	 */
	public function compile($compiler, $data)
	{
		return $this->invoker->invoke($compiler, ...$data);
	}

	/**
	 * Render given data with given template and renderer
	 * 
	 * @param	array	$data		Input data to be rendered
	 * @param	string	$template	Template name
	 * @param	mixed	$renderer	Renderer callable | callable pattern | default renderer
	 * 
	 * @return	string				PHP response: html, view, json-encode, ...
	 */
	public function render($data, $template, $renderer = NULL)
	{
		$renderer = SharedRendererResolver::resolveRenderer($renderer);

	//	return $renderer($data, $template, $this);	// embed $this to the template's context
		return $renderer($data, $template);
	}

	/**
	 * Returns view with given data, template and renderer
	 * 
	 * @param	array	$data		Model data assoc array
	 * @param	string	$template	Template of any kind compatible to renderer 
	 * @param	mixed	$renderer	Renderer callable | callable pattern | default renderer
	 * 
	 * @return	array	model data assoc array
	 */
	public function view($data, $template, $renderer = NULL)
	{
		$view = new View($template, $data, $renderer);

		return $view->render();
	}

	/**
	 * Redirect to given URL
	 * 
	 * @param	string	$url	URL to redirect
	 * @return	void
	 */
	public function redirect($url = NULL)
	{
		if (empty($url)) {
			$url = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : $_SERVER['REQUEST_URI'];
		}

		header('Location: '.$url);

		/* Make sure that code below does not get executed when we redirect. */
		exit;
	}

	/**
	 * AJAX exit with json encoding of given data
	 * 
	 * @param	array|NULL	$data	Data to be encoded to json
	 * @return	void
	 */
	public function ajax($data = [])
	{
		exit(json_encode($data));
	}

	//-----------------------------------------------------------------------------
	// Container access
	//-----------------------------------------------------------------------------

	/**
	 * Returns true if the scenario container can return an entry for the given identifier.
	 * Returns false otherwise.
	 *
	 * `has($key)` returning true does not mean that `get($key)` will not throw an exception.
	 * It does however mean that `get($key)` will not throw a `NotFoundExceptionInterface`.
	 *
	 * @param string $key Identifier of the entry to look for.
	 *
	 * @return bool
	 */
	public function has($key = NULL)
	{
		return $this->container->has($key);
	}

	/**
	 * Finds an entry of the scenario container by its identifier and returns it.
	 *
	 * @param string $key Identifier of the entry to look for.
	 *
	 * @throws NotFoundExceptionInterface  No entry was found for **this** identifier.
	 * @throws ContainerExceptionInterface Error while retrieving the entry.
	 *
	 * @return mixed Entry.
	 */
	public function get($key)
	{
		return $this->container->get($key);
	}

	/**
	 * Set scenario container item with given key and value
	 * 
	 * @param	string	$key	Container entry key
	 * @param	mixed	$value	Container entry value
	 * @return	void
	 */
	public function set($key, $value = NULL)
	{
		$this->container->set($key, $value);
	}

	//-----------------------------------------------------------------------------
	// Public getters/setters
	//-----------------------------------------------------------------------------

	/**
	 * $@param	mixed	$container		External container or container data
	 * @return	PsrContainerInterface	PSR container instance
	 */
	protected function setContainer($container)
	{
		// Create or fill a container
		if (is_null($container)) {
			$this->container = new Container();
		}
		else if (is_array($container)) {
			$this->container = new Container();
			foreach ($container as $key => $value) {
				$this->container->set($key, $value);
			}
		}
		else {
			$this->container = $container;
		}
	}

	/**
	 * @return	PsrContainerInterface	PSR container instance
	 */
	public function getContainer()
	{
		return $this->container;
	}

	/**
	 * @return	object	MVCS parser instance
	 */
	public function getParser()
	{
		return $this->parser;
	}

	/**
	 * @return	object	MVCS resolver instance
	 */
	public function getResolver()
	{
		return $this->resolver;
	}

	/**
	 * @return	object	Callables invoker instance
	 */
	public function getInvoker()
	{
		return $this->invoker;
	}
}
