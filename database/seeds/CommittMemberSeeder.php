<?php

use Illuminate\Database\Seeder;

class CommittMemberSeeder extends Seeder
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

        for($i=0;$i<=50;$i++) {
        	
            $data = [
				'committee_member_id' => rand(1, 300),
				'committee_member_name' => $faker->kanaName(),
				'password' => bcrypt("admin@".$i),
				'contact_information' => $faker->kanaName()."@gmail.com",
				'created_at' => date('Y-m-d H:i:s'),
				'updated_at' => date('Y-m-d H:i:s'),
            ];

           DB::table('committee_member')->insert($data);
        }
    }
}
