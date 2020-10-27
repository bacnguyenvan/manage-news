<?php

namespace App\Models;

use Validator;

class AccountLock extends AppModel {

    protected $table = 'account_lock';

    public $primaryKey = null;

    public $incrementing = false;

    protected $guarded = [];

    protected $hidden = [];

    //SAAJ-0200_アカウントロック回数設定画面
    //※設定用レコードは予め1レコードを登録しておくものとする。
    public function createDefaultData() {
    	return $this->create([
    		'error_max_count' => 10
    	]);
    }

    public function checkValidate($inputs) {
    	$rules = [
    		'error_max_count' => 'required|numeric|min:1|max:99'
    	];

    	$messages = [
    		'error_max_count.required' => 'ログインエラー上限回数を入力してください。',
    		'error_max_count.max' => '２桁以下で入力してください。',
    		'error_max_count.numeric' => '数値を入力してください。',
    		'error_max_count.min' => '数値を入力してください。',
    	];

    	$validator = Validator::make($inputs, $rules, $messages);
    	$errors = [];
    	if($validator->fails()) {
    		$errors = $validator->errors()->messages();
    	}
    	return $errors;
    }

    public function errorMessages($errorMessages) {
		$msg = '';
		foreach($errorMessages as $key => $messages) {
			foreach($messages as $message) {
				$msg .= $message .'<br>';
			}
		}
		return $msg;
	}

    public static function getErrorMaxCount()
    {
        return self::pluck('error_max_count')->first();
    }
}
