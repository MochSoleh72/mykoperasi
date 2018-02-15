<?php

namespace App\Observers;

use App\Payment;
use Illuminate\Support\Facades\DB;

class PaymentObserver
{
    /**
     * Listen to the Payment saved event.
     *
     * @param  \App\Payment  $payment
     * @return void
     */
    public function saved(Payment $payment)
    {
		// increase loan total_paid in transaction
		DB::transaction(function () use ($payment) {
			$loan = $payment->loan;
            $total_paid = $loan->total_paid + $loan->monthly_amount;
            $is_completed = $total_paid >= $loan->total_amount;
			$loan->update(compact('total_paid', 'is_completed'));
		});
    }

    /**
     * Listen to the Payment deleted event.
     *
     * @param  \App\Payment  $payment
     * @return void
     */
    public function deleted(Payment $payment)
    {
		// decrease loan total_paid in transaction
		DB::transaction(function () use ($payment) {
			$loan = $payment->loan;
            $total_paid = $loan->total_paid - $loan->monthly_amount;
            $is_completed = $total_paid >= $loan->total_amount;
			$loan->update(compact('total_paid', 'is_completed'));
		});
    }
}
