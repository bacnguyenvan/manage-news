<?php

namespace App\Http\Services;

use AppData;

class AuthorService extends Service{

	public $instance;

	protected $repositoryName = 'Author';
	
	public $columnDisplayName = [
		'author_name' => '著者名',
		'author_phonetic' => '著者読みがな'
	];

	public $rules = [
		'author_name' => [
			'required',
			'max:100'
		],
		'author_phonetic' => [
			'required',
			'regex:/^'.self::regHiragana.'+$/u',
            'max:100'
		],
    ];

    public $messages = [
    	// 'author_name.required_with' => ':attributeを入力してください。',
    	'author_phonetic.regex' => ':attributeはひらがなのみで入力してください。',
    	'author_name.required_with' => '著者名を入力してください。',
		'author_phonetic.required_with' => '著者読みがなを入力してください。'
    ];

    public function checkConditions($inputs) {
        $rules = [
            'author_name' => 'required'
        ];
        return $this->checkValidate($inputs, $rules);
    }

    public function checkValidateCreateAuthors($inputs) {
    	//check empty author
    	$errors = $this->checkValidate($inputs, [
    		'authors' => 'array_has_one_with_keys'
    	], [
    		'authors.array_has_one_with_keys' => '著者を１件以上登録してください。'
    	]);
    	$result = [];
    	if(empty($errors)) {
    		foreach($inputs['authors'] as $index => $author) {
    			if(!empty($author['author_name']) && !empty($author['author_phonetic'])) {
    				$errors[] = $this->checkValidate($author);
    			} else {
    				$rules = [
    					'author_name' => 'required_with:author_phonetic',
						'author_phonetic' => 'required_with:author_name',
    				];
    				$errors[] = $this->checkValidate($author, $rules);
    			}
    		}
    		$errorMessages = [];
    		foreach($errors as $error) {
				if(!empty($error)) {
					foreach($error as $key => $message) {
						if(!in_array($message[0], $errorMessages)) {
							$errorMessages[] = $message[0];
						}
					}
				}
			}
			$errorMessage = '';
			if(!empty($errorMessages)) {
				$errorMessage = implode('<br>', $errorMessages);
			}
			$result = [
    			'errorMessage' => $errorMessage,
    			'errors' => $errors
    		];
    	} else {
    		$errorMessage = $this->errorMessages($errors);
    		$result = [
    			'errorMessage' => $errorMessage,
    			'errors' => $errors
    		];
    	}

    	return $result;
    }
}









