<?php
namespace Vsd\Mvcs\Interfaces\Components;

interface DecoratorInterface extends ComponentInterface
{
	/**
	 * Decorate given data using embedded decorator
	 * 
	 * @param	array	$data	Model data array
	 * @return	string			Action response: html, view, json, ...
	 */
	public function decorate($data);
}
