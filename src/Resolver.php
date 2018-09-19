<?php
/**
 * Callables resolver - resolves special keys to correspnding container callables
 */
namespace Vsd\Mvcs;

class Resolver
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
	 * Constructor
	 * 
	 * @param	PsrContainer	$container	External PSR container
	 * @param	object			$parser		MVCS patterns parser
	 * 
	 * @return	void
	 */
	public function __construct($container, $parser = NULL)
	{
		$this->container = $container;
		$this->parser = $parser ?: new Parser();
	}

	/**
	 * Resolve container key or special key pattern to a corresponding callable
	 * 
	 * @param	string	$key	Container key or special key pattern
	 * 
	 * @throws	\Exception	"Arg must be a string"
	 * @throws	\Exception	"Can't resolve callable with given key"
	 * 
	 * @return	callable	Resolved callable
	 */
	public function resolveCallable($key)
	{
		if (! is_string($key)) {
			$type = gettype($key);
			throw new \Exception(__METHOD__."(): Arg must be a string, {$type} given");
		}

		if (! is_null($callable = $this->resolveSpecialCallable($key))) {
			return $callable;
		}

		throw new \Exception(__METHOD__."(): Can't resolve callable with given key `{$key}`");
	}

	/**
	 * Resolve container key or special key pattern to corresponding callable
	 * 
	 * @param	string	$key	Container key or special key pattern
	 * 
	 * @return	callable|NULL	Resolved callable or NULL
	 */
	public function resolveSpecialCallable($key)
	{
		if (! is_null($callable = $this->resolveAliasedValue($key))) {
			return $callable;
		}

		if (! is_null($callable = $this->resolveClassMethod($key))) {
			return $callable;
		}
	}

	/**
	 * Get the value of last alias in a chain of given key
	 * Alias is a key of another entry in the container
	 * Another entry could be an alias as well (chained), OR any other value
	 * 
	 * @param	string	$key	Container key or alias
	 * 
	 * @return	mixed|NULL		Last aliased value
	 */
	public function resolveAliasedValue($key)
	{
		$c = $this->container;
		$last = NULL;					// last valid entry in the chain of input key

		while (TRUE) {
			if (! $c->has($key)) {
				return $last;
			}
			$value = $c->get($key);

			if (! is_string($value)) {
				return $value;			// this is NOT an alias, but the last chained entry
			}

			// this could be an alias of next chained entry
			$last = $key = $value;		// save last valid entry and try to follow chain
		}
	}

	/**	
	 * Resolve 'class:method' pattern, where:
	 * 	<class>		full class name | object or class alias
	 * 	<method>	method name
	 * 
	 * @param	string	$pattern	Special key pattern string
	 * 
	 * @return	callable|NULL		Resolved callable
	 */
	public function resolveClassMethod($pattern)
	{
		if (NULL === ($parts = $this->parser->parseKeyMethod($pattern))) {
			return;
		}

		return $this->resolveKeyMethod($parts[0], $parts[1]);
	}

	public function resolveKeyMethod($key, $method)
	{
		$c = $this->container;
		if (! $c->has($key)) {
			// Check if $key is a full class name
			if (is_callable($key, $method)) {
				return([$key, $method]);			// callable [class, method] found
			}

			return;
		}
		$value = $c->get($key);

		if (! method_exists($value, $method)) {
			$type = gettype($value);
			$decl = $type == 'string' ? "`{$value}`" : "({$type})";
			throw new \RuntimeException("Container entry `{$key}` => {$decl} doesn't have method `{$method}`");
		}

		if (is_object($value)) {
			return [$value, $method];
		}

		// $value is an existent class here and $method is it's existent method 
		$refl = new \ReflectionMethod($value, $method);
		return [$refl->isStatic() ? $value : new $value($c), $method];
	}
}
