<?php

namespace App\Http\Services;

use AppData;
use DB;

class ContentService extends Service{

	public $instance;

	protected $repositoryName = 'Content';
	
	public $columnDisplayName = [
	];

	public $rules = [
    ];

    public $messages = [];

    public function getLatestListContent() {
    	$conditions = [
			'article_type' => 1,
		];
		$options = [
			'select' => [ 
				'contents_id',
				'publish_year',
				'publish_month',
				'publish_volume',
				'publish_issue',
				'order_no',
				'contents_classification',
				'caption',
				'author_name',
				'page',
				'article_id',
				'issue_date',
				'tinyint'
			],
			'sort' => [
				'issue_date' => 'desc'
			],
			'first' => true,
			'with' => [
				[
					'relation' => 'article',
					'options' => [
						'select' => [
							'article.article_id',
							'title'
						],
						'query' => true
					]
				]
			]
		];
		$list = $this->repository()->search($conditions, $options);

		return $list;
    }

    public function getListPublishContents()
	{
		$data = [];
		$list = DB::select("SELECT 
			publish_year,count(*) AS count FROM contents 
			GROUP BY publish_year
			ORDER BY publish_year DESC;
		");

		array_map(function($item) use(&$data){

			$data[$item->publish_year] = $item->count;

			return $data;
		},$list);


		// $interval = 0 ;
		// foreach($data as $key => $value){
		// 	if($interval == 0){
		// 		$maxYear = $key ;
		// 	}
		// 	$minYear = $key;
		// 	$interval++;
		// }

		$minYear = 1962;
		$maxYear = 2020;

		$next = true;
		$year = $minYear;
		$result = [];
		while($next){
			
			if($year % 5 == 0){
				$yMax = $year;
				$result[] = [
					'max' => $yMax,
					'min' => $minYear
				];

				$year = $minYear = $yMax + 1;

			} else {
				$year++;
				
			}

			if($year == $maxYear) {
				$result[] = [
					'max' => $year,
					'min' => $minYear
				];
				$next = false;
			}

		}
		
		return array_reverse($result);
	}
}









