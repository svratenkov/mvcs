<?php
/*
	AppViewModel - AppData getters for Home & Error404 pages
	Defines App model constructor
*/
namespace Vsd\Mvcs\Example\Models;

class HomeModel //extends BaseModel
{
	/**
	 * Construct new ShellViewModel instance with given app container
	 * 
	 * @param	PsrContainerInterface	$container	App container instance
	 * @return	void
	 */
	public function __construct($container = NULL)
	{
		// Set app container if given
	//	parent::__construct($container);
	}

	/**
	 * Generate template data from readme.md
	 * 
	 * @return array	Template data
	 */
	public function home()
	{
		return [
			'title'	=> 'Title',
			'text'	=> file_get_contents('docs/readme.html'),
		];
	}

	/**
	 * Generate template data
	 * 
	 * @param  array	$params - new state params
	 * @return void
	 */
	public function error404()
	{
		return ['url' => url()];
	}
}
