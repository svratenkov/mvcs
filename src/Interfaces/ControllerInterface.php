<?php
namespace Vsd\Mvcs\Interfaces;

interface ControllerInterface
{
	/**
	 * Respond to given route specified by an action and action paams
	 * 
	 * Route action could be defined by:
	 * 	- any PHP callable: closure, [object|class, method], 'class::method', invokable
	 * 	- special pattern: 'domain@method^template?renderer'
	 * 
	 * @param	mixed	$action	Route action: callable or pattern, i.e. 'product@info'
	 * @param	array	$params	Route action parameters, i.e. ['123'] (for product id)
	 * 
	 * @return	string	Action response: html, view, json, ...
	 */
	public function handle($action, $params = []);
}
