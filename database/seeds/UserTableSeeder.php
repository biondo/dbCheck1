<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(DoubleCheck\Entities\User::class)->create(['name' => 'System Administrator', 'email' => 'adm@adm.com']);
        factory(DoubleCheck\Entities\User::class, 10)->create();
    }
}
