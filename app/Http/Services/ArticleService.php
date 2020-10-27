<?php

namespace App\Http\Services;

use AppData;
use View;
use Auth;

use DB;


class ArticleService extends Service{

	public $instance;

	protected $repositoryName = 'Article';
	
	public $columnDisplayName = [
		'title' => 'タイトル',
		'wrap_up' => '要約',
		'letter_body' => '本文',
		'issue_date' => '発行年月日',
		'page' => '掲載頁',
		'author_id' => '著者',
		'article_class_id' => '論稿種別',
		'topics_id' => 'トピックス',
		'booklet_class_id' => '冊子種別',
		'wb_book_seq' => 'ブックSEQ'
	];

	public $rules = [
		'title' => 'required|max:200',
		'wrap_up' => 'required|max:1000',
		'letter_body' => 'required|max:15000',
		'issue_date' => 'required|date_format:Y/m/d',
		'page' => 'required|numeric|min:1|max:999',
		'author_id' => 'required',
		'article_class_id' => 'array_has_one',
		'booklet_class_id' => 'required',
		'topics_id' => 'array_has_one',
		'wb_book_seq' => ['required','max:11','regex:/^[0-9\s]+$/u'],
		'src_basename' => 'max:100'
    ];

    public $messages = [
    	'page.max' => '掲載頁は3桁以内で入力してください。',
    	'page.min' => '掲載頁が正しくありません。',
    	'article_class_id.array_has_one' => '論稿種別を選択してください。',
    	'topics_id.array_has_one' => 'トピックスを選択してください。',
    	'booklet_class_id.required' => '冊子種別を選択してください。',
    	'author_id.required' => '著者を選択してください。',
    	'wb_book_seq.regex' => 'ブックSEQが正しくありません。',
    	'wb_book_seq.max' => 'ブックSEQは11桁以内で入力してください。',
    	'src_basename.max' => '変換元ファイル名は100文字以内で入力してください。'
    ];

    public function checkConditions($conditions) {
		$rules = [];
		$messages = [];
		if(!empty($conditions['from'])) {
			$rules['from'][] = 'date_format:Y/m';
			$messages['from.date_format'] = '発行年月が正しくありません。';
			if(!empty($conditions['to'])) {
				$rules['from'][] = 'before_or_equal:to';
				$messages['from.before_or_equal'] = '発行年月が正しくありません。';
			}
		}

		if(!empty($conditions['to'])) {
			$rules['to'] = 'date_format:Y/m';
			$messages['to.date_format'] = '発行年月が正しくありません。';
		}

		$this->rules = $rules;
		$this->messages = $messages;

		$errors = $this->checkValidate($conditions);
		return $errors;
	}

	public function getInputFromRequest($request) {
		$inputs = [
			'title' => $request->input('title', null),
			'wrap_up' => $request->input('wrap_up', null),
			'letter_body' => $request->input('letter_body', null),
			'issue_date' => $request->input('issue_date', ''),
			'page' => $request->input('page', null),
			'booklet_class_id' => $request->input('booklet_class_id', null),
			'search_target_flag' => $request->input('search_target_flag', 1),
			'not_viewable_flag' => $request->input('not_viewable_flag', 0),
			'author_id' => $request->input('author_id', []),
			'article_class_id' => $request->input('article_class_id', []),
			'topics_id' => $request->input('topics_id', []),
			'wb_book_seq' => $request->input('wb_book_seq', null),
			'updated_user_id' => Auth::guard('admin')->user()->admin_user_id,
			'article_type' => $request->input('article_type', 0),
			'src_basename' => $request->input('src_basename', null),
			'release_flag' => $request->input('release_flag', 0),
		];

		return $inputs;
	}

	public function getDataToSyns($data, $otherdataSyns = [])
	{
		$dataSyns = [];
		
		array_map(function($id) use (&$dataSyns, $otherdataSyns ){
			$dataSyns[$id] = $otherdataSyns;

			return $dataSyns[$id];
		}, $data);

		return $dataSyns;
	}


