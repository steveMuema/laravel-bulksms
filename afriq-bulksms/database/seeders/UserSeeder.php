<?php

namespace Database\Seeders;

use App\Models\Contact;
use App\Models\Sms;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->count(7)
        // ->has(Sms::factory()->count(3))
        // ->has(Contact::factory()->count(3))
        ->create();
    }
}
