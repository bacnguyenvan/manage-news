<?php

use Illuminate\Database\Seeder;
use Faker\Factory;

class TopicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		$data = [];
        $factory = new Factory();
        $faker = $factory->create();

        $j = 0;
        for($i=0;$i<=2000;$i++) {
            $name = $faker->word();
            $data[] = [
                'topics_name' => $name,
                'topics_phonetic' => $name,
                'display_order' => rand(1,100),
				'created_at' => date('Y-m-d H:i:s'),
				'updated_at' => date('Y-m-d H:i:s'),
            ];
            $j++;
            if($j == 1000) {
                App\Models\Topic::insert($data);
                $data = [];
                $j = 0;
            }
        }
    }
}
