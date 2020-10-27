<?php

namespace App\Http\Services;

use AppData;
use Illuminate\Validation\Rule;

class TopicService extends Service{

	public $instance;

	protected $repositoryName = 'Topic';
	
	public $columnDisplayName = [
		'topics_name' => 'トピックス名',
		'display_order' => '表示順',
		'cutline' => '修正後のカットライン',
		'keywords' => '関連キーワード'
	];

	public $rules = [
		'topics_name' => 'required|max:100',
		'display_order' => [
            'required',
            'numeric',
            'min:0',
            'max:999'
        ],
		'cutline' => 'required|numeric|min:0|max:999',
        'topics_phonetic' => 'required|max:100|regex:/^'.self::regHiragana.'+$/u',
    ];

    public $messages = [
    	'display_order.max' => "表示順は３桁以内で入力してください。",
    	'display_order.min' => "表示順が正しくありません。",
    	'display_order.unique' => "表示順が重複しています。",
    	'cutline.max' => "修正後のカットラインは３桁以内で入力してください。",
    	'cutline.min' => "修正後のカットラインが正しくありません。",
        'topics_phonetic.required' => '読みがなを入力してください。',
        'topics_phonetic.max' => '読みがなは100文字以内で入力してください。',
        'topics_phonetic.regex' => '読みがなは全角ひらがなで入力してください。',
    ];

    public function validateKeywords($inputs) {
    	$rules = [
            'keywords' => 'required',
            'keywords.*' => 'max:100'
        ];
        $messages = [
            'keywords.*.max' =>'関連キーワードは100文字以内で入力してください。' 
        ];
    	return $this->checkValidate($inputs, $rules , $messages);
    }

    public function updateRules($inputs) {
    	if(!empty($inputs['topics_id'])) {
    		$this->rules['display_order'][] = 
                Rule::unique('topics')->where(function ($query) use($inputs) {
                    return $query->where('display_order', $inputs['display_order'])
                    ->where('delete_flag', '0')
                    ->where('topics_id', '<>', $inputs['topics_id']);
                });
    	} else {
    		$this->rules['display_order'][] = 
                Rule::unique('topics')->where(function ($query) use($inputs) {
                    return $query->where('display_order', $inputs['display_order'])
                    ->where('delete_flag', '0');
                });
    	}
    }

    public function listTopicAndUserFavoriteTopics() {

        $loginUser = \Auth::guard('committee')->user();
        $favouriteTopics = $loginUser->getFavouriteTopics();
        $strFavouriteTopics = !(empty($favouriteTopics))?implode(',', $favouriteTopics):0;

        $conditions = [];

        $qIsFavourite = \DB::raw("(
            CASE 
                WHEN (
                    SELECT count(*) FROM article_topics
                    WHERE topics_id IN ($strFavouriteTopics)
                    AND article_topics.topics_id = topics.topics_id
                ) > 0 THEN  true
            ELSE 
                false
            END
        ) as isFavourite");

        $qCountArticles = \DB::raw("(
            SELECT count(*) from article_topics
            WHERE article_topics.topics_id = topics.topics_id
        ) as articles");

        $options = [
            'select' => [
                'topics_id',
                'topics_name',
                'display_order',
                $qIsFavourite,
                $qCountArticles
            ],
            'sort' => [
                'display_order' => 'asc'
            ],
            'get' => true
        ];

        $list = $this->repository()->search($conditions, $options);
        
        return $list;
    }
}









