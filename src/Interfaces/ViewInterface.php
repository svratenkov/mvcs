<?php
/*
	ViewInterface
	Could be used for View class identification through instanceof
*/
namespace Vsd\Mvcs\Interfaces;

interface ViewInterface
{
	/**
	 * Render view using its renderer, template and data
	 * @return string
	 */
	public function render();
}
