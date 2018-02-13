<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    protected $fillable = [
        'member_id',
        'admin_id',
        'duration',
        'is_completed',
        'monthly_amount',
        'total_paid',
        'total_amount',
    ];
}
