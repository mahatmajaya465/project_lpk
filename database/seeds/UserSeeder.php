<?php

use App\User;
use Illuminate\Database\Seeder;
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
        User::create([
            'name' => "admin",
            'email' => "admin@gmail.com",
            'password' => Hash::make("admin"),
            'api_token' => Str::random(60),
            'roles' => "super_admin",
            'created_by' => 1
        ]);
    }
}
