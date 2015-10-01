<?php

namespace App\Repositories;

use App\Models\User\User;

/**
 * Users repository layer
 */

class UserRepository extends BaseRepository {

	public function __construct(User $model)
	{
		$this->model = $model;

		parent::__construct();
	}

}