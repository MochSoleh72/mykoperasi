<?php

namespace App\Http\Controllers\Api;

use App\LoanRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\LoanRequestResource;
use App\Http\Resources\LoanRequestCollection;
use App\Http\Requests\LoanRequestStore;

class LoanRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $loanRequests = auth()->user()->loanRequests()->paginate(3);
        return LoanRequestResource::collection($loanRequests);
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

        return new LoanRequestResource($loanRequest);
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
        return new LoanRequestResource($loanRequest);
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
		$loanRequest->update($payload);
        $loanRequest = $loanRequest->fresh();

        return new LoanRequestResource($loanRequest);
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
		return response([], 204);
    }
}
