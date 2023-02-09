<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AddressBook extends Model
{
    use HasFactory;
    public function user() {
        return $this->belongsTo('App\Models\User');
    }
    public function contact() {
        return $this->hasMany('App\Models\Contact');
    }
}
