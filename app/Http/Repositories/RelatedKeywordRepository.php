<?php

namespace App\Http\Repositories;

class RelatedKeywordRepository extends Repository{

	protected $modelName = 'RelatedKeyword';
	
	public function search($conditions = [], $options = []) {
		$query = $this->model;

		if(!empty($conditions['delete_flag'])) {
			$query = $query->where('related_keywords.delete_flag', $conditions['delete_flag']);
		} else {
			$query = $query->where('related_keywords.delete_flag', 0);
		}

		$query = $this->searchOptions($query, $options);
		return $query;
	}
}