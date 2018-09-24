<?php

use Illuminate\Database\Seeder;

class ProjectNoteTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       // DoubleCheck\Entities\Project::truncate();
        factory(DoubleCheck\Entities\ProjectNote::class, 30)->create();
    }
}
