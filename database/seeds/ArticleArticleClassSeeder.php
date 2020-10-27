<?php

use Illuminate\Database\Seeder;

class ArticleArticleClassSeeder extends Seeder
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
	               	'article_class_id' => rand(1, 6),
	               	'article_id' => $i,
					'created_at' => date('Y-m-d H:i:s'),
					'updated_at' => date('Y-m-d H:i:s'),
	            ];
        	}
        	
            DB::table('article_article_class')->insert($data);
            $data = [];
        }
    }
}
