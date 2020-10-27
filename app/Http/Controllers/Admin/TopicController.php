<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
//Services
use App\Http\Services\TopicService;
use App\Http\Services\RelatedKeywordService;
//Helpers
use Auth;


class TopicController extends Controller
{
	public function __construct(TopicService $service) {
		$this->service = $service;
		$this->repository = $service->repository();
	}

	public function list(Request $request) {
		$errors = [];
		$errorMessage = '';
		$conditions = [];
		$options = [
			'select' => [ 
				'topics_id', 
				'topics_name',
				'topics_phonetic',
				'display_order',
				'cutline'
			],
			'distinct' => 'topics_id',
			'sort' => [
				'display_order' => 'asc',
			],
			'get' => true,
			'limit' => 50//想定では、最大でも50行以下です。
		];

		$list = $this->repository->search($conditions, $options);

		if($list->isEmpty()) {
			$errors['from'] = $errorMessage = '対象データがありません。';
		}

		return view('admin.topics.list', [
			'list' => $list, 
		]);
	}

	public function update(Request $request) {
		$status = 200;
		$response = [];
		$data = $request->all();
		$dataErrors = [];
		$errorMessages = [];
		if(!empty($data)) {
			$next = true;
			foreach($data as $inputs) {
				$this->service->updateRules($inputs);
				$errors = $this->service->checkValidate($inputs);
				if(!empty($errors)) {
					$errorMessage = trim($this->service->errorMessages($errors));
					$dataErrors[] = [
						'id' => $inputs['type']=='create'?'new':$inputs['topics_id'],
						'errors' => $errors
					];
					if(!in_array($errorMessage, $errorMessages) && !empty($errorMessage)) {
						$errorMessages[] = $errorMessage;
					}
					$next = false;
				}
			}
			if($next) {
				foreach($data as $inputs) {
					$inputs['updated_user_id'] = Auth::guard('admin')->user()->admin_user_id;
					if($inputs['type'] == 'create') {
						$idNewRecord = $this->repository->create($inputs);
					} else if($inputs['type'] == 'edit') {
						$this->repository->updateByPk($inputs['topics_id'], $inputs);
					}
				}
				if(!empty($idNewRecord)){
					session()->flash('message', '続いて、追加したトピックスの関連キーワードを登録してください。');
					$response = ['redirect' => route('admin-topics-keywords',$idNewRecord->topics_id)];
				}else{
					session()->flash('message', 'データを更新しました。');
					$response = ['redirect' => route('admin-topics-list')];
				}
				
			}
		}

		if(!empty($dataErrors)) {
			$status = 422;
			$dataErrors['errorMessage'] = implode('', $errorMessages);
			$response = $dataErrors;
		}

		return response()->json($response, $status)
				->header('Content-Type', 'application/json');
	}

	public function keywords($pk, Request $request) {

		if(empty($pk)) {
			abort(404);
		}

		$options = [
			'findByPk' => $pk,
			'select' => [ 
				'topics_id',
				'topics_name',
				'display_order',
				'cutline',
			],
			'with' => [
				[
					'relation' => 'keywords',
					'options' => [
						'select' => [
							'related_keyword_id as id', 
							'related_keywords_name as keyword',
							'related_keywords.topics_id'
						],
						'query' => true
					]
				],
			]
		];

		$data = $this->repository->search([], $options);

		$inputs = [
			'new' => $request->input('new', []),
			'remove' => $request->input('remove', []),
		];

		if($request->isMethod('post')) {
			$keywordIds = $data->keywords->pluck('id')->toArray();
			//available keywords
			$availableKeywordIds = array_diff($keywordIds, $inputs['remove']);
			$keywords = $data->keywords
				->whereIn('id', $availableKeywordIds)
				->pluck('keyword')
				->toArray();

			$inputs['keywords'] = array_merge($keywords, $inputs['new']);

			$errors = $this->service->validateKeywords($inputs);

			if(!empty($errors)) {
				$errorMessage = $this->service->errorMessages($errors);
				return back()->with([
					'errorMessage' => $errorMessage,
					'errors' => $errors
				]);
			} else {
				if(!empty($inputs['new'])) {
					$new = [];
					foreach($inputs['new'] as $keyword) {
						$new[] = [
							'related_keywords_name' => $keyword,
							'topics_id' => $pk,
							'updated_user_id' => Auth::guard('admin')->user()->admin_user_id,
							'created_at' => date('Y-m-d H:i:s'),
							'updated_at' => date('Y-m-d H:i:s')
						]; 
					}
					$result = $data->keywords()->insert($new);
				}

				if(!empty($inputs['remove'])) {
					$result = $data->keywords()
						->whereIn('related_keyword_id', $inputs['remove'])
						->update([
						'delete_flag' => 1
					]);
				}
				return redirect()->route('admin-topics-list')->with([
					'message' => 'データを更新しました。'
				]);
			}
		}

		return view('admin.topics.keywords', [
			'data' => $data
		]);
	}

	//post from ajax
	public function ajaxValidateKeyword(Request $request) {
		$status = 200;
		$response = [];
		$inputs = [
			'related_keywords_name' => $request->input('keyword')
		];

		$service = new RelatedKeywordService();
		$errors = $service->checkValidate($inputs);
		if(!empty($errors)) {
			$status = 422;
			$errorMessage = $service->errorMessages($errors);
			$response = [
				'errorMessage' => $errorMessage
			];
		}

		return response($response, $status)
			->header('Content-Type', 'application/json');
	}

	public function ajaxSearch(Request $request) {
		$status = 200;
		$response = [];
		if(Auth::guard('admin')->check()) {
			$keyword = $request->input('keyword', '');
			$conditions = [
				'keyword' => $keyword
			];
			$options = [
				'limit' => 100,
				'select' => [
					'topics_id as id',
					\DB::raw("concat(topics_id, '-', topics_name) as text")
				],
				'get' => true
			];
			$list = $this->repository->search($conditions, $options);
			$response = $list->toJson();
		} else {
			$status = 401;
		}

		return (new Response($response, $status))
				->header('Content-Type', 'application/json');
	}

	public function ajaxDelete(Request $request) {
		$response = [
			'message' => '',
		];

		$status = 200;
		if(Auth::guard('admin')->check()) {
			$data = $request->all();
			$result = $this->repository->softDeleteListPk($data);
			session()->flash('message', 'データを削除しました。');
		} else {
			$status = 401;
		}

		return (new Response($response, $status))
				->header('Content-Type', 'application/json');
	}
}
















