<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
//Services
use App\Http\Services\ArticleService;
use App\Http\Services\AdminService;
use App\Models\Article;
//Helpers
use App\Http\Helpers\AppData;
use Auth;
use DateTime;

class ArticleController extends Controller
{
	public function __construct(ArticleService $service) {
		$this->service = $service;
		$this->repository = $service->repository();
	}

	public function list(Request $request) {
		$inputs = [
			'title' => $request->input('title', null),
			'author_id' => $request->input('author_id', null),
			'article_class_id' => $request->input('article_class_id', null),
			'from' => $request->input('from', null),
			'to' => $request->input('to', null),
			'search_target_flag' => $request->input('search_target_flag', 1),
			'not_viewable_flag' => $request->input('not_viewable_flag', 1),
		];

		$errors = [];
		$errorMessage = '';
		$conditions = $inputs;
		$options = [
			'select' => [ 
				'article_id', 
				'title', 
				'issue_date', 
				'page',
				'search_target_flag',
				'not_viewable_flag',
			],
			'distinct' => 'article_id',
			'sort' => [
				'issue_date' => 'desc',
				'page' => 'asc'
			],
			'with' => [
				[
					'relation' => 'authors',
					'options' => [
						'select' => ['author_name'],
						'query' => true
					]
				], [
					'relation' => 'articleClasses',
					'options' => [
						'select' => ['article_class_name'],
						'query' => true
					]
				], 
			]
		];

		$errors = $this->service->checkConditions($conditions);

		if(!empty($errors)) {
			$errorMessage = $this->service->errorMessages($errors);
			return redirect()->back()->with([
				'errors' => $errors,
				'errorMessage' => $errorMessage
			])->withInput();
		}

		if(!empty($conditions['from'])) {
			$conditions['from'] = DateTime::createFromFormat('Y/m', $conditions['from'])
										->format('Y-m');
		}

		if(!empty($conditions['to'])) {
			$conditions['to'] = DateTime::createFromFormat('Y/m', $conditions['to'])
										->format('Y-m');
		}

		$list = $this->repository->search($conditions, $options);

		if($list->isEmpty()) {
			$errors['from'] = $errorMessage = '対象データがありません。';
		}

		$adminService = new AdminService();
		$adminService->getListData([
			'author',
			'articleClass',
		], $inputs);

		return view('admin.articles.list', [
			'inputs' => $inputs,
			'list' => $list->appends($inputs),
			'errors' => $errors,
			'errorMessage' => $errorMessage
		]);
	}

	public function create(Request $request) {
		$inputs = $this->service->getInputFromRequest($request);
		if($request->isMethod('post')) {
			$errors = $this->service->checkValidate($inputs);

			//Check maximum article_topics
			$topicIds = array_filter($inputs['topics_id'], 
				function($id) {
					if(!empty($id)) {
						return $id;
					}
			});
			if(count($topicIds) > AppData::maximumTopicsAssociateArticle){
				$errors['topics_id'] = [
					'トピックスを登録できる件数を超えています。'
				];
			}

			if(!empty($errors)) {
				$errorMessage = $this->service->errorMessages($errors);
				return redirect()->back()->with([
					'errors' => $errors,
					'errorMessage' => $errorMessage
				])->withInput();
			} else {
				//create data
				$new = $this->repository->create($inputs);

				if(!empty($new)) {
					$user_loggin = Auth::guard('admin')->user()->admin_user_id;
					// article_author
					$otherDataOfAuthorSyns = [
						'updated_user_id' => $user_loggin
					];
					$authors = $this->service->getDataToSyns($inputs['author_id'],$otherDataOfAuthorSyns);
					$new->authors()->sync($authors);

					// article_article_class
					$articleClassIds = array_filter($inputs['article_class_id'], 
						function($id) {
							if(!empty($id)) {
								return $id;
							}
					});
					$otherDataOfArticleClassSyns = [
						'updated_user_id' => $user_loggin
					];
					$articleClass = $this->service->getDataToSyns($articleClassIds,$otherDataOfArticleClassSyns);
					$new->articleClasses()->sync($articleClass);

					// article_topics 
					$topicIds = array_filter($inputs['topics_id'], 
						function($id) {
							if(!empty($id)) {
								return $id;
							}
					});
					$otherDataOfTopicSyns = [
						'updated_user_id' => $user_loggin,
						'manual_input_flag' => 1, // 1：手入力
					];
					$topicSyns = $this->service->getDataToSyns($topicIds,$otherDataOfTopicSyns);
					$new->topics()->sync($topicSyns);
				}
				return redirect()->route('admin-articles-list')->with([
					'message' => 'データを登録しました。'
				]);
			}
		}

		$adminService = new AdminService();
		$adminService->getListData([
			'author',
			'articleClass',
			'topic',
			'bookletClass'
		], $inputs);

		if(!empty(old())) {
			$inputs = old();
		}

		return view('admin.articles.create', [
			'data' => $inputs
		]);
	}

