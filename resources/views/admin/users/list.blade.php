@extends('layouts.master')

@section('title', 'Home')


@section('content')
    <div class="row">
        <div class="container">
            @include('partials.message')
        </div>
        
    </div>
    <div class="row">
        <div class="col-md-12">
            <table id="users-table" width="100%" class="table table-striped table-bordered table-responsive">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Identification</th>
                        <th>User Type</th>
                        <th>Year</th>
                        <th>Section</th>
                        <th>Bind</th>
                        <th>Created At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->identification }}</td>
                        <td>{{ $user->type->description}}</td>
                        <td>{{ $user->year ? $user->year : ''}}</td>
                        <td>{{ $user->section ? $user->section : ''}}</td>
                        <td>{!! $user->user && $user->user->email ? $user->user->email : '<span class="badge badge-success">Available</span>'!!}</td>
                        <td>{{ $user->created_at }}</td>
                        <td>
                            <form action="{{ route('user.userUpdate', $user->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @if($user->lock == 0)
                                <button class="btn btn-sm btn-primary">Lock</button>
                            @else
                                <button class="btn btn-sm btn-danger">Unlocked</button>
                            @endif
                            
                            
                            
                                
                                
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection
@section('css')
 <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

<!-- DataTables CSS for Bootstrap 4 -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Bootstrap 4 JS -->

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
        });
    });
</script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>
@endsection
