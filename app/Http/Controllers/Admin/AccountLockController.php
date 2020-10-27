<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
//Models
use App\Models\AccountLock;
use Auth;

class AccountLockController extends Controller
{
	public function mgt(Request $request)
	{
		$inputs = [
			'error_max_count' => $request->input('error_max_count', null)
		];
		$model = new AccountLock();
		$data = $model->first();
		if(empty($data)) {
			$data = $model->createDefaultData();
		}

		if($request->isMethod('post')) {
			$errors = $model->checkValidate($inputs);
			if(!empty($errors)) {
				$errorMessage = $model->errorMessages($errors);
				return back()->with([
					'errors' => $errors,
					'errorMessage' => $errorMessage
				])->withInput();
			} else {
				$data->update([
					'error_max_count' => $inputs['error_max_count'],
					'updated_user_id' => Auth::guard('admin')->user()->admin_user_id,

				]);
				$message = 'アカウントロック回数を設定しました。';
				return redirect()->route('admin-account-lock-mgt')->with([
					'message' => $message
				]);
			}
		}

		return view('admin.pages.account-lock-mgt', [
			'data' => $data
		]);
	}
}