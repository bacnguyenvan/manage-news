<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Auth;
use App\Models\JournalUserTopic;

class CommitteeMember extends Authenticatable
{
    use Notifiable;

    protected $table = 'committee_member';

    protected $primaryKey = 'committee_member_id';

    public $incrementing = false;

    protected $guard = 'committee';
    
    public $fillable = [
        'committee_member_seq',
        'committee_member_id',
        'committee_member_name',
        'password',
        'contact_information',
        'acount_status',
        'acount_lock_date',
        'delete_flag',
        'updated_user_id',
        'not_viewable_flag'
    ];

    
    public function journal() {
        return $this->belongsTo(
            JournarUser::class,
            'committee_member_id',
            'member_id'
        );
    }

    public function getFavouriteTopics()
    {
        $result = [];
        $journalUserId = $this->journal()->pluck('journal_user_id');
        
        if(!empty($journalUserId)){
            $result = JournalUserTopic::whereIn('journal_user_id', $journalUserId)
                        ->pluck('topics_id')
                        ->toArray();
        }

        return $result;
    }
}
