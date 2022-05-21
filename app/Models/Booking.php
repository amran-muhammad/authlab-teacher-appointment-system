<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;
    public function teacher()
    {
        return $this->hasOne(User::class,'id','user_id');
    }
    public function student()
    {
        return $this->hasOne(User::class,'student_id','student_id');
    }
    
    public function schedule()
    {
        return $this->hasOne(Schedule::class,'id','schedule_id');
    }
}
