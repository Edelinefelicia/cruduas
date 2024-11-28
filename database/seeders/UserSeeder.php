<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        User::create([
            'name'=>'edeline',
            'email' => 'edelinedharmawan2906@gmail.com',
            'password'=>'12345678',
            'level'=>'admin',
        ]);
        User::create([
            'name'=>'edeline2',
            'email' => 'edelinedharmawan29061@gmail.com',
            'password'=>'12345677',
            'level'=>'user',
        ]);
        User::create([
            'name'=>'edeline3',
            'email' => 'edelinedharmawan290623@gmail.com',
            'password'=>'12345666',
            'level'=>'internal_reviewer',
        ]);
    }
}
