@extends('layouts.app')

@section('content')
<div class="container">

    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card card-default">
                <div class="card-header">Pembayaran Cicilan</div>

                <div class="card-body">
                    {!! Form::open(['route' => ['loans.payments.store', $loan->id]]) !!}
                        <div class="form-group">
                            {!! Form::label('Tanggal pembayarann') !!}
                            {!! Form::date('payment_date', null, ['class' => 'form-control']) !!}
                        </div>
                        {!! Form::submit('Simpan', ['class' => 'btn btn-primary']) !!}
                    {!! Form::close() !!} 
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
