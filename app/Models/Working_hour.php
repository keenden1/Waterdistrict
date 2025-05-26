<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Working_hour extends Model
{
    use HasFactory;
    protected $table = "working_hour";
    protected $fillable = [
        'minutes',
        'equivalent_day',
    ];

}
