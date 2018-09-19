<?php
namespace Vsd\Mvcs\Interfaces\Converters;

interface ContainerInterface //extends PsrContainerInterface
{
	/**
	 * Set shared container
	 * 
	 * @param	PsrContainerInterface	$container	Shared PSR container instance
	 * @return	void
	 */
	public static function setContainer($container);

	/**
	 * @return	PsrContainerInterface	PSR container instance
	 */
	public function getContainer();
}
