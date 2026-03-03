@extends('layouts.master')

@section('title', 'Home')

@section('css')
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="row">
        <div class="container">
            <div class="alert alert-info alert-dismissible fade show" role="alert">
                <i><b>TEMPLATE USER TYPE</b> : [ 1 = Faculty ] - [ 2 = Student ]</i>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span>&times;</span>
                </button>
            </div>
        </div>
    </div>
    <div  id="app_import" class="row mb-5">
        <div v-if="message" class="container" v-cloak>
            <div class="alert alert-danger alert-dismissible" role="alert">
                <div v-html="message"></div>
                <button type="button" @click="message = ''" class="close" aria-label="Close">
                    <span>&times;</span>
                </button>
            </div>
        </div>
        <div class="col-md-12 mb-5">
            <input class="btn btn-outline-success" type="file" @change="handleFileUpload" accept=".csv,text/csv" ref="csvFileInput"> <button class="btn btn-danger" @click="resetUpload">Reset</button>
            <div class="float-right">
                <button @click="submitFile" class="btn btn-primary">Import</button>
            </div>
        </div>
        <div class="col-md-12">
            <div class="table-responsive"  v-cloak>
                <table id="importList" class="table table-striped table-bordered w-100" v-if="tableData.length">
                    <thead class="thead-dark">
                        <tr>
                            <th v-for="(header, index) in headers" :key="index">
                                @{{ header }}
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(row, rowIndex) in tableData" :key="rowIndex">
                            <td v-for="(cell, cellIndex) in row" :key="cellIndex">
                                @{{ cell }}
                            </td>
                        </tr>
                    </tbody>
                    
                </table>
                <table id="importListFallback" class="table table-striped table-bordered w-100" v-else>
                    <thead class="thead-dark">
                        <tr>
                            <th>Identification</th>
                            <th>Name</th>
                            <th>Year</th>
                            <th>Section</th>
                            <th>User Type</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="5" class="text-center">No data available</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection


@section('js')
    <script>
    $(document).ready(function() {
        $('#importList').DataTable({
            "paging": true,
            "searching": true,
            "ordering": true,
            "responsive": true,
            "pageLength": 10,
            autoWidth: true,
             
        });
    });
    new Vue({
        el: '#app_import',
        data: {
            headers: [],
            tableData: [],
            message:'',
            file: null
        },
        methods: {
            handleFileUpload(event) {
                const file = event.target.files[0];
                if (!file) return;
                // Validate file type again
                if (!file.name.endsWith('.csv') && file.type !== 'text/csv') {
                    this.message='Invalid file! Only CSV files are allowed.';
                    this.resetUpload();
                    event.target.value = ''; // reset input
                    return;
                }
                 this.file = file;
                 console.log(this.file);
                const reader = new FileReader();

                reader.onload = (e) => {
                    const csv = e.target.result;
                    const lines = csv.split('\n').map(line => line.trim()).filter(line => line);

                    // Extract headers from CSV
                    const fileHeaders = lines[0].split(',').map(h => h.trim().toLowerCase());

                    // Define allowed headers
                    const allowedHeaders = ['identification', 'name', 'contact', 'year', 'section', 'user_type'];

                    // Check for missing headers
                    const missing = allowedHeaders.filter(h => !fileHeaders.includes(h));

                    // Check for extra/unexpected headers
                    const extra = fileHeaders.filter(h => !allowedHeaders.includes(h));

                    if (missing.length > 0) {
                        this.message='Invalid CSV! Missing headers: ' + missing.join(', ');
                        this.resetUpload();
                        return;
                    }

                    if (extra.length > 0) {
                        this.message='Invalid CSV! Extra unexpected headers: ' + extra.join(', ');
                        this.resetUpload();
                        return;
                    }

                    // Valid headers, proceed
                    this.headers = fileHeaders;

                    // Extract rows
                    this.tableData = lines.slice(1).filter(line => line)
                        .map(line => line.split(','));
                    
                    this.$nextTick(() => {

                        // Destroy existing table if already initialized
                        if ($.fn.DataTable.isDataTable('#importList')) {
                            $('#importList').DataTable().destroy();
                        }

                        $('#importList').DataTable({
                            paging: true,
                            searching: true,
                            ordering: true,
                            responsive: true,
                            pageLength: 10,
                            autoWidth: true,
                        });

                    });
                };
                reader.readAsText(file);
            },
            resetUpload() {
                
                this.headers = [];
                this.tableData = [];
                this.fileUploaded = false;
                // Reset the file input via Vue ref
                this.$refs.csvFileInput.value = null;

                // Enable the file input again
                this.$refs.csvFileInput.disabled = false;

                if ($.fn.DataTable.isDataTable('#importList')) {
                    $('#importList').DataTable().destroy();
                }
            },
            submitFile() {
                
                if (!this.file) {
                    this.message='Please select a CSV file first.';
                    this.resetUpload();
                    return;
                }
                let formData = new FormData();
                formData.append('file', this.file);

                axios.post('{{route('admin.userImportNow')}}', formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                })
                .then(response => {
                    this.message =response.data;
                    this.resetUpload();
                })
                .catch(error => {
                    console.log(error.response.data);
                    this.resetUpload();
                });
            }
        }
    });
</script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>
@endsection
