<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee_Account extends Model
{
    use HasFactory;
    protected $table = "employee_account";
    protected $fillable = [
        'employee_id',
        'email',
        'fname',
        'mname',
        'lname',
        'position',
        'account_status',
        'role',
        'profile_picture',
        'e_signature',
    ];
}
