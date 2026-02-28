<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Google Analytics -->


    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Responsive Bootstrap 4 Dashboard Template">
    <meta name="author" content="BootstrapDash">
<!-- CSRF token for Axios -->
<meta name="csrf-token" content="{{ csrf_token() }}">
    <title>AMS | Login</title>

    <!-- Vendor CSS -->
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"> --}}
    <link href="{{ asset('lib/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('lib/ionicons/css/ionicons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('lib/typicons.font/typicons.css') }}" rel="stylesheet">

    <!-- Azia CSS -->
    <link rel="stylesheet" href="{{ asset('css/master.css') }}">
    <link rel="stylesheet" href="{{ asset('css/azia.css') }}">
    <style>
        [v-cloak] {
            display: none;
        }
    </style>
</head>


<body class="az-body">

    <div id="appAll" class="container mt-5" v-cloak>
        <div class="row">
            <div class="col-md-12 text-center">
                <h1>ATTENDANCE MONITORING SYSTEM</h1>
            </div>
        </div>
        <div class="row">
           <div class="col-md-6 justify-content-center border pl-0 pr-0">
                <div id="appTime" :class="[theme]" class="clock-container">
                    <button class="btn-button mb-2" @click="toggleTheme">
                        <i :class="theme === 'dark' ? 'fas fa-sun' : 'fas fa-moon'"></i>
                    </button>
                    <div class="clock">
                        @{{ formattedTime }}
                    </div>
                </div>
                <div class="container mt-4" v-if="name">
                    <div class="card shadow border-0 text-center p-4">

                        <!-- Profile Image -->
                        <div class="mb-3">
                            <img 
                                :src="img ? '/'+img : '/img/faces/face0.jpg'"
                                class="rounded-circle border shadow-sm"
                                width="200"
                                height="200"
                                style="object-fit: cover;"
                            >
                        </div>

                        <!-- Name -->
                        <h4 class="font-weight-bold mb-1 text-dark">
                            @{{ name }}
                        </h4>

                        <!-- Log Type Badge -->
                        <div class="mb-2">
                            <span 
                                class="badge px-3 py-2"
                                :class="type === 'IN' ? 'badge-success' : 'badge-danger'"
                                style="font-size: 14px;"
                            >
                                @{{ type }}
                            </span>
                        </div>

                        <!-- Time -->
                        <p class="text-muted mb-0">
                            <i class="far fa-clock"></i> @{{ t }}
                        </p>

                    </div>
                </div>
            </div>
            <div class="col-md-6 border">
                <!-- QR Scanner Card -->
                <div class="card mt-2">
                    <div class="card-header bg-primary text-white">
                        <i class="fas fa-qrcode"></i>  Scan QR
                    </div>
                    <div class="card-body">
                        <!-- QR Scanner Preview -->
                        <div id="qr-reader" style="width: 100%;"></div>

                        <!-- Live scanned QR code -->
                        <div class="alert alert-success mt-3" v-if="scannedCode">
                            <strong>Details:</strong> @{{ scannedCode }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card mt-3" v-if="scannedHistory.length">
                    <div class="card-header bg-secondary text-white">
                        Scanned Codes History
                    </div>

                    <div class="scroll-history">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item"
                                v-for="(code, index) in scannedHistory"
                                :key="index">
                                @{{ code }}
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        
    </div>

<!-- Vendor JS -->

 <script>  
        let qrurl = '{{ route("qr.scan") }}';
    </script>
    <script src="{{ asset('js/vue2.js') }}"></script>
    <script src="{{ asset('js/axios.min.js') }}"></script>
<script src="{{ asset('lib/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('lib/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('lib/ionicons/ionicons.js') }}"></script>
<script src="https://unpkg.com/html5-qrcode"></script>
<!-- Azia JS -->
<script src="{{ asset('js/azia.js') }}"></script>
<script src="{{ asset('js/qrscanner.js') }}"></script>
</body>
</html>
