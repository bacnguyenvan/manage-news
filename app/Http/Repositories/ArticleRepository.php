<?php

namespace App\Http\Repositories;

class ArticleRepository extends Repository{

	protected $modelName = 'Article';

	public function search($conditions = [], $options = []) {
		$query = $this->model;

		if(!empty($conditions['author_id'])) {
			//aa = article_author
			$query = $query->join(
				\DB::raw(
					'(
					SELECT 
						article_id as aa_article_id, 
						author_id as aa_author_id
					FROM 
						article_author 
					WHERE 
						author_id = '.$conditions['author_id'].'
				) aa'
				),
				'aa_article_id', 
				'article_id'
			);
		}

		if(!empty($conditions['article_class_id'])) {
			//aac = article_article_class
			$query = $query->join(
				\DB::raw(
					'(
						SELECT 
							article_id as aac_article_id, 
							article_class_id as article_class_id
						FROM 
							article_article_class
						WHERE 
							article_class_id = '.$conditions['article_class_id'].'
					) article_article_class'
				),
				'aac_article_id', 
				'article_id'
			);
		}

		// ranking frontend
		if(!empty($conditions['from_date'])) {
			$query = $query->where('issue_date', '>=', $conditions['from_date']);
		}

		if(!empty($conditions['to_date'])) {
			$query = $query->where('issue_date', '<=', $conditions['to_date']);
		}

		if(!empty($conditions['delete_flag'])) {
			$query = $query->where('article.delete_flag', $conditions['delete_flag']);
		} else {
			$query = $query->where('article.delete_flag', 0);
		}

		if(!empty($conditions['title'])) {
			$query = $query->where('title', 'like', '%'.trim($conditions['title']).'%');
		}

		if(!empty($conditions['topics_id'])) {
			$query = $query->join('article_topics', 'article_topics.article_id', 'article.article_id')
				->where('article_topics.topics_id', $conditions['topics_id']);
		}

		if(isset($conditions['not_viewable_flag'])) {
			$query = $query->where('not_viewable_flag', $conditions['not_viewable_flag']);
		}

		if(isset($conditions['search_target_flag'])) {
			$query = $query->where('search_target_flag', $conditions['search_target_flag']);
		}

		if(!empty($conditions['from'])) {
			$from = date('Y-m-01', strtotime($conditions['from']));
			$query = $query->where('issue_date', '>=', $from);
		}

		if(!empty($conditions['to'])) {
			$to = date('Y-m-t', strtotime($conditions['to']));
			$query = $query->where('issue_date', '<=', $to);
		}
		
		if(!empty($conditions['article_type'])) {
			$query = $query->where('article_type', $conditions['article_type']);
		}

		if(!empty($options['with'])) {
			$with = [];
			foreach($options['with'] as $item) {
				if($item['relation'] == 'authors') {
					$repository = new AuthorRepository();
					$with['authors'] = $this->getRelationData($repository, $item);
				} else if($item['relation'] == 'articleClasses') {
					$repository = new ArticleClassRepository();
					$with['articleClasses'] = $this->getRelationData($repository, $item);
				} else if($item['relation'] == 'topics') {
					$repository = new TopicRepository();
					$with['topics'] = $this->getRelationData($repository, $item);
				} else if($item['relation'] == 'bookletClass') {
					$with[] = 'bookletClass';
				} else if($item['relation'] == 'contents') {
					$repository = new ContentRepository();
					$with['contents'] = $this->getRelationData($repository, $item);
				} else if($item['relation'] == 'userReadArticles') {
					$repository = new ReadArticleRepository();
					$with['userReadArticles'] = $this->getRelationData($repository, $item);
				} else if($item['relation'] == 'bookstore') {
					$repository = new BookstoreRepository();
					$with['bookstore'] = $this->getRelationData($repository, $item);
				} 
			}
			$query = $query->with($with);
		}

		$query = $this->searchOptions($query, $options);

		return $query;
	}

}












