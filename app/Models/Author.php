<?php

namespace App\Models;

class Author extends AppModel {

    protected $table = 'author';

    public $primaryKey = 'author_id';

    protected $guarded = [];

    protected $hidden = [];
}
