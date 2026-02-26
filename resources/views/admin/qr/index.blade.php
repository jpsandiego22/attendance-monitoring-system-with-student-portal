@extends('layouts.master')

@section('title', 'QR')


@section('content')
    <div class="row">
        <div class="container">
            @include('partials.message')
        </div>
        
    </div>
    <div class="row">
        <div class="col-md-12 table-responsive">
            <form method="GET" class="mb-2 d-flex flex-column flex-sm-row justify-content-sm-end align-items-start align-items-sm-center ml-3">
               @foreach(request()->except(['per_page','page']) as $name => $value)
                    <input type="hidden" name="{{ $name }}" value="{{ $value }}">
                @endforeach

                <div class="d-flex align-items-center mb-2 mb-sm-0">
                    <label for="per_page" class="mr-2 mb-0">Show:</label>
                    <select name="per_page" id="per_page" class="form-control" onchange="this.form.submit()">
                        <option value="10" {{ $perPage == 10 ? 'selected' : '' }}>10</option>
                        <option value="50" {{ $perPage == 50 ? 'selected' : '' }}>50</option>
                        <option value="100" {{ $perPage == 100 ? 'selected' : '' }}>100</option>
                    </select>
                </div>
            </form>
            <table id="qr-table" style="width:100%" class="table table-striped table-bordered table-responsive table-hover w-100">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Identification</th>
                        <th>User Type</th>
                        <th>QR</th>
                        <th>Bind</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($qrLists as $qrlist)
                    <tr>
                        <td>{{ $qrlist->id }}</td>
                        <td>{{ $qrlist->name }}</td>
                        <td>{{ $qrlist->identification }}</td>
                        <td>{{ $qrlist->type->description}}</td>
                        <td>
                            {!! QrCode::size(200)->generate($qrlist->qr->qr_code) !!}
                        </td>
                        <td>{!! $qrlist->user && $qrlist->user->email ? $qrlist->user->email : '<span class="badge badge-success">Available</span>'!!}</td>
                        <td>
                            <form action="{{ route('user.userUpdate', $qrlist->id) }}" method="POST" style="display:inline;">
                                @csrf
                                <button class="btn btn-sm btn-primary">View</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <!-- Laravel pagination links -->
           <div class="mb-5 d-flex flex-column flex-sm-row justify-content-sm-end align-items-start align-items-sm-center ml-3">
                {{ $qrLists->links() }}
            </div>
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
        $('#qr-table').DataTable({
            "paging": false,
            "searching": true,
            "ordering": true,
            "responsive": true,
            "autoWidth": true,
            "columnDefs": [
                { width: "20%", targets: 4,  className: "text-center" },
                { width: "10%", targets: 6,  className: "text-center" }
            ],
            "lengthMenu": [[10, 50, 100], [10, 50, 100]],
            "pageLength": 10,
        });
    });
</script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>
@endsection
