<?php

namespace Database\Seeders;

use App\Models\Subscriber;
use Illuminate\Database\Seeder;

class SubscriberSeeder extends Seeder
{
    public function run(): void
    {
        foreach (['rahim@example.com', 'karima@example.com', 'jamal@example.com', 'nusrat@example.com'] as $email) {
            Subscriber::firstOrCreate(compact('email'));
        }
    }
}
