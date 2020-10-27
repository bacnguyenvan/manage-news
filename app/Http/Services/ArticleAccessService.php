<?php

namespace App\Http\Services;
use DB;

class ArticleAccessService extends Service{

	public $instance;

	protected $repositoryName = 'ArticleAccess';
	
	public $columnDisplayName = [
	];

	public $rules = [
    ];

    public $messages = [
    ];

    public function countAccessWisebook()
    {
    	$now = date('Y-m-d');
    	$todayBeforeOneDay = date('Y-m-d',strtotime('-1 day',strtotime($now)));

    	$period_1 = date('Y-m-d',strtotime('-1 month',strtotime($now)));
    	$period_2 = date('Y-m-d',strtotime('-3 months',strtotime($now)));
    	$period_3 = date('Y-m-d',strtotime('-1 year',strtotime($now)));

    	$access_count_1 = DB::raw("(
			SELECT SUM(access_count)
			FROM article_access as aa
			WHERE access_date BETWEEN '$period_1' and '$todayBeforeOneDay' 
			AND aa.wb_book_seq = article_access.wb_book_seq
		) as access_count_1");

		$access_count_2 = DB::raw("(
			SELECT SUM(access_count)
			FROM article_access as aa
			WHERE access_date BETWEEN '$period_2' and '$todayBeforeOneDay'
			AND aa.wb_book_seq = article_access.wb_book_seq
		) as access_count_2");

		$access_count_3 = DB::raw("(
			SELECT SUM(access_count)
			FROM article_access as aa
			WHERE access_date BETWEEN '$period_3' and '$todayBeforeOneDay'
			AND aa.wb_book_seq = article_access.wb_book_seq
		) as access_count_3");

		$options = [
			'select' => [ 
				$access_count_1,
				$access_count_2,
				$access_count_3,
				'wb_book_seq'
			],

			'get' => true
		];

		
		$list = $this->repository()->search([], $options);
		
		return $list;
    }
}





