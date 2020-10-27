<?php

namespace App\Models;

class Topic extends AppModel {

    protected $table = 'topics';

    public $primaryKey = 'topics_id';

    public $fillable = [
    	'topics_name',
		'topics_phonetic',
		'display_order',
		'cutline',
		'delete_flag',
		'updated_user_id',
    ];

    protected $hidden = []; 

    public function keywords() {
    	return $this->hasMany(RelatedKeyword::class, 'topics_id');
    }


}
