<?php
namespace Vsd\Mvcs\Interfaces\Components;

interface ResponderInterface extends ComponentInterface
{
	/**
	 * Returns component response to given compiler params
	 * 
	 * @param	array	$params	Compiler parameters numeric array
	 * 
	 * @return	string	PHP response string: html, view, json, ...
	 */
	public function respond($params = []);
}
