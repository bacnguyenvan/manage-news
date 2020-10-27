<?php

namespace App\Http\Repositories;

class AdminUserRepository extends Repository{

	protected $modelName = 'AdminUser';
	
	public function search($conditions = [], $options = []) {
		$query = $this->findAllActive();

		$query = $this->searchOptions($query, $options);
		return $query;
	}
}