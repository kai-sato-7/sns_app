<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use App\Models\Relation;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database. 5,000 users with 300 posts spanning 1 year
     */
    public function run()
    {
        for ($i = 0; $i < 100; $i++) {
            User::create([
                'username' => 'user'.$i,
                'password' => Hash::make('password'),
            ]);
        }
        Relation::create([
            'user_id' => 1,
            'friend_user_id' => 2,
        ]);
        Relation::create([
            'user_id' => 2,
            'friend_user_id' => 1,
        ]);
        Relation::create([
            'user_id' => 1,
            'friend_user_id' => 3,
        ]);
        Relation::create([
            'user_id' => 3,
            'friend_user_id' => 1,
        ]);
        Relation::create([
            'user_id' => 3,
            'friend_user_id' => 2,
        ]);
        Relation::create([
            'user_id' => 2,
            'friend_user_id' => 3,
        ]);
    }
}
