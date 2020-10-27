<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RelatedKeyword extends AppModel
{
    protected $table = 'related_keywords';

    protected $primaryKey = 'related_keyword_id';
    
    protected $guarded = [];

    public function topic() {
    	return $this->belongsTo(Topic::class, 'topics_id');
    }

}
