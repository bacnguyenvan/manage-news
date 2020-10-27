<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArticleAccess extends Model
{
    protected $table = 'article_access';

    public $primaryKey = 'article_access_id';

    public $fillable = [
    	'article_access_id',
        'wb_book_seq',
        'access_date',
        'access_count',
    ];
}
