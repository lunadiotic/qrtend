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
                    {!! Form::open(['method' => 'POST', 'route' => 'admin.activity.store']) !!}
                        @include('pages.activity._form')
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script type="text/javascript">
        $('#date').datepicker({
            format: "yyyy-mm-dd",
            todayHighlight: true,
            autoclose: true
        });
    </script>
@endsection
