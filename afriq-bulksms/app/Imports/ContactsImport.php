<?php

namespace App\Imports;

use App\Models\Contact;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;

class ContactsImport implements ToModel
{
    /**
     * @param array $row
     *
     * @return User|null
     */
    public function model(array $row)
    {
        return new Contact([
            'name'     => $row[0],
            'phone_number'    => $row[1],
            'user_id'    => $row[2],
            'address_book_id'    => $row[3],
        ]);
    }
}
