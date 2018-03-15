{!! Form::hidden('user_id', Auth::id()) !!}

<div class="form-group{{ $errors->has('log') ? ' has-error' : '' }}">
    {!! Form::label('log', 'Daily Log') !!}
    {!! Form::textarea('log', null, ['class' => 'form-control', 'required' => 'required']) !!}
    <small class="text-danger">{{ $errors->first('log') }}</small>
</div>

<div class="form-group{{ $errors->has('date') ? ' has-error' : '' }}">
    {!! Form::label('date', 'Date') !!}
    {!! Form::text('date', null, ['class' => 'form-control', 'required' => 'required', 'id' => 'date']) !!}
    <small class="text-danger">{{ $errors->first('date') }}</small>
</div>


<div class="form-group text-right m-b-0">
    <a href="{{ empty($bread['0']) ? url()->previous() : $bread['0']  }}" class="btn btn-white m-l-5">
        Cancel
    </a>
    <button class="btn btn-primary waves-effect waves-light" type="submit">
        Submit
    </button>
</div>
