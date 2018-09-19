<?php
namespace Vsd\Mvcs\Interfaces;

interface MvcsParserInterface
{
	/**
	 * Parse MVCS pattern
	 * 
	 * @param	string	$pattern	MVCS 'compiler,decorator' pattern
	 * 
	 * @throws	MvcsPatternException	'MVCS pattern syntax error'
	 * 
	 * @return	array	Index array of resolved MVCS callables:
	 * 						['decorator', <compiler>, <decorator>]
	 * 						['renderer',  <compiler>, <template>, <renderer>]
	 * 						['view',      <compiler>, <template>, <view>]
	 */
	public function parse($pattern);
}
