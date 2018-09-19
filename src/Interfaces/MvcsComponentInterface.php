<?php
/**
 * Mvcs component interface
 */
namespace Vsd\Mvcs\Interfaces;

interface MvcsComponentInterface
{
	/**
	 * Respond to request specified by given action and action params
	 * 
	 * @param	mixed	$action	Route action: callable or pattern, i.e. 'product@info'
	 * @param	array	$params	Route action parameters, i.e. ['123'] (for product id)
	 * 
	 * @return	string	Action response: html, view, json, ...
	 */
	public function respond($action, $params = []);
}
