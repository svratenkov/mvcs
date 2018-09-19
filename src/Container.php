<?php
/*
	Simple PsrSet container: Psr [has(), get()] + set()
*/
namespace Vsd\Mvcs;
use Vsd\Mvcs\Interfaces\PsrSetContainerInterface;
use Vsd\Mvcs\Exceptions\NotFoundException;

class Container implements PsrSetContainerInterface
{
	// Container's data array
	protected $data = [];

	/**
	 * Returns true if the container can return an entry for the given identifier.
	 * Returns false otherwise.
	 *
	 * `has($key)` returning true does not mean that `get($key)` will not throw an exception.
	 * It does however mean that `get($key)` will not throw a `NotFoundExceptionInterface`.
	 *
	 * @param string $key Identifier of the entry to look for.
	 *
	 * @return bool
	 */
	public function has($key = NULL)
	{
		return isset($this->data[$key]) or array_key_exists($key, $this->data);
	}

	/**
	 * Finds an entry of the container by its identifier and returns it.
	 *
	 * @param string $key Identifier of the entry to look for.
	 *
	 * @throws NotFoundExceptionInterface  No entry was found for **this** identifier.
	 * @throws ContainerExceptionInterface Error while retrieving the entry.
	 *
	 * @return mixed Entry.
	 */
	public function get($key)
	{
		if ($this->has($key)) {
			return $this->data[$key];
		}

		throw new NotFoundException("No entry was found in the container for `{$key}` key");
	}

	/**
	 * Set container item with given key and value
	 * 
	 * @param	string	$key	Container entry key
	 * @param	mixed	$value	Container entry value
	 * @return	void
	 */
	public function set($key, $value = NULL)
	{
		$this->data[$key] = $value;
	}
}
