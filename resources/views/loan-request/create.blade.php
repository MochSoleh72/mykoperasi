@extends('layouts.app')

@section('content')
<div class="container">

    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card card-default">
                <div class="card-header">Pinjaman Baru</div>

                <div class="card-body">
                    {!! Form::open(['route' => 'loan-requests.store']) !!}
                        @include('loan-request._form')
                    {!! Form::close() !!} 
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
