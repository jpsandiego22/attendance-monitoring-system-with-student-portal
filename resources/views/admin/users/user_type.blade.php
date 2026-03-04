@extends('layouts.master')

@section('title', 'Home')

@section('css')
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="row">
        <div class="container">
            @include('partials.message')
        </div>
        
    </div>
    <div class="row">
        <div class="col-md-4">
            <form method="POST" action="{{ route('user.create') }}">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <label>USER TYPE</label>
                        <div class="form-group">
                            <select id="user_type" name="user_type" class="form-control select2">
                                <option label="Select User Type"></option>
                                @foreach($user_types as $type)
                                    <option value="{{ $type->type }}">{{ $type->description }}</option>
                                @endforeach
                        </select>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                        <label>Description <span class="text-danger">*</span></label>
                        <input type="text" name="identification" id="identification" class="form-control" placeholder="Identification" required>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <button  class="btn btn-indigo btn-rounded btn-block">REGISTER</button>
                        </div>
                    </div>
                
                </div>
            </form>
        </div>
        <div class="col-md-8">
            <div class="table-responsive">
                <table id="users-table" width="100%" class="table table-striped table-bordered table-responsive w-100">
                    <thead class="thead-dark text-center">
                        <tr>
                            <th>ID</th>
                            <th>Type</th>
                            <th>Description</th>
                            <th>Created At</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($datas as $data)
                        <tr>
                            <td>{{ $data->id }}</td>
                            <td>{{ $data->type_label }}</td>
                            <td>{{ $data->description }}</td>
                            <td>{{ $data->created_at }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
        </div>
    </div>
@endsection


@section('js')
    <script>
    $(document).ready(function() {
        $('#users-table').DataTable({
            "paging": true,
            "searching": true,
            "ordering": true,
            "responsive": true,
            "pageLength": 10,
            autoWidth: false,
             "columnDefs": [
                { width: "10%", targets: 0,  className: "text-center" },
                { width: "20%", targets: 1,  className: "text-center" },
                { width: "50%", targets: 2,  className: "text-center" },
                { width: "35%", targets: 3,  className: "text-center" },
            ],
        });
    });
</script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>
@endsection
