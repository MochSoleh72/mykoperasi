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

    public function getStatusAttribute()
    {
        if ($this->is_completed) {
            return 'Complete';
        }

        return 'Ongoing';
    }

    public function member()
    {
        return $this->belongsTo(User::class, 'member_id');
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, 'loan_id');
    }
}
