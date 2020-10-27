<?php

namespace App\Http\Services;

use AppData;

class AdminUserService extends Service{

	public $instance;

	protected $repositoryName = 'AdminUser';
	
	public $columnDisplayName = [
	];

	public $rules = [
		'admin_user_id' => [
			'required',
			'regex: /^[a-zA-Z0-9]+$/u',
			'min:10',
			'max:10',
			
		],
		'password' => [
			'required',
			'min:8',
			'max:12',
			'regex: /^(([a-zA-Z0-9])|([&#%_\-!]))+$/u'
		],
    ];

    public $messages = [
    	'admin_user_id.required' => 'ユーザーIDを入力してください。',
    	'admin_user_id.min' => 'ユーザーIDは10桁で入力してください。',
    	'admin_user_id.max' => 'ユーザーIDは10桁で入力してください。',
    	'admin_user_id.regex' => 'ユーザーIDは半角英数字で入力してください。',
    	'password.required' => 'パスワードを入力してください。',
    	'password.min' => 'パスワードは８桁～１２桁で入力してください。',
    	'password.max' => 'パスワードは８桁～１２桁で入力してください。',
    	'password.regex' => 'パスワードは、半角英数字および記号&#%_-!のみで入力してください。',
    ];
}









