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
    </style>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-3 mb-2">
            <div class="card card-dashboard text-center border-danger">
                <div class="card-body text-danger">
                    <div class="icon mb-2"><i class="fas fa-users"></i></div>
                    <div class="number">{{ $t_users }} / <span class="text-sm text-muted">{{$t_pending}} PENDING</span></div>
                    <div class="desc font-weight-bold text-danger">TOTAL USERS</div>
                </div>
            </div>
        </div>
        <div class="col-md-3  mb-2">
            <div class="card card-dashboard text-center  border-success">
                <div class="card-body text-success">
                    <div class="icon mb-2"><i class="fas fa-link"></i></div>
                    <div class="number">{{$t_linked}}</div>
                    <div class="desc font-weight-bold text-success">LINKS ACCOUNTS</div>
                </div>
            </div>
        </div>
        <div class="col-md-3  mb-2">
            <div class="card card-dashboard text-center border-primary">
                <div class="card-body text-primary">
                    <div class="icon mb-2"><i class="fab fa-google"></i></div>
                    <div class="number">{{$t_google}}</div>
                    <div class="desc font-weight-bold text-primary">GOOGLE LINK</div>
                </div>
            </div>
        </div>
        <div class="col-md-3  mb-2">
            <div class="card card-dashboard text-center border-default">
                <div class="card-body text-default">
                    <div class="icon mb-2"><i class="fas fa-chart-line"></i></div>
                    <div class="number">{{$t_locked}}</div>
                    <div class="desc font-weight-bold text-default">LOCKED ACCOUNTS</div>
                </div>
            </div>
        </div>
    </div>
    <div class="row"><div class="col-md-12"><hr></div></div>
    <div class="row">
        <div class="col-lg-4">
                <div class="card card-dashboard-pageviews">
                    <div class="card-header">
                    <h6 class="card-title">ATTENDANCE LOG</h6>
                    <p class="card-text">as of today.</p>
                    </div><!-- card-header -->
                    <div class="card-body">
                    <div class="az-list-item">
                        <div>
                        <h6>IN</h6>
                        <span>/demo/admin/index.html</span>
                        </div>
                        <div>
                        <h6 class="tx-primary">7,755</h6>
                        <span>31.74% (-100.00%)</span>
                        </div>
                    </div><!-- list-group-item -->
                    <div class="az-list-item">
                        <div>
                        <h6>Out</h6>
                        <span>/demo/admin/forms.html</span>
                        </div>
                        <div>
                        <h6 class="tx-primary">5,215</h6>
                        <span>28.53% (-100.00%)</span>
                        </div>
                    </div><!-- list-group-item -->
                    <div class="az-list-item">
                        <div>
                        <h6>New User</h6>
                        <span>/demo/admin/util.html</span>
                        </div>
                        <div>
                        <h6 class="tx-primary">4,848</h6>
                        <span>25.35% (-100.00%)</span>
                        </div>
                    </div><!-- list-group-item -->
                    
                    </div><!-- card-body -->
                </div><!-- card -->

                </div><!-- col -->
   
    </div>

@include('admin.home.metrics')

@endsection

@section('js')
<script>
      $(function(){
        'use strict'

      })
    </script>
@endsection
