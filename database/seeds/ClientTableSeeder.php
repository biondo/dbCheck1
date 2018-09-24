<?php

use Illuminate\Database\Seeder;

class ClientTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       // DoubleCheck\Entities\Client::truncate();
        factory(DoubleCheck\Entities\Client::class, 10)->create();
    }
}
