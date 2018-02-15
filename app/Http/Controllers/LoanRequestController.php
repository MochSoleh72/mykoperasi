<?php

namespace App\Http\Controllers;

use App\LoanRequest;
use Illuminate\Http\Request;
use App\Http\Requests\LoanRequestStore;

class LoanRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $status = $request->get('status', 'all');
        $loanRequests = auth()->user()->loanRequests();
        switch ($status) {
            case 'approved':
                $loanRequests = $loanRequests->approved()->paginate(3);
                break;
            case 'rejected':
                $loanRequests = $loanRequests->rejected()->paginate(3);
                break;
            case 'waiting':
                $loanRequests = $loanRequests->waiting()->paginate(3);
                break;
            case 'draft':
                $loanRequests = $loanRequests->draft()->paginate(3);
                break;
            case 'all':
            default:
                $loanRequests = $loanRequests->paginate(3);
                break;
        }
        $param = compact('loanRequests');
        if ($status !== 'all') {
            $param = compact('loanRequests', 'status');
        }
        return view('loan-request.index', $param);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', LoanRequest::class);
        return view('loan-request.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LoanRequestStore $request)
    {
        $this->authorize('create', LoanRequest::class);
        $payload = $request->only('amount', 'duration', 'is_submitted') + ['member_id' => auth()->user()->id];
		$loanRequest = LoanRequest::create($payload);

		return redirect()->route('loan-requests.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\LoanRequest  $loanRequest
     * @return \Illuminate\Http\Response
     */
    public function show(LoanRequest $loanRequest)
    {
        $this->authorize('view', $loanRequest);
        return view('loan-request.show', compact('loanRequest'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\LoanRequest  $loanRequest
     * @return \Illuminate\Http\Response
     */
    public function edit(LoanRequest $loanRequest)
    {
        $this->authorize('update', $loanRequest);
        return view('loan-request.edit', compact('loanRequest'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\LoanRequest  $loanRequest
     * @return \Illuminate\Http\Response
     */
    public function update(LoanRequestStore $request, LoanRequest $loanRequest)
    {
        $this->authorize('update', $loanRequest);
        $payload = $request->only('amount', 'duration', 'is_submitted') + ['member_id' => auth()->user()->id];
		$loanRequest = $loanRequest->update($payload);

		return redirect()->route('loan-requests.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\LoanRequest  $loanRequest
     * @return \Illuminate\Http\Response
     */
    public function destroy(LoanRequest $loanRequest)
    {
        $this->authorize('delete', $loanRequest);
		$loanRequest->delete();
		return redirect()->route('loan-requests.index');
    }
}
