@extends('layouts.app')

@section('content')
<div class="container">

    <div class="col-md-12">

        <div class="card card-default">
            <div class="card-header">Pinjaman Baru</div>

            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Jumlah</th>
                            <th>Durasi</th>
                            <th>Tanggal Pengajuan</th>
                            <th>Diajukan Oleh</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse ($loanRequests as $loanRequest)
                        <tr>
                            <th scope="row">{{ $loanRequest->id }}</th>
                            <td>Rp {{ number_format($loanRequest->amount) }}</td>
                            <td>{{ $loanRequest->duration }} bulan</td>
                            <td>{{ $loanRequest->created_at }}</td>
                            <td>{{ $loanRequest->owner->name }}</td>
                            <td>
								<div class="row">
									<div class="col-4">
										{!! Form::model($loanRequest, ['route' => ['reviews.approve', $loanRequest->id], 'method' => 'patch', 'class' => 'form-inline'] ) !!}
											{!! Form::submit('Approve', ['class'=>'btn btn-sm btn-primary']) !!}
										{!! Form::close()!!}
									</div>
									<div class="col-4">

										{!! Form::model($loanRequest, ['route' => ['reviews.reject', $loanRequest->id], 'method' => 'patch', 'class' => 'form-inline'] ) !!}
											{!! Form::submit('Reject', ['class'=>'btn btn-sm btn-danger']) !!}
										{!! Form::close()!!}
									</div>
								</div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <th scope="row" colspan=6>Belum ada data</th>
                        </tr>
                    @endforelse
                    </tbody>
                </table>

                <p>
                    {{ $loanRequests->links() }}
                </p>

            </div>
        </div>
    </div>
</div>
@endsection
