<?php namespace SynergyWholesale\Commands;

interface Command
{
	/**
	 * @return array    the array of key-value pairs to send for the command
	 */
	public function getRequestData();

	/**
	 * @return string	a unique key suitable for caching the response data (or null if uncachable)
	 */
	public function getKey();
}
