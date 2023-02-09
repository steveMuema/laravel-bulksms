<?php

namespace Database\Seeders;

use App\Models\AddressBook;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AddressBookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AddressBook::factory()
        ->count(2)
        ->forUser()
        ->hasContacts(3)
        ->create();
    }
}
