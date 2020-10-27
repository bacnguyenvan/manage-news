<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Auth;
use App\Http\Services\ArticleClassService;

class ArticleClassController extends Controller
{
	public function __construct(ArticleClassService $service) {
		$this->service = $service;
		$this->repository = $service->repository();
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
					'article_class_id as id',
					\DB::raw("concat(article_class_id, '-', article_class_name) as text")
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