<?php 
namespace App\Http\Repositories;
use Illuminate\Support\Facades\Cache;
use App\Models\AccountLock;

class CommitteeMemberRepository extends Repository{

	protected $modelName = 'CommitteeMember';

	public function search($conditions = [], $options = []) {
		$query = $this->model;

		if(!empty($conditions['delete_flag'])) {
			$query = $query->where('committee_member.delete_flag', $conditions['delete_flag']);
		} else {
			$query = $query->where('committee_member.delete_flag', 0);
		}

		if(!empty($conditions['update_data'])){
			$query = $query->where($conditions['update_data']);
		}
		
		$query = $this->searchOptions($query, $options);

		return $query;
	}

	
	public function updateFailedCount($inputs)
	{
		$isLockAccount = false;
		$member = $this->model->where([
			'committee_member_id' => $inputs['committee_member_id'],
			
		])->first();

		$errorMaxCount = AccountLock::getErrorMaxCount();
		if(empty($errorMaxCount)) $errorMaxCount = 10;
		

		if(!empty($member)){
			
			$cacheMember = Cache::get('cacheMember');
			$cacheMember = (!empty($cacheMember))?$cacheMember:[];
			

			$member_id = $member->committee_member_id;

			// count
			foreach($cacheMember as $key => $value){
				if($key == $member_id) $count = $value;
			}

			$count = (!empty($count))?$count:0;
		
			$count++;
			$cacheMember[$member_id] = $count;

			Cache::store('file')->put('cacheMember', $cacheMember, now()->addMonth(1));

			// update
			foreach($cacheMember as $key => $value){
				if($key == $member_id && $value >= $errorMaxCount ) {
					$member->update(['acount_status' => 1]);
					$isLockAccount = true;
				}
			}

		}
		
		return $isLockAccount;
	}
}