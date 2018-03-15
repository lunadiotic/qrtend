@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('vendor/datatables/DataTables-1.10.16/css/dataTables.bootstrap.min.css') }}">
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Absent Permission
                    <a href="{{ route('admin.attend.create') }}" class="btn btn-primary pull-right" style="margin-top: -8px;">Create+</a>
                </div>

                <div class="panel-body">
                    <table id="datatable" class="table table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>User</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>ID</th>
                                <th>User</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th></th>
                            </tr>
                        </tfoot>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@section('scripts')
    <script src="{{ asset('vendor/datatables/DataTables-1.10.16/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables/DataTables-1.10.16/js/dataTables.bootstrap.min.js') }}"></script>
    <script type="text/javascript">
        var table = $('#datatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('table.attend') }}",
            columns: [
                {data: 'id', name: 'id'},
                {data: 'user', name: 'user'},
                {data: 'status', name: 'status'},
                {data: 'created_at', name: 'created_at'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });
    </script>
@endsection
