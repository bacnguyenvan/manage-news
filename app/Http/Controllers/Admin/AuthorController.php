<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
//Services
use App\Http\Services\AuthorService;
//Helpers
use Auth;


class AuthorController extends Controller
{
	public function __construct(AuthorService $service) {
		$this->service = $service;
		$this->repository = $service->repository();
	}

	public function list(Request $request) {
		$inputs = [
			'author_name' => $request->input('author_name', null)
		];

		$conditions = [];

		if($request->isMethod('post')) {
			$errors = $this->service->checkConditions($inputs);
			if(!empty($errors)) {
				$errorMessage = $this->service->errorMessages($errors);
				return back()->with([
					'errors' => $errors,
					'errorMessage' => $errorMessage
				])->withInput();
			} else {
				$conditions = $inputs;
			}
		}
		
		$options = [
			'select' => [
				'author_id',
				'author_name',
				'author_phonetic',
				'created_at',
				'updated_at',
			],
			'sort' => [
				'author_id' => 'asc'
			]
		];

		$list = $this->repository->search($conditions, $options);

		return view('admin.authors.list', [
			'list' => $list,
			'inputs' => $inputs
		]);
	}

	public function create(Request $request) {
		$inputs = [
			'authors' => $request->input('authors', [])
		];

		if($request->isMethod('post')) {
			//return [errorMessage =>'', errors => []]
			$errors = $this->service->checkValidateCreateAuthors($inputs);

			if(!empty($errors['errorMessage'])) {
				return back()->with($errors)->withInput();
			} else {
				$data = [];
				foreach($inputs['authors'] as $author) {
					if(!empty($author['author_name']) && !empty($author['author_phonetic'])) {
						$data[] = [
							'author_name' => $author['author_name'],
							'author_phonetic' => $author['author_phonetic'],
							'created_at' => date('Y-m-d H:i:s'),
							'updated_at' => date('Y-m-d H:i:s'),
							'updated_user_id' => Auth::guard('admin')->user()->admin_user_id
						];
					}
					
				}
				$this->repository->insertData($data);
				return redirect()->route('admin-authors-list')->with([
					'message' => 'データを登録しました。'
				]);
			}
		}

		if(!empty(old())) {
			$inputs = old();
		}

		return view('admin.authors.create', [
			'inputs' => $inputs
		]);
	}

	public function ajaxCreate(Request $request) {
		$status = 200;
		$response = [];

		$inputs = [
			'authors' => $request->input('authors', [])
		];

		$errors = $this->service->checkValidateCreateAuthors($inputs);

		if(!empty($errors)) {
			$response['errors'] = $errors;
		}
	}

	public function edit($pk, Request $request) {
		if(empty($pk)) {
			abort(404);
		}

		$conditions = [];
		$options = [
			'findByPk' => $pk,
			'select' => [
				'author_id',
				'author_name',
				'author_phonetic',
			]
		];
		$data = $this->repository->search($conditions, $options);

		if($request->isMethod('post')) {
			$inputs = [
				'author_name' => $request->input('author_name', null),
				'author_phonetic' => $request->input('author_phonetic', null),
				'updated_user_id' => Auth::guard('admin')->user()->admin_user_id
			];

			$errors = $this->service->checkValidate($inputs);

			if(!empty($errors)) {
				$errorMessage = $this->service->errorMessages($errors);
				return back()->with([
					'errors' => $errors,
					'errorMessage' => $errorMessage
				])->withInput();
			} else {
				$this->repository->updateByPK($pk, $inputs);
				return redirect()->route('admin-authors-list')->with([
					'message' => 'データを更新しました。'
				]);
			}
		}

		if(!empty(old())) {
			$data = array_merge($data->toArray(), old());
		}

		return view('admin.authors.edit', [
			'data' => $data
		]);
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
					'author_id as id',
					\DB::raw("concat(author_id, '-', author_name) as text")
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
}