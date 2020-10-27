<?php

namespace App\Http\Repositories;

class BookstoreRepository extends Repository{

	protected $modelName = 'Bookstore';
	
	public function search($conditions = [], $options = []) {

		$query = $this->model;
		
		$query = $this->searchOptions($query, $options);
		return $query;
	}
}