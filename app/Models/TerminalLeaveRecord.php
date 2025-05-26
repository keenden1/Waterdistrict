<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TerminalLeaveRecord extends Model
{
    use HasFactory;
    protected $table = 'terminal_leave_records';

    protected $fillable = [
        'month',
        'year',
        'monthly_salary',
        'leave_credits',
        'payable_to_date',
        'balance_previous_month',
        'payable_current_month',
    ];

}
