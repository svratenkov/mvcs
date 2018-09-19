<?php
/**
 * Parse string request patterns to a core (basic) array request
 * This parser is based on a simple grammar with special chars for each component
 * Incapsulates all grammar specifics
 * 
 * Grammar definition:
 * 
 * 	<chainDelimiter>, <filterDelimiter>, <methodDelimiter>	::=	<keyword string>
 *  <arg>		::=	<string>
 *  <key>		::=	<container key>
 *  <filter>	::=	<special container key> | <string>
 * 
 * 	<chain>		::= <filter> [<chainDelimiter> <filter>]...
 * 	<filter>	::= <string> [<filterDelimiter> <arg>]...
 * 	<keyMethod>	::= <key><methodDelimiter><string>
 */
namespace Vsd\Mvcs;

class Parser
{
	/**
	 * @var	array	This grammar syntax delimiters
	 */
	protected $delimiters = [
		'chain'		=> '>',		// 'action[ > action]...' - actions delimiter in the actions chain
		'args'		=> ',',		// 'name[,arg]...' - name|args delimiter in the action
		'method'	=> ':',		// 'key:method' - [object|class key, 'method'] delimiter
	];

	/**
	 * @param	array	$delimiters	Custom grammar delimiters
	 * @return	void
	 */
	public function __construct($delimiters = [])
	{
		$this->setDelimiters($delimiters);
	}

	/**
	 * Define custom delimiters
	 * 
	 * @param	array	$delimiters	Custoom grammar delimiters
	 * @return	void
	 */
	public function setDelimiters($delimiters = [])
	{
		$this->delimiters = array_merge($this->delimiters, $delimiters);
	}

	/**
	 * Get requested delimiter value
	 * 
	 * @param	string	$key	Delimiter key
	 * @return	void
	 */
	public function getDelimiter($key)
	{
		return $this->delimiters[$key];
	}

	/**
	 * Parse filters chain pattern: <filter>[ `>` <filter>]...
	 * 
	 * @param	string	$pattern	Pattern
	 * 
	 * @return	array				List array of scenes in parsed scenario
	 */
	public function parseChain($pattern)
	{
		// Clear spaces
		$pattern = str_replace(' ', '', $pattern);

		// Split chain to an array of filters
		return explode($this->delimiters['chain'], $pattern);
	}

	/**
	 * Parse scenario action pattern: '<action>[,arg]...'
	 * 
	 * @param	string	$pattern	Pattern
	 * 
	 * @return	array	Index array of actions and their args
	 */
	public function parseArgs($pattern)
	{
		return explode($this->delimiters['args'], $pattern);
	}

	/**
	 * Parse `key:method` pattern
	 * 
	 * @param	string	$pattern	`key:method` pattern
	 * 
	 * @return	array|NULL	[key, method] list array or NULL if `method` delimiter not found
	 */
	public function parseKeyMethod($pattern)
	{
		return sizeof($parts = explode($this->delimiters['method'], $pattern)) == 2 ? $parts : NULL;
	}
}
