<?php

use Illuminate\Database\Seeder;

class ProjectTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //DoubleCheck\Entities\Project::truncate();
        factory(DoubleCheck\Entities\Project::class, 10)->create();
    }
}
