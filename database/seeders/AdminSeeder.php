<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admin')->delete();
        $admin = array(
            array(
                'firstname' => 'Laravel',
                'lastname' => 'Admin',
                'email' => 'dhavalbharadva@gmail.com',
                'username' => 'admin',
                'password' => Hash::make('admin123'),
                'remember_token' => Str::random(50),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            )
        );

        DB::table('admin')->insert($admin);
    }
}
