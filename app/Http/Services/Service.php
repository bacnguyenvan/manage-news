<?php 

namespace App\Http\Services;

use Validator;

class Service {

	protected $repositoryName;

	protected $modelRequest;

	public $rules;

	public $messages;

	public $columnDisplayName;

	const regKatakana = '[\x{30A0}-\x{30FF}]'; // fullwidth
	const regHiragana = '[\x{3041}-\x{3096}]'; // fullwidth

	public function repository() {
		$repositoryName = $this->repositoryName;
		$class = "App\\Http\\Repositories\\$this->repositoryName"."Repository";
		return $instanceRepository = new $class;
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

	public function checkValidate($data, $rules = null, $messages = null, $toString = false)
	{
		Validator::extend('array_has_one', function ($attribute, $value, $validator) {
		    return count(array_filter($value, function ($var) {
		    	if(!empty($var)) {
		    		return 1;
		    	}
		    }));
		});

		Validator::extend('array_has_one_with_keys', function ($attribute, $inputs, $validator) 
		{
		    return count(array_filter($inputs, function ($input) 
		    {
		    	return count(array_filter($input, function($val) 
		    	{
		    		if(!empty($val)) {
		    			return 1;
		    		}
		    	}));
		    }));
		});

		if($rules == null) {
			$rules = $this->rules;
		}
		if($messages == null) {
			$messages = $this->messages;
		}
		
		$validator = Validator::make($data, $rules, $messages);
		$validator->setAttributeNames($this->columnDisplayName);

		$result = null;
		if($validator->fails()) {
			if($toString) {
				$result = $this->errorMessages($validator->errors()->messages());
			} else {
				$result = $validator->errors()->messages();
			}
		}

		return $result;
	}
} 