<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'phone_number',
        'user_id',
        'address_book_id'
    ];
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
    public function addressBook()
    {
        return $this->belongsTo('App\Models\AddressBook');
    }
}
