<?php

use Illuminate\Database\Seeder;
use Faker\Factory;

class AuthorSeeder extends Seeder
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
        for($i=0;$i<=15000;$i++) {
        	$rand = rand(1,2);
            $data[] = [
               	'author_name' => $faker->name,
				'author_phonetic' => $faker->kanaName(),
				'created_at' => date('Y-m-d H:i:s'),
				'updated_at' => date('Y-m-d H:i:s'),
            ];
            $j++;
            if($j == 1000) {
            	App\Models\Author::insert($data);
            	$data = [];
            	$j = 0;
            }
        }
    }
}
