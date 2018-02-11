@switch ($loanRequest->status) 
    @case('Approved')
    @case('Rejected')
    @case('Waiting Approval')
        <a href="{{ route('loan-requests.show', $loanRequest->id) }}">Lihat</a>
        @break
    @default
        {!! Form::model($loanRequest, ['route' => ['loan-requests.destroy', $loanRequest->id], 'method' => 'delete', 'class' => 'form-inline'] ) !!}
            <a href="{{ route('loan-requests.edit', $loanRequest->id) }}">Ubah</a> | <a href="{{ route('loan-requests.show', $loanRequest->id) }}">Lihat</a> |
            {!! Form::submit('Batalkan', ['class'=>'btn btn-sm btn-danger']) !!}
        {!! Form::close()!!}
@endswitch
