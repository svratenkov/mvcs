<?php
/*
	Invokes any closure or callable
*/
namespace Vsd\Mvcs;

class Invoker
{
	/**
	 * @var object	Secial keys resolver
	protected $resolver;
	 */

	/**
	 * @var object	Default variadic mode for callables
	 */
	protected $variadic;

	/**
	 * @var object	Default closures context to be bound to
	 */
	protected $context;

	/**
	 * @var bool	Debug mode: if TRUE will raise an exceptions
	 */
	protected $debug;

	/**
	 * Constructor
	 * 
//	 * @param	object	$resolver	Secial keys resolver
	 * @param	bool	$variadic	Default variadic mode for callables
	 * @param	object	$context	Default closures context to be bound to
	 * @param	bool	$debug		Debug mode: if TRUE will raise an exceptions
	 * 
	 * @return	void
	 */
//	public function __construct($resolver, $context = NULL, $variadic = TRUE)
	public function __construct($context = NULL, $variadic = TRUE, $debug = TRUE)
	{
	//	$this->resolver	= $resolver;
		$this->context = $context;
		$this->variadic	= $variadic;
		$this->debug = $debug;
	}

	/**
	 * Invoke any supported callable's kind with given args
	 * 
	 * @param	callable	$callable	Callable
	 * @param	array		$args		Callable args
	 * @param	bool		$variadic	If TRUE then $args will be unpacked into list
	 * @param	object		$context	Context to be bound to
	 * 
	 * @return	mixed					Callable response
	 */
	public function invoke($callable, $args = [], $variadic = NULL, $context = FALSE)
	{
//dd(__METHOD__, $callable, $args);
	//	if (is_string($callable)) {
	//		return $this->invokeSpecial($callable, $args, $this->context, $this->variadic);
	//	}

		if ($callable instanceof \Closure) {
			return $this->invokeClosure($callable, $args, $this->variadic, $this->context);
		}

		if (is_callable($callable)) {
			return $this->invokeCallable($callable, $args, $this->variadic);
		}

		if ($this->debug) {
			$type = gettype($callable);
			throw new \RuntimeException(__METHOD__."(): Arg 1 must be a callable, {$type} given");
		}
	}

	/**
	 * Invoke given closure with given args
	 * Binds closure to this controller context
	 * 
	 * @param	Closure	$closure	Closure
	 * @param	list	$args		Closure args
	 * @param	bool	$variadic	If TRUE then $args will be unpacked into list
	 * @param	object	$context	Context to be bound to
	 * 
	 * @return	mixed				Closure response
	 */
	public function invokeClosure($closure, $args = [], $variadic = NULL, $context = FALSE)
	{
		if (FALSE === $context) {
			$context = $this->context;		// Use default context
		}
		if (NULL !== $context) {
		//	$closure = \Closure::bind($closure, $context);
			$closure = $closure->bindTo($context);
		}

		if (NULL === $variadic) {
			$variadic = $this->variadic;	// Use default variadic mode
		}
		return $variadic ? $closure(...$args) : $closure($args);
	}

	/**
	 * Invoke given callable with given args
	 * Passes this controller as the first arg for a callable
	 * 
	 * @param	callable	$callable	Callable
	 * @param	array		$args		Callable args
	 * @param	bool		$variadic	If TRUE then $args will be unpacked into list
	 * @return	mixed					Callable response
	 */
	public function invokeCallable($callable, $args = [], $variadic = NULL)
	{
//dd(__METHOD__, $callable, $args, $variadic);
		if (NULL === $variadic) {
			$variadic = $this->variadic;	// Use default variadic mode
		}
		return $variadic ? call_user_func($callable, ...$args) : call_user_func($callable, $args);
	}
}
