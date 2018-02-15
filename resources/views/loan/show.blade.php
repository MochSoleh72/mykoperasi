@extends('layouts.app')

@section('content')
<div class="container">

    <div class="col-md-12">

        <div class="card card-default">
            <div class="card-header">Detail Pinjaman</div>

            <div class="card-body">

                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Member</th>
                            <th>Duration</th>
                            <th>Status</th>
                            <th>Angsuran/bulan</th>
                            <th>Total Kembali</th>
                            <th>Total Pinjaman</th>
                            <th>Disetujui Oleh</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th scope="row">{{ $loan->id }}</th>
                            <td>{{ $loan->member->name }}</td>
                            <td>{{ $loan->duration }} bulan</td>
                            <td>{{ $loan->status }}</td>
                            <td>Rp {{ number_format( $loan->monthly_amount ) }}</td>
                            <td>Rp {{ number_format( $loan->total_paid ) }}</td>
                            <td>Rp {{ number_format( $loan->total_amount ) }}</td>
                            <td>{{ $loan->admin->name }}</td>
                        </tr>
                    </tbody>
                </table>


            </div>
            <div class="card-header">Pembayaran</div>

            <div class="card-body">
                @if ($loan->status == 'Ongoing')
                <p>
                    <a href="{{ route('loans.payments.create', [$loan->id]) }}" class="btn btn-primary">Pembayaran Baru</a>
                </p>
                @endif

                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Tanggal</th>
                            <th>Bayar ke</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse ($loan->payments as $payment)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $payment->created_at }}</td>
                            <td>{{ $payment->admin->name }}</td>
                            <td>
                                {!! Form::model($payment, ['route' => ['loans.payments.destroy', $loan->id, $payment->id], 'method' => 'delete', 'class' => 'form-inline'] ) !!}
                                    {!! Form::submit('Hapus', ['class'=>'btn btn-sm btn-danger']) !!}
                                {!! Form::close()!!}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <th scope="row" colspan=6>Belum ada data</th>
                        </tr>
                    @endforelse
                    </tbody>
                </table>


            </div>
        </div>

    </div>
</div>
@endsection
