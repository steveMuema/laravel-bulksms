<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sms extends Model
{
    use HasFactory;
    protected $fillable = [ 'type', 'source', 'destination', 'message'];

    public function user() {
        return $this->belongsTo('App\Models\User');
    }
}
