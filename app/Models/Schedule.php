<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'client_name',
        'service_name',
        'schedule_date',
        'schedule_time',
        'price',
        'description',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
