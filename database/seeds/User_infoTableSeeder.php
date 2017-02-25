<?php

use Illuminate\Database\Seeder;

class User_infoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        factory('App\Models\User',10)->create([
            'password' => bcrypt('123456')
            ]);
    }
}
