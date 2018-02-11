<div class="form-group">
    {!! Form::label('Jumlah pinjaman') !!}
    {!! Form::number('amount', null, ['class' => 'form-control']) !!}
</div>
<div class="form-group">
    {!! Form::label('Lama pinjaman (bln)') !!}
    {!! Form::number('duration', null, ['class' => 'form-control']) !!}
</div>
<div class="form-check">
    {!! Form::checkbox('is_submitted', 1, null, ['class' => 'form-check-input']) !!}
    {!! Form::label('Ajukan sekarang.') !!}
</div>
{!! Form::submit('Simpan', ['class' => 'btn btn-primary']) !!}
