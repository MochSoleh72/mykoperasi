<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\LoanRequest;

class ReviewController extends Controller
{
    public function index()
    {
        $loanRequests = LoanRequest::waitingApproval()->paginate(3);
        return view('review.index', compact('loanRequests'));
    }

    public function approve(LoanRequest $loanRequest)
    {
        $payload = [
            'is_approved' => true,
            'admin_id' => auth()->user()->id
        ];
        $loanRequest->update($payload);
        // @todo create the loan
        return redirect()->route('reviews');
    }

    public function reject(LoanRequest $loanRequest)
    {
        $payload = [
            'is_approved' => false,
            'admin_id' => auth()->user()->id
        ];
        $loanRequest->update($payload);

        return redirect()->route('reviews');
    }
}
