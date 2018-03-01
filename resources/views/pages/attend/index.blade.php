@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Home</div>

                <div class="panel-body">
                    <div class="row">
                        <div id="reader" class="center-block" style="width:300px;height:250px">
                        </div>
                    </div>
                    <div class="row">
                        <div id="message" class="text-center">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@section('scripts')
<script type="text/javascript" src="{{ asset('vendor/jsqrcode/jsqrcode-combined.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('vendor/jsqrcode/html5-qrcode.min.js') }}"></script>
<script type="text/javascript">
    $('#reader').html5_qrcode(function(data){
         $('#message').html('<span class="text-success send-true">Scanning now....</span>');
         if (data!='') {
                $.ajax({
                    type: "POST",
                    cache: false,
                    url : "{{ route('attend.post') }}",
                    data: {email:data},
                    success: function(data) {
                        console.log(data);
                        if (data.response == true) {
                            swal({
                                title: 'Success',
                                text: data.message,
                                type: 'success',
                                timer: 1500
                            });
                        } else {
                            swal({
                                title: 'Fail',
                                text: data.message,
                                type: 'error',
                                timer: 1500
                            });
                        }
                    }
                })
            }else{
                return confirm('There is no  data');
            }
        },
        function(error){
            $('#message').html('Scaning now ....'  );
        }, function(videoError){
            $('#message').html('<span class="text-danger camera_problem"> there was a problem with your camera </span>');
        }
    );
 </script>
@endsection