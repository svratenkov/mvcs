<?php
namespace Vsd\Mvcs\Interfaces\Components;

interface InvokerInterface
{
	/**
	 * Invoke given closure or callable with given params
	 * Binds closure to this controller context
	 * Passes this controller as the first arg for a callable
	 * 
	 * @param	callable	$callable	Callable
	 * @param	array		$params		Callable params
//	 * @param	bool		$throw		If TRUE then throws an exception
	 * 
	 * @return	mixed					Callable response
	 */
	public function invokeClosureOrCallable($callable, $params = []);	//, $throw = TRUE)

	/**
	 * Invoke given closure with given params
	 * Binds closure to this controller context
	 * 
	 * @param	Closure	$closure	Closure (anonimous function)
	 * @param	array	$params		Callable params
	 * 
	 * @return	mixed				Closure response
	 */
	public function invokeClosure(Closure $closure, $params = []);

	/**
	 * Invoke given callable with given params
	 * Passes this responder as the first arg for a callable
	 * 
	 * @param	callable	$callable	Callable
	 * @param	array		$params		Callable params
	 * 
	 * @return	mixed					Callable response
	 */
	public function invokeCallable($callable, $params = []);
}
