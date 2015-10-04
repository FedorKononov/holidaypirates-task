<?php

namespace App\Repositories;

use App\Models\Job\Job;

/**
 * Jobs repository layer
 */

class JobRepository extends BaseRepository
{

	public function __construct(Job $model)
	{
		$this->model = $model;

		parent::__construct();
	}

}