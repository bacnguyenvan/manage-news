<?php

namespace App\Http\Repositories;

class BookletClassRepository extends Repository{

	protected $modelName = 'BookletClass';
	
	public function search($conditions = [], $options = []) {
		$query = $this->model;
		
		if(!empty($conditions['keyword'])) {
			$query = $query->where(
				\DB::raw('concat(booklet_class_id,"-", booklet_class_name)') , 
				'LIKE' , 
				'%'.$conditions['keyword'].'%'
			);
		}

		if(!empty($conditions['booklet_class_id'])) {
			$query = $query->where('booklet_class_id', $conditions['booklet_class_id']);
		}

		if(!empty($conditions['booklet_class_ids'])) {
			$query = $query->whereIn('booklet_class_id', $conditions['booklet_class_ids']);
		}

		$query = $this->searchOptions($query, $options);
		return $query;
	}
}