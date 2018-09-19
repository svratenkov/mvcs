<?php
/*
	SharedDataView is a view with shared (among all views) data
*/
namespace Vsd\Mvcs\Views\Traits;

trait SharedDataViewTrait
{
	/**
	 * Static view data shared by all view instances
	 * 
	 * @var	array	$shared	Shared view data assoc aray
	 */
	protected static $shared;

	/**
	 * Add given data to the view shared data
	 * 
	 * @param	string|array	$key	Data item key | associative data array
	 * @param	mixed			$value	Data item value
	 * @return	$this					Chained return
	 */
	public static function share($key, $value = NULL)
	{
		if (is_array($key)) {
			static::$shared = array_merge(static::$shared, $key);
		}
		else {
			static::$shared[$key] = $value;
		}
	}

	/**
	 * Get the value of shared view data given by it's key
	 * 
	 * @param	string	$key	Data item key
	 * @return	mixed			Data item value
	 */
	public static function shared($key, $default = NULL)
	{
		return isset(static::$shared[$key]) ? static::$shared[$key] : $default;
	}

	/**
	 * Unshare (remove) given shared data items
	 * 
	 * @param	mixed	$key	Data item keys to unshare
	 * @return	void
	 */
	public static function unshare($keys = NULL)
	{
		if (is_null($key)) {
			static::$shared = [];
			return;
		}

		foreach ((array) $keys as $key) {
			if (isset(static::$shared[$key])) {
				unset(static::$shared[$key]);
			}
		}
	}
}
