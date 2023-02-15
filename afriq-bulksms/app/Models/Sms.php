<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Nova\Actions\Actionable;
use Illuminate\Notifications\Notifiable;

class Sms extends Model
{
    use HasFactory, Actionable, Notifiable;
    protected $fillable = [ 'type', 'source', 'destination', 'message', 'scheduled', 'schedule'];
    protected $casts = [
        'scheduled' => 'datetime'
    ];

    public function user() {
        return $this->belongsTo('App\Models\User');
    }
    
}
