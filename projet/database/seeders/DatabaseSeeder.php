<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Event;
use App\Models\Registration;
use App\Models\Guest;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        Event::factory()->count(100)->create();
        User::factory()->count(50)->create();
        Registration::factory()->count(200)->create();
        Guest::factory()->count(400)->create();
    }
}
