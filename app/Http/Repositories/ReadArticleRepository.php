<?php

namespace App\Http\Repositories;
use Auth;

class ReadArticleRepository extends Repository{

	protected $modelName = 'ReadArticle';
	
	public function search($conditions = [], $options = []) {
		$query = $this->model;

		if(!empty($conditions['journal_user_id'])) {
			$query = $query->where('journal_user_id', $conditions['journal_user_id']);
		}

		$query = $this->searchOptions($query, $options);
		return $query;
	}
}