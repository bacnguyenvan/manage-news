<?php

use Illuminate\Database\Seeder;

class ArticleClassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $classes = [
	        'society',
			'environment',
			'cuisine',
			'novel',
			'knowledge',
			'music'
		];
		$data = [];
        foreach($classes as $class) {
            $data[] = [
                'article_class_name' => $class,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];
        }
        App\Models\ArticleClass::insert($data);
    }
}
