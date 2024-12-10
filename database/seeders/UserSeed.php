<?php

namespace Database\Seeders;

use App\Models\User;
use GuzzleHttp\Promise\Create;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        if(!User::where('email', 'bruno@gmail.com')->first()){
            User::create([
                'name' => 'Bruno',
                'email' => 'bruno@gmail.com',
                'password' => Hash::make('051161Tu', ['rounds' => 12]),
            ]);
        }

    }
}
