<?php

namespace App\Http\Repositories;

class ArticleClassRepository extends Repository{

	protected $modelName = 'ArticleClass';
	
	public function search($conditions = [], $options = []) {
		$query = $this->model;

		if(!empty($conditions['keyword'])) {
			$query = $query->where(
				\DB::raw('concat(article_class_id,"-",article_class_name)') , 
				'LIKE' , 
				'%'.$conditions['keyword'].'%'
			);
		}

		if(!empty($conditions['article_class_id'])) {
			$query = $query->where('article_class_id', $conditions['article_class_id']);
		}
		
		if(!empty($conditions['article_class_ids'])) {
			$query = $query->whereIn('article_class_id', $conditions['article_class_ids']);
		}

		$query = $this->searchOptions($query, $options);
		return $query;
	}
}