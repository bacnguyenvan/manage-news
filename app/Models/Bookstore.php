<?php

namespace App\Models;

class Bookstore extends AppModel {

    protected $connection = 'mysql_wisebook';

    protected $table = 'w_bookstore';

    public $primaryKey = 'book_seq';

    public $fillable = [];

    protected $guarded = [];

    protected $hidden = [];
}
