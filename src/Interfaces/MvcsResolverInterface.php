<?php
namespace Vsd\Mvcs\Interfaces;

interface MvcsResolverInterface
{
	/**
	 * Parse route action pattern and resolve it to a standard MVCS responder
	 * 
	 * @param	string	$pattern	Route action pattern, i.e. 'product@info'
	 * @return	callable	MVCS responder callable
	 */
	public function resolve($pattern);
}
