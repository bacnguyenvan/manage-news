<?php

use Illuminate\Database\Seeder;

use App\Models\Article;

class ContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	
        $faker = Faker\Factory::create('ja_JP');
                $j = 0;
        $articles = Article::select('article_id', 'issue_date')->orderBy('issue_date', 'desc')->limit(15)->get();
        
     	$classes = ['HD','C1','C2','C3','A1','A2','T1','T2','T3','L1','L2','L3','L4','BL'];
        foreach($articles as $article) {
            $data = [];
            for($i=0;$i<=20;$i++) {
                // dd();
                $data[] = [
                   	'publish_year' => date('Y', strtotime($article->issue_date)),
    				'publish_month' => date('m', strtotime($article->issue_date)),
    				'publish_volume' => rand(1,999),
    				'publish_issue' => rand(1,999),
    				'order_no' => 1 + $i,
                    'issue_date' => $article->issue_date,
    				'contents_classification' => $i==0?'HD':$classes[rand(1, 13)],
    				'caption' => $faker->realText(rand(50, 200)),
    				'author_name' => $faker->name,
    				'page' => rand(1,125),
    				'article_id' => $article->article_id,
    				'created_at' => date('Y-m-d H:i:s'),
    				'updated_at' => date('Y-m-d H:i:s'),
                ];
            }
            App\Models\Content::insert($data);
        }
    }
}
