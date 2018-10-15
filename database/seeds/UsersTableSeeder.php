<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Users;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Users::create([
            'name' => 'Neo',
            'email' => 'neo@matrix.com',
            'password' => bcrypt('theone'),
            'api_token' => md5('neo@matrix.com')
        ]);

        Users::create([
            'name' => 'Morpheus',
            'email' => 'morpheus@matrix.com',
            'password' => bcrypt('theone'),
            'api_token' => md5('morpheus@matrix.com')
        ]);

        Users::create([
            'name' => 'Trinity',
            'email' => 'trinity@matrix.com',
            'password' => bcrypt('theone'),
            'api_token' => md5('trinity@matrix.com')
        ]);

        Users::create([
            'name' => 'Oracle',
            'email' => 'oracle@matrix.com',
            'password' => bcrypt('theone'),
            'api_token' => md5('oracle@matrix.com')
        ]);

        Users::create([
            'name' => 'Smith',
            'email' => 'smith@matrix.com',
            'password' => bcrypt('theone'),
            'api_token' => md5('smith@matrix.com')
        ]);
    }
}
