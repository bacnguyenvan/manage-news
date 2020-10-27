<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
//Services
use App\Http\Services\CommitteeMemberService;
//Helpers
use Auth;
use Cookie;
use Illuminate\Support\Facades\Cache;

class LoginController extends Controller
{

    public function login(Request $request)
    {
        $errors =[];
        $inputs = [
            'committee_member_id' => $request->input('committee_member_id', null),
            'password' => $request->input('password', null),
            'delete_flag' => 0,
        ];

        if($request->isMethod('post')) 
        {
            $service = new CommitteeMemberService();

            $errors = $service->validateLogin($inputs);
            
            if(empty($errors)) {
                if(Auth::guard('committee')->attempt($inputs))
                {

                    if(Auth::guard('committee')->user()->acount_status == 1){
                        $errors['committee_member_id'] = ['入力したユーザーIDはロックされています。管理者にお問い合わせください。'];
                        $this->logout();
                    }else{

                        $cacheMember = Cache::get('cacheMember');
                        $cacheMember = (!empty($cacheMember))?$cacheMember:[];
                        foreach($cacheMember as $key => $value){
                            if($key == $inputs['committee_member_id']) {
                                
                                unset($cacheMember[$key]);
                                Cache::store('file')->put('cacheMember', $cacheMember, now()->addMonth(1));
                            }

                        }

                        return redirect()->route('front-lp');
                    }
                    
                }
                else
                {
                    $isLockAccount = $service->repository()->updateFailedCount($inputs);
                    if($isLockAccount){
                        $errors['committee_member_id'] = ['入力したユーザーIDはロックされています。管理者にお問い合わせください。'];
                    }else{
                        $errors['committee_member_id'] = ['ユーザーID、またはパスワードに誤りがあります。'];
                    }
                    
                }
            }
        }

        return view('front.pages.login')->with([
            'errors' => $errors,
            'inputs' => $inputs
        ]);
    }

    public function logout()
    {
        Auth::guard('committee')->logout();
        return redirect()->route('front-committee-login');
    }
}