<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SmsLog extends Model
{
    use HasFactory;
    protected $table = 'sms_logs';
    protected $fillable = [
        'code',
        'sms_status',
        'sms_id',
        'sender_id'
    ];
    public function senderId()
    {
        return $this->belongsTo(SenderId::class, 'sender_id');
    }

    public function sms()
    {
        return $this->belongsTo(Sms::class);
    }
}
