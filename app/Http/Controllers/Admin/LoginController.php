<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Http\Services\AdminUserService;

class LoginController extends Controller
{

    public function login(Request $request)
    {
        \Log::info(date('Y-m-d H:i:s')." run crontab AccessWisebook success");
        $errors =[];
        $inputs = [
            'admin_user_id' => $request->input('admin_user_id', null),
            'password' => $request->input('password', null),
            'delete_flag' => 0
        ];

        if(Auth::guard('admin')->check()) {
            return redirect()->route('admin-main');
        }

        if($request->isMethod('post')) 
        {
            $service = new AdminUserService();

            $errors = $service->checkValidate($inputs);

            if(empty($errors)) {
                if(Auth::guard('admin')->attempt($inputs))
                {
                    return redirect()->route('admin-main');
                }
                else
                {
                    $errors['error'] = ['ユーザーID、またはパスワードに誤りがあります。'];
                }
            }
        }

        return view('admin.pages.login')->with([
            'errors' => $errors,
            'inputs' => $inputs
        ]);
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin-login');
    }
}