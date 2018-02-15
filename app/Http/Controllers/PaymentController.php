<?php

namespace App\Http\Controllers;

use App\Payment;
use App\Loan;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @param  \App\Loan  $loan
     * @return \Illuminate\Http\Response
     */
    public function create(Loan $loan)
    {
        return view('payment.create', compact('loan'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Loan  $loan
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Loan $loan)
    {
        $payload = [
            'loan_id' => $loan->id,
            'admin_id' => auth()->user()->id,
            'created_at' => $request->get('payment_date')
        ];
        Payment::create($payload);

        return redirect()->route('loans.show', $loan->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Loan  $loan
     * @param  \App\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Loan $loan, Payment $payment)
    {
        $payment->delete();

        return redirect()->route('loans.show', $loan->id);
    }
}
