<?php

namespace App\Models;

class ArticleTopic extends AppModel {

    protected $table = 'article_topics';

    public $primaryKey = 'article_topics_id';

    protected $guarded = [];

    protected $hidden = [];

     public $fillable = [
    	'topics_id',
    ];


}
