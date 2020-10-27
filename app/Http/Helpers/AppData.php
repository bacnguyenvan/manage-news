<?php
namespace App\Http\Helpers;
use File;


class AppData {

	const maximumTopicsAssociateArticle = 3;

	const defaultPaginate = 15;

	const adminSidebar = array(
		[
			//
			'title' => '検索データ管理',
			'route' => 'admin-articles-list',
			'active_routes' => [
				'admin-articles-list',
				'admin-articles-create',
				'admin-articles-edit'
			],
			'icon' => '',
			'key' => 'admin-articles-list',
			'childs' => [],
		],[
			'title' => '委員会ユーザー管理',
			'route' => 'admin-committee-member-list',
			'active_routes' => [
				'admin-committee-member-list',
				'admin-committee-member-create',
				'admin-committee-member-edit',
			],
			'icon' => '',
			'key' => 'admin-committee-member-list',
			'childs' => [],
		],[
			//SAAJ-0190_トピックス関連ワード編集
			'title' => 'トピックスワード管理',
			'route' => 'admin-topics-list',
			'active_routes' => [
				'admin-topics-list',
				'admin-topics-create',
				'admin-topics-edit'
			],
			'icon' => '',
			'key' => 'admin-topics-list',
			'childs' => [],
		],[
			//Administrator information
			'title' => 'アカウントロック管理',
			'route' => 'admin-account-lock-mgt',
			'active_routes' => ['admin-account-lock-mgt'],
			'icon' => '',
			'key' => 'admin-account-lock-mgt',
			'childs' => [],
		],[
			//Administrator information
			'title' => '著者マスタ',
			'route' => 'admin-authors-list',
			'active_routes' => [
				'admin-authors-list',
				'admin-authors-edit',
				'admin-authors-create'
			],
			'icon' => '',
			'key' => 'admin-authors-list',
			'childs' => [],
		],
	);

	const frontSidebar = array(
		[
			// SAAJ-0120_電子ブック紹介ページ​
			'title' => '検索',
			'route' => 'front-index',
			'active_routes' => [
				'front-index',
			],
		],[
			'title' => '目次から探す',
			'route' => 'front-contents',
			'active_routes' => [
				'front-contents'
			],
			
		],[
			//SAAJ-0070_論稿アクセスランキング
			'title' => 'ランキングから探す',
			'route' => 'front-ranking',
			'active_routes' => [
				'front-ranking'
			],
			
		],[
			//
			'title' => 'トピックスから探す',
			'route' => 'front-topics',
			'active_routes' => [
				'front-topics'
			],
		]
	);

	const listPageSize = array(
		[
			'title' => '表示件数：50件',
			'value' => 50
		], [
			'title' => '表示件数：100件',
			'value' => 100
		], [
			'title' => '表示件数：200件',
			'value' => 200
		],
	); 

	const listPeriod = array(
		[
			'value' => 0,
			'month' => 1,
			'title' => '最新 1ヶ月'
		],
		[
			'value' => 1,
			'month' => 3,
			'title' => '最新 3ヶ月'
		],
		[
			'value' => 2,
			'month' => 12,
			'title' => '過去 1年'
		],
	);


	const indexSearchTypes = array(
		0 => '表記揺れを含まない',
		1 => '表記揺れを含む'
	);

	const indexSearchFields = array(
		'all' => '全て',
		'title' => 'タイトル',
		'author' => '著者'
	);

	const indexFacetConfigs = array(
		[
			'name' => 'トピックス',
			'key' => 'topic',
			'number_of_items' => 3,
			'collapse_key' => 'topics-collapse'
		],[
			'name' => '発行年月',
			'key' => 'facet_publish_date',
			'number_of_items' => 3,
			'collapse_key' => 'facet-publish-date-collapse'
		],[
			'name' => '論稿種別',
			'key' => 'article_type',
			'number_of_items' => 3,
			'collapse_key' => 'article-type-collapse'
		],[
			'name' => '著者',
			'key' => 'author',
			'number_of_items' => 3,
			'collapse_key' => 'author-collapse'
		]
	);

	const listArticleClassColor = array(
		// color 1
		'1' => [
			'特集',
			'座談会',
			'インタビュー',
			'経済・産業・実務シリーズ等',
			'展望',
			'視点',
			'講演録',
			'翻訳論文',
		],
		// color 2
		'2' => [
			'論文',
			'研究ノート',	
		],
		// color 3
		'3' => [
			'読書室',
			'新刊紹介',
			'大会',
			'表彰関係',
			'ご挨拶・公示'
		],
		// color 4
		'4' => [
			'投資・運用分析（アーカイブ）',
			'海外関連（アーカイブ）',
			'随想等（アーカイブ）',
			'その他'
		]
	);

	
}