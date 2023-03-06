<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SmsReport extends Model
{
    use HasFactory;
    protected $table = 'sms_reports';
    protected $fillable = [
        'code',
        'sms_status',
        'sms_id',
        'sender_id'
    ];
    public function sender()
    {
        return $this->belongsTo(SenderId::class);
    }
}
