<?php 
namespace App\Http\Services;

class CommitteeMemberService extends Service{

	protected $repositoryName = 'CommitteeMember';

	public $columnDisplayName = [
		'committee_member_id' => 'ユーザーID',
		'committee_member_name' => 'ユーザー名',
		'password' => 'パスワード',
		'contact_information' => '連絡先',
	];
	
	public $rules = [
		'committee_member_id' => [
			'required',
			//unique:tableName,column_unique,NULL,pk,deleted_at,0 (default where pk; NULL => ignore pk)
			'unique:committee_member,committee_member_id,NULL,committee_member_id,delete_flag,0',
			'min:10',
			'max:10',
			'regex: /^[a-zA-Z0-9]+$/u',
		],
		'committee_member_name' => [
			'required',
			'max:100',
		],
		'password' => [
			'required',
			'min:8',
			'max:12',
			'regex: /^(([a-zA-Z0-9])|([&#%_\-!]))+$/u',
		],
		'contact_information' => [
			'max:100',
		]
    ];

    public $messages = [
    	//committee_member_id
    	'committee_member_id.required' => 'ユーザーIDを入力してください。',
    	'committee_member_id.unique' => '既に同じユーザーIDが存在しています。違うユーザーIDを入力してください。',
    	'committee_member_id.min' => 'ユーザーIDは10桁で入力してください。',
    	'committee_member_id.max' => 'ユーザーIDは10桁で入力してください。',
    	'committee_member_id.regex' => 'ユーザーIDは半角英数字で入力してください。',
    	//committee_member_name
    	'committee_member_name.required' => 'ユーザー名を入力してください。',
    	'committee_member_name.max' => 'ユーザー名は100文字以内で入力してください',
    	//password
    	'password.required' => 'パスワードを入力してください。',
    	'password.min' => 'パスワードは８桁～１２桁で入力してください。',
    	'password.max' => 'パスワードは８桁～１２桁で入力してください。',
    	'password.regex' => 'パスワードは、半角英数字および記号&#%_-!のみで入力してください。',
    	//contact_information
    	'contact_information.max' => '連絡先は100桁で入力してください',
    ];

    public function getInputFromRequest($request, $isEdit = false) {
		$inputs = [
			'committee_member_id' => $request->input('committee_member_id', ''),
            'committee_member_name' => $request->input('committee_member_name', ''),
            'password' => $request->input('password', ''),
            'contact_information' => $request->input('contact_information', ''),
            'updated_user_id' => \Auth::guard('admin')->user()->admin_user_id,
		];

		if($isEdit){
			$inputs['acount_status'] = $request->input('acount_status', 0);
			if($inputs['acount_status'] == "1") $inputs['acount_lock_date'] = date('Y-m-d H:i:s');
		}

		return $inputs;
	}
	
	public function removePasswordRules()
	{
		unset($this->rules['password']);
	}

	public function removeUniqueRules()
	{
		unset($this->rules['committee_member_id'][1]); // [1] => unique
	}

	public function validateLogin($inputs)
	{
		$rules = [
			'committee_member_id' => [
				'required',
				'regex: /^[a-zA-Z0-9]+$/u',
				'min:10',
				'max:10',
				
			],
			'password' => [
				'required',
				'min:8',
				'max:12',
				'regex: /^(([a-zA-Z0-9])|([&#%_\-!]))+$/u',
			]
		];

		return $this->checkValidate($inputs, $rules);
	}
}












