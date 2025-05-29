<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Leave extends Model
{
    use HasFactory;

    protected $table = 'leaves'; 

    protected $fillable = [
        'employee_id',
        'fname',
        'mname',
        'lname',
        'date',
        'month',
        'year',

        'vl',
        'fl',
        'sl',
        'spl',
        'other',

        'vl_earned',
        'vl_absences_withpay',
        'vl_balance',
        'vl_absences_withoutpay',

        'sl_earned',
        'sl_absences_withpay',
        'sl_balance',
        'sl_absences_withoutpay',

        'total_leave_earned',
        'day_A_T',
        'hour_A_T',
        'minutes_A_T',
        'times_A_T',

        'day_Under',
        'hour_Under',
        'minutes_Under',
        'times_Under',
        'total_conversion'
    ];
}