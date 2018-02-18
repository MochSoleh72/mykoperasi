@extends('layouts.app')

@section('content')
<div class="container">

    <div class="col-md-12">

        <div class="card card-default">
            <div class="card-header">Pinjaman</div>

            <div class="card-body">
                <p> 
                <a href="{{ route('loan-requests.create') }}" class="btn btn-primary">Pinjaman baru</a>
                </p>

                <p> 
                {!! Form::open(['route' => ['loan-requests.index'], 'method' => 'get', 'class' => 'form-inline'] ) !!}
                    <div class="form-group">
                        {!! Form::label('Status: ') !!}
                        {!! Form::select('status', [
                            'all' => 'All', 
                            'approved' => 'Approved', 
                            'rejected' => 'Rejected', 
                            'waiting' => 'Waiting Approval', 
                            'draft' => 'Draft'], request()->get('status', 'all') , ['class' => 'form-control']) !!}
                        {!! Form::label('Per Halaman: ') !!}
                        <select name="perPage" class="form-control">
                            <option value="3" {{$perPage == 3 ? 'selected="selected"' : null}}>3</option>
                            <option value="10" {{$perPage == 10 ? 'selected="selected"' : null}}>10</option>
                            <option value="20" {{$perPage == 20 || $perPage > 20 ? 'selected="selected"' : null}}>20</option>
                        </select>


                      </div>
                    {!! Form::submit('Filter', ['class'=>'btn btn-sm btn-primary']) !!}
                {!! Form::close()!!}
                </p>

                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Jumlah</th>
                            <th>Durasi</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse ($loanRequests as $loanRequest)
                        <tr>
                            <th scope="row">{{ $loanRequest->id }}</th>
                            <td>Rp {{ number_format($loanRequest->amount) }}</td>
                            <td>{{ $loanRequest->duration }} bulan</td>
                            <td>{{ $loanRequest->status }}</td>
                            <td>
                                @include('loan-request._status', ['loanRequest' => $loanRequest])
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <th scope="row" colspan=2>Belum ada data</th>
                        </tr>
                    @endforelse
                    </tbody>
                </table>

                <p>
                    {{ $loanRequests->appends(isset($status) ? compact('status', 'perPage') : compact('perPage'))->links() }}
                </p>

            </div>
        </div>
    </div>
</div>
@endsection
