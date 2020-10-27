<?php

//CMS
Route::group([
		'prefix' => 'admin',
		'namespace' => 'Admin'
	], function() 
	{
		//SAAJ-0135_管理ユーザーログイン画面
		Route::match(['get', 'post'], '/login', 'LoginController@login')->name('admin-login');
		Route::get('/logout', 'LoginController@logout')->name('admin-logout');
		
		Route::group([
			'middleware' => 'auth.admin'
		], function() 
		{
			//SAAJ-0140_管理メニュー
			Route::match(['get'], '/main', 'AdminController@main')->name('admin-main');
			
			/*
				Article
			*/
			//SAAJ-0150_検索データ一覧
			Route::match(['get', 'post'], '/search-mgt', 'ArticleController@list')->name('admin-articles-list');
			Route::post('/search-delete', 'ArticleController@ajaxDelete')->name('admin-articles-ajax-delete');
			//SAAJ-0160_検索データ登録
			Route::match(['get', 'post'], '/search-create', 'ArticleController@create')->name('admin-articles-create');
			Route::match(['get', 'post'], '/search-edit/{pk}', 'ArticleController@edit')->name('admin-articles-edit');

			/*
				Author
			*/
			//SAAJ-0201_著者マスタ一覧
			Route::match(['get', 'post'], '/authors', 'AuthorController@list')->name('admin-authors-list');
			Route::match(['get', 'post'], '/authors-create', 'AuthorController@create')->name('admin-authors-create');
			Route::post('/authors-ajax-create', 'AuthorController@ajaxCreate')->name('admin-authors-ajax-create');
			Route::match(['get', 'post'], '/authors-edit/{pk}', 'AuthorController@edit')->name('admin-authors-edit');
			Route::post('/authors-delete', 'AuthorController@ajaxDelete')->name('admin-authors-ajax-delete');

			/*
				Topics
			*/
			//SAAJ-0190_トピックス関連ワード編集
			Route::match(['get', 'post'], '/topicsword-mgt', 'TopicController@list')->name('admin-topics-list');
			Route::post('/topicsword-delete', 'TopicController@ajaxDelete')->name('admin-topics-ajax-delete');
			Route::post('/topicsword-update', 'TopicController@update')->name('admin-topics-ajax-update');
			Route::match(['get', 'post'], '/topicswords-keywords/{pk}', 'TopicController@keywords')->name('admin-topics-keywords');
			Route::post('/topicsword-ajax-validate-keyword', 'TopicController@ajaxValidateKeyword')->name('admin-topics-ajax-validate-keyword');

			/*
				Committee Memeber
			*/
			// SAAJ-0170_委員会ユーザー一覧
			Route::match(['get'],'/committee-mgt','CommitteeMemberController@list')->name('admin-committee-member-list');
			Route::post('ajax-committee-member-delete', 'CommitteeMemberController@ajaxDelete')->name('admin-ajax-committee-member-delete');
			Route::match(['get', 'post'], '/committee_ed/{pk}', 'CommitteeMemberController@edit')->name('admin-committee-member-edit');
			Route::match(['get', 'post'], '/committee_ed', 'CommitteeMemberController@create')->name('admin-committee-member-create');

			/*
				Account Lock
			*/
			Route::match(['get', 'post'], 'account-mgt', 'AccountLockController@mgt')->name('admin-account-lock-mgt');
			//SAAJ-0200_アカウントロック回数設定画面
			/*
				SEARCH AJAX
			*/
			//authors
			Route::get('/search-authors', 'AuthorController@ajaxSearch')->name('admin-authors-ajax-search');
			//article classes
			Route::get('/search-article-classes', 'ArticleClassController@ajaxSearch')->name('admin-article-classes-ajax-search');
			//topics
			Route::get('/search-topics', 'TopicController@ajaxSearch')->name('admin-topics-ajax-search');
			//booklet classes
			Route::get('/search-booklet-classes', 'BookletClassController@ajaxSearch')->name('admin-booklet-classes-ajax-search');
			
		});
	}
);

//front
Route::group([
	'namespace' => 'Front'
], function() 
{
	
	Route::group([
		'prefix' => 'committee'
	], function() 
	{
		//SAAJ-0130_委員会ユーザーログイン画面​
		Route::match(['get', 'post'], '/login', 'LoginController@login')->name('front-committee-login');
		Route::get('/logout', 'LoginController@logout')->name('front-committee-logout');
	});

	Route::group([
		'middleware' => 'auth.committee'
	], function() 
	{
		//SAAJ-0120_電子ブック紹介ページ​
		Route::match(['get', 'post'], '/journal', 'MainController@lp')->name('front-lp');
		//
		Route::match(['get', 'post'], '/index', 'MainController@index')->name('front-index');
		
		Route::group([
			'prefix' => 'html'
		], function() 
		{
			Route::get('/ebook/{pk}', 'MainController@ebook')->name('front-ebook-view');
		});

		//SAAJ-0060_各号目次一覧​
		Route::match(['get', 'post'], '/contents', 'MainController@contents')->name('front-contents');
		// SAAJ-0070_論稿アクセスランキング
		Route::match(['get','post'],'/ranking','MainController@ranking')->name('front-ranking');

		Route::match(['get','post'],'/topics','MainController@topics')->name('front-topics');
		Route::post('/article-export','MainController@export')->name('article-export');

		Route::post('/ajax-update-status-topic', 'MainController@ajaxUpdateTopicFavourite')->name(
			'front-ajax-update-status-topic');
		// guide
		Route::get('/guide', 'MainController@guide')->name('front-guide');
	});

	
});

















