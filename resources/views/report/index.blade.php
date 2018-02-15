@extends('layouts.app')

@section('content')
<div class="container">

    <div class="col-md-12">

        <div class="card card-default">
            <div class="card-header">Laporan</div>

            <div class="card-body">
                <table class="table">
                    <tbody>
                        <tr>
                            <td>Bulan ini</td>
                            <td>Rp{{ number_format($summary['current_month']) }}</td>
                        </tr>
                        <tr>
                            <td>Bulan Lalu</td>
                            <td>Rp{{ number_format($summary['last_month']) }}</td>
                        </tr>
                        <tr>
                            <td>2 Bulan Lalu</td>
                            <td>Rp{{ number_format($summary['last_2_month']) }}</td>
                        </tr>
                    </tbody>
                </table>
                <p><a href="{{ route('reports.pdf') }}" class="btn btn-primary">Download PDF</a></p>
            </div>
    </div>
</div>
@endsection
