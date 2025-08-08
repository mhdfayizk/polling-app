<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Poll;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PollSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create Admin User
        User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'is_admin' => true,
        ]);
        
        // 2. Create a regular user for testing votes
        User::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => Hash::make('password'),
        ]);

        // 3. Create Sample Poll 1
        $poll1 = Poll::create(['question' => 'What is your favorite programming language?']);
        $poll1->options()->createMany([
            ['name' => 'PHP'],
            ['name' => 'JavaScript'],
            ['name' => 'Python'],
            ['name' => 'Java'],
        ]);

        // 4. Create Sample Poll 2
        $poll2 = Poll::create(['question' => 'Which frontend framework do you prefer?']);
        $poll2->options()->createMany([
            ['name' => 'Vue.js'],
            ['name' => 'React'],
            ['name' => 'Angular'],
            ['name' => 'Svelte'],
        ]);
    }
}