	public function edit($pk, Request $request) {

		if(empty($pk)) {
			abort(404);
		}

		$options = [
			'findByPk' => $pk,
			'select' => [ 
				'article_id', 
				'wb_book_seq',
				'title', 
				'wrap_up',
				'letter_body',
				'issue_date', 
				'booklet_class_id',
				'page',
				'search_target_flag',
				'not_viewable_flag',
				'article_type',
				'src_basename',
				'release_flag'
			],
			'with' => [
				[
					'relation' => 'authors',
					'options' => [
						'select' => [
							'author.author_id as author_id', 
							'author_name'
						],
						'query' => true
					]
				],  [
					'relation' => 'bookletClass',
					'options' => [
						'select' => [
							'booklet_class_name'
						],
						'query' => true
					]
				], [
					'relation' => 'articleClasses',
					'options' => [
						'select' => [
							'article_class.article_class_id as article_class_id', 
							'article_class_name'
						],
						'query' => true
					]
				], [
					'relation' => 'topics',
					'options' => [
						'select' => [
							'topics.topics_id as topics_id', 
							'topics_name'
						],
						'query' => true
					]
				], 
			]
		];

		$article = $this->repository->search([], $options);

		if(empty($article)) {
			abort(404);
		}

		$inputs = $this->service->getInputFromRequest($request);
		$user_loggin = Auth::guard('admin')->user()->admin_user_id;

		if($request->isMethod('post')) {
			$errors = $this->service->checkValidate($inputs);
			
			//Check maximum article_topics
			$topicIds = array_filter($inputs['topics_id'], 
				function($id) {
					if(!empty($id)) {
						return $id;
					}
			});
			if(count($topicIds) > AppData::maximumTopicsAssociateArticle){
				$errors['topics_id'] = [
					'トピックスを登録できる件数を超えています。'
				];
			}
			// add rules 論稿区分
			if($inputs['article_type'] == "1" && $inputs['search_target_flag'] == "1"){
				$errors['article_type_and_search_target_flag'] = [
					'論稿区分が１冊のブックの場合、検索可はオフにしてください。'
				];
			}

			//syns article_author
			$otherDataOfAuthorSyns = [
				'updated_user_id' => $user_loggin
			];
			$authors = $this->service->getDataToSyns($inputs['author_id'],$otherDataOfAuthorSyns);
			$article->authors()->sync($authors);
				
			if(!empty($errors)) {
			
				$errorMessage = $this->service->errorMessages($errors);
				return redirect()->back()->with([
					'errors' => $errors,
					'errorMessage' => $errorMessage
				])->withInput();
			} else {
				//update data
				$result = $this->repository->updateByPk($pk, $inputs);
				if($result) {
					
					// article_article_class
					$articleClassIds = array_filter($inputs['article_class_id'], 
						function($id) {
							if(!empty($id)) {
								return $id;
							}
					});
					$otherDataOfArticleClassSyns = [
						'updated_user_id' => $user_loggin
					];
					$articleClass = $this->service->getDataToSyns($articleClassIds,$otherDataOfArticleClassSyns);
					$article->articleClasses()->sync($articleClass);

					// article_topics
					$otherDataOfTopicSyns = [
						'updated_user_id' => $user_loggin,
						'manual_input_flag' => 0, //0：自動生成,  1：手入力
					];
					$topicSyns = $this->service->getDataToSyns($topicIds,$otherDataOfTopicSyns);
					$article->topics()->sync($topicSyns);
				}
			}

			return redirect()->route('admin-articles-list')->with([
				'message' => 'データを更新しました。'
			]);
		}

		$data = $article->toArray();
		$data['author_id'] = $article->authors->pluck('author_id')->toArray();
		$data['article_class_id'] = $article->articleClasses->pluck('article_class_id')->toArray();
		$data['topics_id'] = $article->topics->pluck('topics_id')->toArray();
		$data = array_merge($data, old());

		$adminService = new AdminService();
		$adminService->getListData([
			'author',
			'articleClass',
			'topic',
			'bookletClass'
		], $data);

		return view('admin.articles.edit', [
			'data' => $data
		]);
	}

	public function ajaxDelete(Request $request) {
		$response = [
			'message' => '',
		];

		$status = null;
		if(Auth::guard('admin')->check()) {
			$data = $request->all();
			$result = $this->repository->softDeleteListPk($data);
			if(!empty($result)) {
				session()->flash('message', 'データを削除しました。');
				$status = 200;
			} else {
				$status = 422;
			}
		} else {
			$status = 401;
		}

		return (new Response($response, $status))
				->header('Content-Type', 'application/json');
	}
}














