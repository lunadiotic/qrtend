@extends('layouts.app')

@section('styles')
    
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Form
                </div>

                <div class="panel-body">
                    {!! Form::open(['method' => 'POST', 'route' => 'admin.attend.store']) !!}
                        @include('pages.attend._form')
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


