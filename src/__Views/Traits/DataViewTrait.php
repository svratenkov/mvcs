<?php
/*
	DataView is an extension of BaseView capable of manipulating it's data
*/
namespace Vsd\Mvcs\Views\Traits;

trait DataViewTrait
{
	/**
	 * Set the value of given view data key
	 * 
	 * @param	string	$key	Data item key
	 * @param	mixed	$value	Data item value
	 * @return	$this			Chained return
	 */
	public function set($key, $value)
	{
		$this->data[$key] = $value;

		// Chained return
		return $this;
	}

	/**
	 * Magic setter
	 * 
	 * @param	string	$key	Data item key
	 * @param	mixed	$value	Data item value
	 * @return	$this			Chained return
	 */
	public function __set($key, $value)
	{
		return $this->set($key, $value);
	}

	/**
	 * Add given data array to the view
	 * 
	 * @param	string|array	$key	Data item key | associative data array
	 * @param	mixed			$value	Data item value
	 * @return	$this					Chained return
	 */
	public function add($key, $value = NULL)
	{
		if (is_array($key)) {
			$this->data = array_merge($this->data, $key);
		}
		else {
			$this->set($key, $value);
		}

		// Chained return
		return $this;
	}

	/**
	 * Add a view instance to the view data
	 *
	 * @param	string		$key		Data item key
	 * @param	mixed		$template	View template of any type compatible to view renderer
	 * @param	array		$data		View associative data array
	 * @param	callable	$renderer	View renderer callable
	 * @return	$this					Chained return
	 */
	public function nest($key, $template = NULL, $data = [], $renderer = NULL)
	{
		return $this->with($key, new static($template, $data, $renderer));
	}

	/**
	 * Get the value of given view data key
	 * 
	 * @param	string	$key	Data item key
	 * @return	mixed			Data item value
	 */
	public function get($key)
	{
		return $this->data[$key];
	}

	/**
	 * Magic getter
	 * 
	 * @param	string	$key	Data item key
	 * @return	mixed			Data item value
	 */
	public function __get($key)
	{
		return $this->get($key);
	}

	/**
	 * Check existence of data item with given key
	 * 
	 * @param	string	$key	Data item key
	 * @return	bool
	 */
	public function has($key)
	{
		// Check for dynamic renderer property
		return isset($this->data[$key]) or array_key_exists($key, $this->data);
	}

	/**
	 * Magic key existence checking
	 * 
	 * @param	string	$key	Data item key
	 * @return	bool
	 */
	public function __isset($key)
	{
		// Check for dynamic renderer property
		return $this->has($key);
	}
}
