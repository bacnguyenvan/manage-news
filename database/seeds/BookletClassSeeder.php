<?php

use Illuminate\Database\Seeder;

class BookletClassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $classes = [
	        'Magazine',
			'Comic',
			'News',
            'Mini',
            'Handbook'
		];
		$data = [];
        foreach($classes as $class) {
            $data[] = [
                'booklet_class_name' => $class,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];
        }
        App\Models\BookletClass::insert($data);
    }
}
