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
    <link rel="stylesheet" href="{{ asset('css/azia.css') }}">
</head>

<body class="az-body">

<div class="container mt-5" id="app_qr_scanner">
    <div class="row justify-content-center">
        <div class="col-md-6">

            <!-- QR Scanner Card -->
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <i class="fas fa-qrcode"></i> QR Scanner
                </div>
                <div class="card-body">
                    <!-- QR Scanner Preview -->
                    <div id="qr-reader" style="width: 100%;"></div>

                    <!-- Live scanned QR code -->
                    <div class="alert alert-success mt-3" v-if="scannedCode">
                        <strong>Scanned QR:</strong> @{{ scannedCode }}
                    </div>
                </div>
            </div>

            <!-- Optional: History of scanned codes -->
            <div class="card mt-3" v-if="scannedHistory.length">
                <div class="card-header bg-secondary text-white">
                    Scanned Codes History
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item" v-for="(code, index) in scannedHistory" :key="index">
                        @{{ code }}
                    </li>
                </ul>
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
<script src="{{ asset('js/jquery.cookie.js') }}"></script>
<script src="https://unpkg.com/html5-qrcode"></script>
<!-- Azia JS -->
<script src="{{ asset('js/azia.js') }}"></script>
<script src="{{ asset('js/qrscanner.js') }}"></script>
</body>
</html>
