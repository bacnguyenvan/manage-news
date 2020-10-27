<?php

use Illuminate\Database\Seeder;

class ArticleAuthorSeeder extends Seeder
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
        for($i=1;$i<=30000;$i++) {
        	$count = rand(1,3);
            for($m=0;$m<$count; $m++) {
                $j++;
                $data[] = [
                    'author_id' => rand(1, 15000),
                    'article_id' => $i,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ];
            }
            
            if($j >= 1000) {
                DB::table('article_author')->insert($data);
                $data = [];
                $j = 0;
            }
        }
    }
}
