<?php

use Illuminate\Database\Seeder;
use Faker\Factory;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [];
        $faker = Faker\Factory::create('ja_JP');
        $j = 0;
        for($i=0;$i<=30000;$i++) {
        	$rand = rand(1,2);
            $data[] = [
               	'wb_book_seq' => rand(1, 300000),
				'title' => $faker->sentence(rand(3,5)),
                'wrap_up' => $faker->realText(rand(50, 100)),
                'letter_body' => $faker->realText(rand(50, 100)),
				'issue_date' => $faker->date($format = 'Y-m-d', $max = '2020-12-30'),
				'page' => rand(1, 100),
				'article_type' => rand(0,1),
				'search_target_flag' => rand(0,1),
				'not_viewable_flag' => rand(0,1),
				'created_at' => date('Y-m-d H:i:s'),
				'updated_at' => date('Y-m-d H:i:s'),
            ];
            $j++;
            if($j == 1000) {
            	App\Models\Article::insert($data);
            	$data = [];
            	$j = 0;
            }
        }
    }
}
