<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Loan;

class Payment extends Model
{
    protected $fillable = [
        'loan_id',
        'admin_id',
    ];

    public function loan()
    {
        return $this->belongsTo(Loan::class);
    }

    public static function totalPaidForMonth($month)
    {
        return static::whereMonth('created_at', '=', $month)->get()
            ->reduce(function($totalAmount, $payment) {
                $totalAmount += $payment->loan->monthly_amount;
                return $totalAmount;
            }, 0);
    }
}
