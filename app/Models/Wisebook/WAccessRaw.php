<?php

namespace App\Models\Wisebook;

use Illuminate\Database\Eloquent\Model;

class WAccessRaw extends Model
{
    protected $connection = 'mysql_wisebook';
    protected $table = 'w_access_raw';

    public function getList()
    {
    	$now = Date('Y-m-d');


    	$query = self::select('ip','book_seq',\DB::raw('count(book_seq) as totalAccess'))
    				-> whereDate('date', date('Y-m-d',strtotime('-1 day',strtotime($now))))
    				-> where('member_id','ebook')
    				-> where('action','event')
    				-> where('params','like',"%Book*Open%")
    				-> groupBy('ip','book_seq')
    				-> get();


    	return $query;


    }
}
