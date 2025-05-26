<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Daily_earned extends Model
{
    use HasFactory;
    protected $table = "daily_earned";
    protected $fillable = [
        'days',
        'sick_earned',
        'vacation_earned',
    ];
}
