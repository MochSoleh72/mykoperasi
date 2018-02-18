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
        $perPage = $request->get('perPage', 3);
        if ($perPage > 20) {
            $perPage = 20;
        }
        $status = $request->get('status', 'all');
        /* $loanRequests = auth()->user()->loanRequests(); */

        // tampilkan semua, untuk contoh filter by peminjam
        $ownerName = request()->get('ownerName');
        $loanRequests = LoanRequest::whereHas('owner', function ($query) use ($ownerName) {
            $query->where('name', 'like', "%$ownerName%");
        });
        switch ($status) {
            case 'approved':
                $loanRequests = $loanRequests->approved()->paginate($perPage);
                break;
            case 'rejected':
                $loanRequests = $loanRequests->rejected()->paginate($perPage);
                break;
            case 'waiting':
                $loanRequests = $loanRequests->waiting()->paginate($perPage);
                break;
            case 'draft':
                $loanRequests = $loanRequests->draft()->paginate($perPage);
                break;
            case 'all':
            default:
                $loanRequests = $loanRequests->paginate($perPage);
                break;
        }
        $param = compact('loanRequests', 'perPage', 'ownerName');
        if ($status !== 'all') {
            $param = compact('loanRequests', 'status', 'perPage', 'ownerName');
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
