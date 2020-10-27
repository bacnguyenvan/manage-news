<?php

use Illuminate\Database\Seeder;

class ArticleTopicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [];
        $j = 0;
        for($i=0;$i<=30000;$i++) {
        	$count = rand(1,3);
        	for($m=0;$m<$count; $m++) {
        		$data[] = [
	               	'topics_id' => rand(1, 2000),
	               	'article_id' => $i,
					'created_at' => date('Y-m-d H:i:s'),
					'updated_at' => date('Y-m-d H:i:s'),
	            ];
	            $j++;
        	}
        	if($j >= 5000) {
        		DB::table('article_topics')->insert($data);
            	$data = [];
            	$j = 0;
        	}
            
        }
    }
}
