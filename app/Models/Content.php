<?php

namespace App\Models;

class Content extends AppModel {

    protected $table = 'contents';

    public $primaryKey = 'contents_id';

    protected $guarded = [];

    protected $hidden = [];

    public function article() {
    	return $this->hasOne(
    		Article::class, 
    		'article_id',
            'article_id'
        );
    }
}
