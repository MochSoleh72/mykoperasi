@extends('layouts.app')

@section('content')
<div class="container">

    <div class="col-md-12">

        <div class="card card-default">
            <div class="card-header">Angsuran</div>

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
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse ($loans as $loan)
                        <tr>
                            <th scope="row">{{ $loan->id }}</th>
                            <td>{{ $loan->member->name }}</td>
                            <td>{{ $loan->duration }} bulan</td>
                            <td>{{ $loan->status }}</td>
                            <td>Rp {{ number_format( $loan->monthly_amount ) }}</td>
                            <td>Rp {{ number_format( $loan->total_paid ) }}</td>
                            <td>Rp {{ number_format( $loan->total_amount ) }}</td>
                            <td>
                                <a href="{{ route('loans.show', $loan->id) }}">Lihat Detail</a>
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
