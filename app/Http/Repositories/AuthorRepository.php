<?php

namespace App\Http\Repositories;

class AuthorRepository extends Repository{

	protected $modelName = 'Author';
	
	public function search($conditions = [], $options = []) {

		$query = $this->model;

		if(!empty($conditions['keyword'])) {
			$query = $query->where(
				\DB::raw('concat(author_id,"-",author_name)') , 
				'LIKE' , 
				'%'.$conditions['keyword'].'%'
			);
		}

		if(!empty($conditions['author_name'])) {
			$query = $query->where(
				'author_name' , 
				'LIKE' , 
				'%'.$conditions['author_name'].'%'
			);
		}

		if(!empty($conditions['author_id'])) {
			$query = $query->where('author_id', $conditions['author_id']);
		}

		if(!empty($conditions['delete_flag'])) {
			$query = $query->where('delete_flag', $conditions['delete_flag']);
		} else {
			$query = $query->where('delete_flag', 0);
		}

		if(!empty($conditions['author_ids'])) {
			$query = $query->whereIn('author_id', $conditions['author_ids']);
		}
		
		$query = $this->searchOptions($query, $options);
		return $query;
	}
}