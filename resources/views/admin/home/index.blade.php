@extends('layouts.master')
@section('title', 'Admin')
@section('css')
    <style>
        .text-sm {
            font-size: 0.875rem; /* 14px */
        }
        .card-dashboard { border-radius: 0.8rem; padding: 15px; }
        .card-dashboard .icon { font-size: 2.5rem; }
        .card-dashboard .number { font-size: 1.5rem; font-weight: bold; }
        .card-dashboard .desc { color: #6c757d; }
        .dataTables_wrapper {
            width: 100% !important;
        }
       
    </style>
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endsection

@section('content')

    <div id="app_dashBoard" class="row">
        @include('partials.message')
        <div class="col-md-3 mb-2">
            <a  @click="handleClick('1')"   class="card card-dashboard text-center border-danger">
                <div class="card-body text-danger">
                    <div class="icon mb-2"><i class="fas fa-users"></i></div>
                    <div class="number">{{ $t_users }} / <span class="text-sm text-muted">{{$t_pending}}</span></div>
                    <div class="desc font-weight-bold text-danger">TOTAL USERS</div>
                </div>
            </a>
        </div>
        <div class="col-md-3  mb-2">
            <a @click="handleClick('2')"  class="card card-dashboard text-center  border-success">
                <div class="card-body text-success">
                    <div class="icon mb-2"><i class="fas fa-link"></i></div>
                    <div class="number">{{$t_linked}}</div>
                    <div class="desc font-weight-bold text-success">LINKS ACCOUNTS</div>
                </div>
            </a>
        </div>
        <div class="col-md-3  mb-2">
            <a @click="handleClick('3')" class="card card-dashboard text-center border-primary">
                <div class="card-body text-primary">
                    <div class="icon mb-2"><i class="fab fa-google"></i></div>
                    <div class="number">{{$t_google}}</div>
                    <div class="desc font-weight-bold text-primary">GOOGLE LINK</div>
                </div>
            </a>
        </div>
        <div class="col-md-3  mb-2">
            <a @click="handleClick('4')" class="card card-dashboard text-center border-default">
                <div class="card-body text-muted">
                    <div class="icon mb-2"><i class="fas fa-chart-line"></i></div>
                    <div class="number">{{$t_locked}}</div>
                    <div class="desc font-weight-bold text-default">LOCKED ACCOUNTS</div>
                </div>
            </a>
        </div>
        @component('admin.home.userComponent')
            <h5 class="modal-title " v-html="selected"></h5>
        @endcomponent
        <div class="col-md-12"><hr></div>
        <div class="col-lg-4">
            <div class="card card-dashboard-pageviews">
                <div class="card-header">
                <h6 class="card-title">ATTENDANCE LOG</h6>
                <p class="card-text">as of today.</p>
                </div><!-- card-header -->
                <div class="card-body">
                <div class="az-list-item">
                    <div>
                    
                        <h6><a href="#" @click="handleClicklogs('1')">IN</a> </h6>
                    
                        <span>Total login today</span>
                   
                    </div>
                    <div>
                        <h6 class="tx-primary">{{$t_login}}</h6>
                        <span>{{$t_p_login}}</span>
                    
                    </div>
                </div><!-- list-group-item -->
                <div class="az-list-item">
                    <div>
                    <h6>Out</h6>
                    <span>Total logout today</span>
                    </div>
                    <div>
                        <h6 class="tx-primary">{{$t_logout}}</h6>
                    <span>28.53% (-100.00%)</span>
                    </div>
                </div><!-- list-group-item -->
                <div class="az-list-item">
                    <div>
                    <h6>New User</h6>
                    <span>New User today</span>
                    </div>
                    <div>
                    <h6 class="tx-primary">4,848</h6>
                    <span>25.35% (-100.00%)</span>
                    </div>
                </div><!-- list-group-item -->
                
                </div><!-- card-body -->
            </div><!-- card -->
        </div><!-- col -->
        <div class="col-md-8">
            @component('admin.home.userComponent')
                <h5 class="modal-title " v-html="logselected"></h5>
            @endcomponent
        </div>

        {{-- <div id="admin-chatbot" style="
    position:fixed;
    bottom:20px;
    right:20px;
    width:320px;
    background:white;
    border:1px solid #ddd;
    border-radius:10px;
    z-index:9999;
">
    <div style="background:#343a40;color:white;padding:10px;">
        System Assistant
    </div>

    <div id="chat-body" style="height:250px;overflow:auto;padding:10px;"></div>

    <div style="padding:10px;">
        <input type="text" id="chat-input" class="form-control" placeholder="Ask something...">
    </div>
</div>--}}
    </div> 
@endsection

@section('js')
   <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>
<script>

    new Vue({
        el: '#app_dashBoard',
        data: {
            vtype: '',
            users: [],
            logs: [],
        },
        methods: {
            handleClick(id) {
                this.users = [];  // clear the users array first
                this.selected = '';  // clear the users array first
                this.tUsers(id);  // then fetch or filter users
            },
            tUsers(id) {
                axios.post('{{ route('admin.getDataList') }}', { query: id })
                .then(response => {
                    this.users = [];
                    this.selected = response.data.message.selected;
                    console.log(response.data.message);
                    this.users = Array.isArray(response.data.message.data) ? response.data.message.data : [response.data.message.data];

                    // Reinitialize DataTable
                    this.$nextTick(() => {
                        if ($.fn.dataTable.isDataTable('#usersDashboard')) {
                            $('#usersDashboard').DataTable().destroy();
                           
                        }
                        $('#usersDashboard').DataTable({
                            paging: true,
                            searching: true,
                            ordering: true,
                            responsive: true,
                            pageLength: 10,
                            autoWidth: false, // important to respect your custom column widths
                        });
                    });
                })
                .catch(error => {
                    console.error(error);
                    this.message = 'An error occurred while searching.';
                });
            },
            handleClicklogs(id) {
                this.logs = [];  // clear the users array first
                this.logselected = '';  // clear the users array first
                this.tLogs(id);  // then fetch or filter users
            },
            tLogs(id) {
                axios.post('{{ route('admin.getDataLogs') }}', { query: id })
                .then(response => {
                    this.logs = [];
                    this.logselected = response.data.message.selected;
                    console.log(response.data.message);
                    this.logs = Array.isArray(response.data.message.data) ? response.data.message.data : [response.data.message.data];

                    // Reinitialize DataTable
                    this.$nextTick(() => {
                        if ($.fn.dataTable.isDataTable('#usersDashboard')) {
                            $('#usersDashboard').DataTable().destroy();
                           
                        }
                        $('#usersDashboard').DataTable({
                            paging: true,
                            searching: true,
                            ordering: true,
                            responsive: true,
                            pageLength: 10,
                            autoWidth: false, // important to respect your custom column widths
                        });
                    });
                })
                .catch(error => {
                    console.error(error);
                    this.message = 'An error occurred while searching.';
                });
            },
            
        }
    });

</script>

@endsection
