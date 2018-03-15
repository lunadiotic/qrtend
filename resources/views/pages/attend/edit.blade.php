@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Form
                </div>

                <div class="panel-body">
                    {!! Form::model($attend, ['route' => ['admin.attend.update', $attend->id], 'method' => 'PUT']) !!}
                    
                       @include('pages.attend._form')
                    
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
