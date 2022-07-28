<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

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
            'name' => 'Admin',
            'email' => 'berita@bonebolangokab.go.id',
            'email_verified_at' => now(),
            'password' => Hash::make('4dm!n@beritabb'),
            'remember_token' => \Str::random(10),
        ]);
    }
}
