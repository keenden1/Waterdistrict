<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee_attendance extends Model
{
    use HasFactory;
    protected $table = "employee_attendance";
    protected $fillable = [
        'email',
        'month',
        'year',
        'lateness_day',
        'lateness_hour',
        'lateness_minutes',
        'lateness_times',
        'account_status',
        'undertime_day',
        'undertime_hour',
        'undertime_minutes',
        'undertime_times',
    ];

}
