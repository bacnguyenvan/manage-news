<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
//Services
use App\Http\Services\CommitteeMemberService;

use Auth;
use Hash;
use Helper;

class CommitteeMemberController extends Controller
{
    public function __construct(CommitteeMemberService $service) {
		$this->service = $service;
		$this->repository = $service->repository();
	}

	public function list()
	{
		$conditions = [];
		$options = [
			'select' => [ 
				'committee_member_id', 
				'committee_member_name', 
				'acount_status', 
				'contact_information',
				'created_at',
				'updated_at',
			],
			'sort' => [
				'committee_member_id' => 'asc',
			]
		];


		$list = $this->repository->search($conditions, $options);

		return view('admin.committee_members.list',[
			'list' => $list
		]);
	}

	
	public function create(Request $request)
	{
		
		$inputs = $this->service->getInputFromRequest($request);

        if($request->isMethod('post')) {
            $errors = $this->service->checkValidate($inputs);
           	if(!empty($errors)) {
				$errorMessage = $this->service->errorMessages($errors);
				return redirect()->back()->with([
					'errors' => $errors,
					'errorMessage' => $errorMessage
				])->withInput();
			} else {
				$password = $inputs['password'];
				//create data
				if(!empty($inputs['password'])) $inputs['password'] = Hash::make($inputs['password']);
				

				$new = $this->repository->create($inputs);

				$new->update([
					'password' => Helper::getHashPassword($password,$new->committee_member_id)
				]);
			
				if(!empty($new)) {
					return redirect()->route('admin-committee-member-list')->with('message','データを登録しました。');
				}
				
			}
        }

		return view('admin.committee_members.create',[
			'data' => $inputs
		]);
	}

	public function edit(Request $request, $pk)
	{

		if(empty($pk)) {
			// abort(404);
			return redirect()->route('admin-committee-member-create');
		}
		$options = [
			'findByPk' => $pk,
			'select' => [ 
				'committee_member_id', 
				'committee_member_name', 
				'contact_information',
				'acount_status', 	
			]
		];
		$committee_member = $this->repository->search([], $options); 

		if(empty($committee_member)) {
			abort(404);
		}
		$isEdit = true;
		$inputs = $this->service->getInputFromRequest($request,$isEdit);
		$data = $committee_member->toArray();

		if($request->isMethod('post')) {
			// ignore unique when data edit not change
			if($inputs['committee_member_id'] == $data['committee_member_id'] ){
				$this->service->removeUniqueRules();
			}
			$data = array_merge($data,$inputs);
			if(empty($data['password'])){
				$this->service->removePasswordRules();
				unset($data['password']);
			}

			$errors = $this->service->checkValidate($inputs);

			if(!empty($errors)) {
				$errorMessage = $this->service->errorMessages($errors);
				return redirect()->back()->with([
					'errors' => $errors,
					'errorMessage' => $errorMessage
				])->withInput();
			} else {
				//update data
				$committee_member_active = $this->repository->findByActiveAndPk($pk);
				if(!empty($data['password'])){
					$data['password'] = Helper::getHashPassword($data['password'],$pk); 
				} 
				
				if(!empty($committee_member_active)){
					$this->repository->updateByPk($pk, $data);
				}
				
				return redirect()->route('admin-committee-member-list')->with('message','データを更新しました。');
				
			}
			
		}

		

		return view('admin.committee_members.edit',[
			'data' => $data
		]);
	}

	public function ajaxDelete(Request $request) {
		$response = [
			'message' => '',
		];

		$status = null;
		if(Auth::guard('admin')->check()) {
			$data = $request->all();
			$column = 'acount_status';
			$result = $this->repository->softDeleteListPk($data);

			if(!empty($result)) {
				$status = 200;
				$request->session()->flash('message', __('データの削除が完了しました。'));
			} else {
				$status = 422;
			}
		} else {
			$status = 401;
		}

		return (new Response($response, $status))
				->header('Content-Type', 'application/json');
	}
}
