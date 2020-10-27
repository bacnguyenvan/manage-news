<?php

namespace App\Http\Repositories;

class TopicRepository extends Repository{

	protected $modelName = 'Topic';
	
	public function search($conditions = [], $options = []) {
		$query = $this->model;

		if(!empty($conditions['keyword'])) {
			$query = $query->where(
				\DB::raw('concat(topics_id," ",topics_name)') , 
				'LIKE' , 
				'%'.$conditions['keyword'].'%'
			);
		}

		if(!empty($conditions['topics_id'])) {
			$query = $query->where('topics_id', $conditions['topics_id']);
		}

		if(!empty($conditions['topics_ids'])) {
			$query = $query->whereIn('topics_id', $conditions['topics_ids']);
		}

		if(!empty($conditions['delete_flag'])) {
			$query = $query->where('topics.delete_flag', $conditions['delete_flag']);
		} else {
			$query = $query->where('topics.delete_flag', 0);
		}

		if(!empty($options['with'])) {
			$with = [];

			foreach($options['with'] as $item) {
				if($item['relation'] == 'keywords') {
					$repository = new RelatedKeywordRepository();
					$with['keywords'] = $this->getRelationData($repository, $item);
				}
			}
			$query = $query->with($with);
		}
		
		$query = $this->searchOptions($query, $options);
		return $query;
	}
}