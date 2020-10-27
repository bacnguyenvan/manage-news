<?php

namespace App\Http\Services;

use AppData;
use View;

class AdminService extends Service {

	public $rules = [];

	public $messages = [];

	public $columnDisplayName = [];

	public function getListData($keys, $addOnData = []) {
		foreach($keys as $key) {
			$conditions = [];
			$list = collect();
			if($key == 'author') {
				$service = new AuthorService();
				$options = [
					'pluck' => 'author_name',
					'sort' => [
						'author_id' => 'asc'
					],
					'limit' => 50
				];
				
				if(!empty($addOnData['author_id'])) {
					if(is_array($addOnData['author_id'])) {
						$conditions = [
							'author_ids' => $addOnData['author_id']
						];
					} else {
						$conditions = [
							'author_id' => $addOnData['author_id']
						];
					}
					//get authors with ids
					$list = $list->union($service->repository()->search($conditions, $options));
				}
				//get first 50
				$list = $list->union($service->repository()->search([], $options));
				View::share('authors', $list->sortKeys());
			} else if($key == 'articleClass') {
				$service = new ArticleClassService();
				$options = [
					'pluck' => 'article_class_name',
					'sort' => [
						'article_class_id' => 'asc'
					],
					'limit' => 50
				];

				if(!empty($addOnData['article_class_id'])) {
					if(is_array($addOnData['article_class_id'])) {
						$conditions = [
							'article_class_ids' => $addOnData['article_class_id']
						];
					} else {
						$conditions = [
							'article_class_id' => $addOnData['article_class_id']
						];
					}
					$list = $list->union($service->repository()->search($conditions, $options));
				}
				$list = $list->union($service->repository()->search([], $options));
				View::share('articleClasses', $list->sortKeys());
			} else if($key == 'bookletClass') {
				$service = new BookletClassService();
				$options = [
					'pluck' => 'booklet_class_name',
					'sort' => [
						'booklet_class_id' => 'asc'
					],
					'limit' => 50
				];
				if(!empty($addOnData['booklet_class_id'])) {
					if(is_array($addOnData['booklet_class_id'])) {
						$conditions = [
							'booklet_class_ids' => $addOnData['booklet_class_id']
						];
					} else {
						$conditions = [
							'booklet_class_id' => $addOnData['booklet_class_id']
						];
					}
					$list = $list->union($service->repository()->search($conditions, $options));
				}
				$list = $list->union($service->repository()->search([], $options));
				View::share('bookletClasses', $list->sortKeys());
			} else if($key == 'topic') {
				$service = new TopicService();
				$options = [
					'pluck' => 'topics_name',
					'sort' => [
						'topics_id' => 'asc'
					],
					'limit' => 50
				];
				if(!empty($addOnData['topics_id'])) {
					if(is_array($addOnData['topics_id'])) {
						$conditions = [
							'topics_ids' => $addOnData['topics_id']
						];
					} else {
						$conditions = [
							'topics_id' => $addOnData['topics_id']
						];
					}
					$list = $list->union($service->repository()->search($conditions, $options));
				}
				$list = $list->union($service->repository()->search([], $options));
				View::share('topics', $list->sortKeys());
			}
		}
	}
}









