<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TerminalLeaveRecord extends Model
{
    use HasFactory;
    protected $table = 'terminal_leave_records';

   protected $fillable = [
    'employee_id',
    'month',
    'year',
    'vl',
    'sl',
    'total',
    'constant_factor',
    'grand_total',
    'salary',
];

}
