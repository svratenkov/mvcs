<?php
/*
	Controller handles given scenario and returnes a PHP response string.

	Responsibilities:
	 - Retrieve scenario and scenario parameters from the application, usually from the router.
	 - Create scenario instance and play it with given scenario parameters.
	 - Return scenario response back to application.
	 - Maintain MVCS container.
*/
namespace Vsd\Mvcs;

class Controller extends Scenario
{
	/**
	 * @var mixed	Current scenario
	 */
	protected $scenario;

	/**
	 * @var array	Current request parameters
	 */
	protected $requestParams;

	/**
	 * Play scenario given by definition with given request params
	 * 
	 * @param	mixed	$scenario	Scenario definition
	 * @param	array	$params		Request parameters
	 * 
	 * @return	string	Action PHP response: html, view, json-encode, ...
	 */
	public function play($scenario, $params = [])
	{
		// Save requested scenario & params for use anywhere
		$this->scenario = $scenario;
		$this->requestParams = $params;

		// Action is a callable - invoke it
		return parent::play($scenario, $params);
	}

	//-----------------------------------------------------------------------------
	// Public getters
	//-----------------------------------------------------------------------------

	/**
	 * @return	mixed	Current scenario
	 */
	public function getScenario()
	{
		return $this->scenario;
	}

	/**
	 * @return	array	Current route params array
	 */
	public function getRequestParams()
	{
		return $this->requestParams;
	}
}
