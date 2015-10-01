<?php

namespace App\Repositories;

/**
 * Repository layer to access models
 */

abstract class BaseRepository {

	protected $model;

	/**
	 * Constructor
	 */
	public function __construct()
	{
		//
	}

	/**
	 * Recieve object of model
	 */
	public function getModel()
	{
		return $this->model;
	}

	/**
	 * Proxy for object methods
	 */
	public function __call($method, $parameters)
	{
		$instance = new $this->model;

		return call_user_func_array(array($instance, $method), $parameters);
	}

}