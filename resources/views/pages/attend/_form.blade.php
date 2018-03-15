<div class="form-group{{ $errors->has('status') ? ' has-error' : '' }}">
    {!! Form::label('status', 'Status') !!}
    {!! Form::select('status',['absent' => 'Tidak Hadir', 'permit' => 'Izin'], null, ['id' => 'status', 'class' => 'form-control', 'required' => 'required']) !!}
    <small class="text-danger">{{ $errors->first('status') }}</small>
</div>

<div class="form-group{{ $errors->has('user_id') ? ' has-error' : '' }}">
    {!! Form::label('user_id', 'Employee') !!}
    {!! Form::select('user_id', $employee, null, ['id' => 'user_id', 'class' => 'form-control', 'required' => 'required']) !!}
    <small class="text-danger">{{ $errors->first('user_id') }}</small>
</div>

<div class="form-group{{ $errors->has('created_at') ? ' has-error' : '' }}">
    {!! Form::label('created_at', 'Date') !!}
    {!! Form::text('created_at', null, ['class' => 'form-control', 'required' => 'required', 'id' => 'created_at']) !!}
    <small class="text-danger">{{ $errors->first('created_at') }}</small>
</div>


<div class="form-group text-right m-b-0">
    <a href="{{ empty($bread['0']) ? url()->previous() : $bread['0']  }}" class="btn btn-white m-l-5">
        Cancel
    </a>
    <button class="btn btn-primary waves-effect waves-light" type="submit">
        Submit
    </button>
</div>

@section('scripts')
    <script type="text/javascript">
        $('#created_at').datepicker({
            format: "yyyy-mm-dd",
            todayHighlight: true,
            autoclose: true
        });
    </script>
@endsection
