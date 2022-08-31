<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Rodanim',
            'email' => 'rodanimsantos@hotmail.com',
            'password' => Hash::make('0Vanderson0'),
        ]);

        DB::table('users')->insert([
            'name' => 'Wesley',
            'email' => 'Wesley@lencione.com.br',
            'password' => Hash::make('Lencione11'),
        ]);
    }
}
