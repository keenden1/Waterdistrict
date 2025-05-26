<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application_leave extends Model
{
    use HasFactory;
    protected $table = "application_leave";
    protected $fillable = [
        'officer_department',
        'fullname',
        'email',
        'salary_grade',
        'step_grade',
        'date_filing',
        'position',
        'salary',
        'a_availed',
        'a_availed_others',
        'b_details',
        'b_details_specify',
        'c_working_days',
        'c_inclusive_dates',
        'd_commutation',
        'seven_a_certification',
        'seven_b_recommendation',
        'seven_c_approved',
        'seven_d_disapproved',
        'status',
        'reason',
    ];

}
