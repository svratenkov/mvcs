<?php
namespace Vsd\Mvcs\Interfaces\Components;

interface CompilerInterface extends ComponentInterface
{
	/**
	 * Retrieve model data using embedded compiler and given request params
	 * 
	 * @param	array	$params	Compiler params array (route params)
	 * 
	 * @return	array			Compiled model data array
	 */
	public function compile($params = []);
}