	//get top 3 ranking articles for front page index
	public function getTopRankingArticles() {
		$conditions = [
			'period' => 0
		];

		$period = AppData::listPeriod[$conditions['period']];
		$month = $period['month'];
		$to = date('Y-m-d', strtotime('-1 day'));
		$from = date('Y-m-d', strtotime("-$month month", strtotime($to)));
		$conditions['from_date'] = $from;
		$conditions['to_date'] = $to;

		// $sort = $this->setTypeSortByAccessAccount($conditions['period']);

		$options = [
			'select' => [ 
				'article_id', 
				'title',
				'wb_book_seq'
			],
			'sort' => [
				'access_count_1' => 'desc',
				'issue_date' => 'desc',
				'page' => 'asc'
			],
			'limit' => 3,
			'get' => true
		];

		$list = $this->repository()->search($conditions, $options);

		return [
			'list' => $list,
			'from' => $conditions['from_date'],
			'to' => $conditions['to_date']
		];
	}
	
	//get articles for front page index, ranking
	public function getArticles($conditions) 
	{
		if(!empty($conditions['period']) || (isset($conditions['period']) && $conditions['period'] == "0")) {
			$sort = $this->setTypeSortByAccessAccount($conditions['period']);
		} else {
			$sort = [
				'issue_date' => 'desc'
			];
		}
		

		$loginUser = Auth::guard('committee')->user();
		$favouriteTopics = $loginUser->getFavouriteTopics();
		$strFavouriteTopics = !(empty($favouriteTopics))?implode(',', $favouriteTopics):0;
		$journalUserId = !(empty($loginUser->journal->journal_user_id))?$loginUser->journal->journal_user_id:0;

		$qIsRead = DB::raw("(
			CASE 
				WHEN (
		        	SELECT count(*) FROM article a 
		        	JOIN read_article ra ON a.article_id = ra.article_id 
		        	WHERE ra.journal_user_id = $journalUserId
		        	AND ra.article_id = article.article_id 
		        ) > 0 
		        then true
			ELSE 
				false
			END
		) as isRead");

		$qIsFavourite = DB::raw("(
			CASE 
				WHEN (
		        	SELECT count(*) FROM article_topics
		        	WHERE topics_id IN ($strFavouriteTopics)
		        	AND article_topics.article_id = article.article_id
		        ) > 0 THEN  true
			ELSE 
				false
			END
		) as isFavourite");

		$sOptions = [
			'select' => [ 
				'article.article_id', 
				'title', 
				'issue_date', 
				'booklet_class_id',
				'page',
				'search_target_flag',
				'not_viewable_flag',
				'wrap_up',
				'wb_book_seq',
				$qIsRead,
				$qIsFavourite,
			],
			'sort' => $sort,
			'with' => [
				[
					'relation' => 'authors',
					'options' => [
						'select' => ['author_name'],
						'query' => true,
						'sort' => [
							'author_name' => 'asc',
						]
					]
				], [
					'relation' => 'articleClasses',
					'options' => [
						'select' => ['article_class_name'],
						'query' => true
					]
				],  [
					'relation' => 'bookletClass',
					'options' => [
						'select' => [
							'booklet_class.booklet_class_id',
							'booklet_class_name'
						],
						'query' => true
					]
				]
			],
			'paginate' => $conditions['page_size']
		];

		$list = $this->repository()->search($conditions, $sOptions);

		return $list;
	}

	public function setTypeSortByAccessAccount($type)
	{
		
		$sort = [];
		if($type == '1'){ // 最新 3ヶ月
			$sort = [
				'access_count_2' => 'desc',
			];
		}else if($type == '2'){ // 過去 1年
			$sort = [
				'access_count_3' => 'desc',
			];
		}else{ //default 最新 1ヶ月 
			$sort = [
				'access_count_1' => 'desc',
			];
		}
		return $sort;
	}
	
	public function getArticlesNearest()
	{
		$conditions = [
			'article_type' => 1,
		];
		$options = [
			'select' => [ 
				'article_id', 
				'wb_book_seq',
				'issue_date'
			],
			'offset' => 1,
			'limit' => 5,
			'get' => true,
			'sort' => [
				'issue_date' => 'desc'
			],
			
		];

		$list = $this->repository()->search($conditions, $options);

		return $list;
	}
}









