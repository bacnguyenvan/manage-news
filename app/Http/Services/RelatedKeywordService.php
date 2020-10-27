<?php

namespace App\Http\Services;

use AppData;

class RelatedKeywordService extends Service{

	public $instance;

	protected $repositoryName = 'RelatedKeyword';
	
	public $columnDisplayName = [
		'related_keywords_name' => '関連キーワード'
	];

	public $rules = [
		'related_keywords_name' => 'required'
    ];

    public $messages = [
    	'related_keywords_name.required' => '関連キーワードが入力されていません。'
    ];
}









