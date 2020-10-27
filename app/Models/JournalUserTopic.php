<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JournalUserTopic extends AppModel
{
    protected $table = 'journal_user_topics';
    protected $primaryKey = 'journal_user_topics_id';
   	protected $fillable = [
   		'journal_user_id',
   		'topics_id',
   		'updated_user_id'
   	];
}
