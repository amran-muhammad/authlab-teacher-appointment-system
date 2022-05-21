<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;
    protected $fillable = [
        'day',
        'start_time',
        'end_time',
        'user_id',
        'department',
        'status',
    ];

    public function user_details()
    {
        return $this->hasOne(User::class,'id','user_id');
    }
}
