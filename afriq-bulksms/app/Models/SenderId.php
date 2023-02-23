<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SenderId extends Model
{
    use HasFactory;
    protected $fillable = [
        'client_id',
        'sender_id'
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
