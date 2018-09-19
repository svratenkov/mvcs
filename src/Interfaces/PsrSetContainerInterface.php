<?php
/**
 * PsrSetContainerInterface :== PsrContainerInterface [get(), has()] + set()
 */
namespace Vsd\Mvcs\Interfaces;

interface PsrSetContainerInterface extends PsrContainerInterface
{
	/**
	 * Set container item with given key and value
	 * 
	 * @param	string|array	$key	Container entry key
	 * @param	mixed			$value	Container entry value
	 * @return	void
	 */
	public function set($key, $value);
}
