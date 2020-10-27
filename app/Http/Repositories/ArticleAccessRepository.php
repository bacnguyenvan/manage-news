<?php

namespace App\Http\Repositories;

class ArticleAccessRepository extends Repository{

	protected $modelName = 'ArticleAccess';
	
	public function search($conditions = [], $options = []) {
		$query = $this->model;

		$query = $this->searchOptions($query, $options);
		return $query;
	}
	
}