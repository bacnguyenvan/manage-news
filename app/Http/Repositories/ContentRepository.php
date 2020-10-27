<?php

namespace App\Http\Repositories;

class ContentRepository extends Repository{

	protected $modelName = 'Content';
	
	public function search($conditions = [], $options = []) {
		$query = $this->model;

		if(!empty($options['with'])) {
			$with = [];
			foreach($options['with'] as $item) {
				if($item['relation'] == 'article') {
					$with[] = 'article';
				}
			}
			$query = $query->with($with);
		}
		
		$query = $this->searchOptions($query, $options);
		return $query;
	}
}