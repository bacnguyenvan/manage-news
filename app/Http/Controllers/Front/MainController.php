<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Response;
//Services
use App\Http\Services\ArticleService;
use App\Http\Services\ContentService;
use App\Http\Services\GSSService;
use App\Http\Services\TopicService;
use App\Http\Services\JournalUserTopicService;
//Helpers
use App\Http\Helpers\AppData;
use App\Http\Helpers\Helper;
use Auth;
//Models
use App\Models\CommitteeMember;

class MainController extends Controller
{
	public function lp()
	{

		$articleService = new ArticleService();
		$conditions = [
			'article_type' => 1,
		];
		$options = [
			'select' => [ 
				'article_id', 
				'title', 
				'wb_book_seq',
				'issue_date',
				'page',
				'search_target_flag',
				'not_viewable_flag',
			],
			'first' => true,
			'sort' => [
				'issue_date' => 'desc'
			],
			'with' => [
				[
					'relation' => 'authors',
					'options' => [
						'select' => ['author_name'],
						'query' => true
					]
				], [
					'relation' => 'contents',
					'sort' => [
						'publish_year' => 'desc',
						'publish_month' => 'desc',
						'order_no' => 'asc'
					],
					'options' => [
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
							'contents.article_id',
						],
						'query' => true
					]
				], [
					'relation' => 'bookstore',
					'options' => [
						'select' => [
							'book_seq',
							'thumbnail'
						],
						'query' => true
					]
				]
			]
		];
		
		$article = $articleService->repository()->search($conditions, $options);
		$articlesNearest = $articleService->getArticlesNearest();


		return view('front.pages.lp', [
			'article' => $article,
			'articlesNearest' => $articlesNearest
		]);
	}

	public function index(Request $request)
	{
		$articleService = new ArticleService();
		$gssService = new GSSService();
		

		$inputs = [
			'page_size' => $request->input('page_size', 50),
			'keyword' => $request->input('keyword', 'test'),
			'field' => $request->input('field', 'all'),
			'type' => $request->input('type', 0),
		];

		$gssData = $gssService->request($inputs, 'search');

		$conditions = $inputs;

		

		$list = $articleService->getArticles($conditions);

		//get top 3 ranking articles for sidebar
		$topRankingArticlesData = $articleService->getTopRankingArticles();

		return view('front.pages.index', [
			'inputs' => $inputs,
			'list' => $list->appends($inputs),
			'topRankingArticlesData' => $topRankingArticlesData,
			'gssData' => $gssData
		]);
	}

	public function contents()
	{
		$contentService = new ContentService();
		$list = $contentService->getListPublishContents();
		
		return view('front.pages.contents',['list' => $list]);
	}

	public function ranking(Request $request)
	{
		$articleService = new ArticleService();

		$inputs = [
			'period' => $request->input('period', 0),
			'page_size' => $request->input('page_size', 50)
		];

		$period = AppData::listPeriod[$inputs['period']];
		$month = $period['month'];
		$from = date('Y-m-d', strtotime("-$month month"));
		$inputs['from_date'] = $from;
		$inputs['to_date'] = date('Y-m-d');

		$conditions = $inputs;
		$list = $articleService->getArticles($conditions);
		$data = [
			'inputs' => $inputs,
			'list' => $list->appends($inputs),
		];

		return view('front.pages.ranking', $data);	
	}

	public function topics(Request $request)
	{
		$topicService = new TopicService();
		$articleService = new ArticleService();

		$listFavoriteTopics = $topicService->listTopicAndUserFavoriteTopics();

		$topicId = $request->topics_id;


		$conditions = [
			'topics_id' => $topicId,
			'page_size' => $request->input('page_size', 50),
		];

		// get result topic
		$topic = $topicService->repository()->findByPk($topicId);
		

		$listArticles = $articleService->getArticles($conditions);

		return view('front.pages.topics', [
			'listFavoriteTopics' => $listFavoriteTopics,
			'list' => $listArticles->appends($conditions),
			'inputs' => $conditions,
			'topic' => $topic
		]);
	}

	public function ebook($pk, Request $request) {
		return back();
	}

	public function export(Request $request)
	{

		$listArticleChecked = $request->input('chk',[]);
		$articleService = new ArticleService();
		// 
		$conditions = [];
		$options = [
			'findByPk' => $listArticleChecked,
			'select' => [ 
				'article_id', 
				'title', 
				'issue_date', 
				'booklet_class_id',
			],
			'with' => [
				[
					'relation' => 'authors',
					'options' => [
						'select' => ['author_name'],
						'query' => true
					]
				], [
					'relation' => 'bookletClass',
					'options' => [
						'select' => [
							'booklet_class.booklet_class_id',
							'booklet_class_name'
						],
						'query' => true
					]
				]
			]
		];
		
        $dataExport = $articleService->repository()->search($conditions, $options);
       
        $columns = array(
            __('論稿タイトル'),
            __('著者名'),
            __('発行年月日'),
            __('冊子種別'),
        );

        $columns = Helper::changeCharset($columns);
        $filename = "article_ranking_";
        $now = date('Ymd_hms');
        $getFile = Helper::setFileName($filename,$now);


        $headers = array(
            "Content-type" => "text/csv;charset=shift-jis",
            'Content-Encoding: shift-jis',
            "Content-Disposition" => "attachment; filename=".$getFile['fileName'],
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        );
        
           
        $callback = function() use ($dataExport,$columns){
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($dataExport as $items) {
                //author_name
				$authors = [];
				$authorName = '';

				if(!empty($items->authors)) {
					$authors = $items->authors;
				}

				foreach($authors as $author) {
					$authorName .= $author->author_name .'・';
				}
				// Booklet_class_name
				$bookletClass = $items->bookletClass;
				$bookletClassName = !empty($bookletClass)?$bookletClass->booklet_class_name:'';

                $rows = array(
                    $items->title, 
                    trim($authorName,'・'),
                    $items->issue_date,
                  	$bookletClassName
                );
                $rows = Helper::changeCharset($rows);
                fputcsv($file, $rows);
            }

            fclose($file);

        };

        return \Response::stream($callback,200,$headers);
	}

	public function guide()
	{
		return view('front.pages.guide');
	}

	public function ajaxUpdateTopicFavourite(Request $request)
	{
		$journalUserTopicService = new JournalUserTopicService();

		$topicId = $request->topicId;
		$status = $request->status;

		$loginUser = Auth::guard('committee')->user();
		
		$journalUserId = $loginUser->journal->journal_user_id;


		if($status){ // regiter
			$data = [
				'journal_user_id' => $journalUserId,
				'topics_id' => $topicId,
				'updated_user_id' => $loginUser->committee_member_id
			];

			$journalUserTopicService->repository()->create($data);

		}else{ // remove
			$conditions = [
				'journal_user_id' => $journalUserId,
				'topics_id' => $topicId
			];
			$journalUserTopicService->repository()->deleteByConditions($conditions);
		}

		
	}

}







