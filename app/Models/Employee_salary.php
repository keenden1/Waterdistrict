<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee_salary extends Model
{
    use HasFactory;
    protected $table = "employee_salary";
    protected $fillable = [
        'email',
        'salary',
        'month',
        'year',
    ];
   
}
