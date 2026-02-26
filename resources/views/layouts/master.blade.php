<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>AMS | @yield('title', 'Dashboard')</title>

    <!-- Vendor CSS -->
    <link href="{{ asset('lib/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('lib/ionicons/css/ionicons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('lib/typicons.font/typicons.css') }}" rel="stylesheet">
    <link href="{{ asset('lib/flag-icon-css/css/flag-icon.min.css') }}" rel="stylesheet">
    <!-- Azia CSS -->
    

    @yield('css')
    <link rel="stylesheet" href="{{ asset('css/azia.css') }}">
    
</head>
<body >
    
    {{-- HEADER --}}
    @include('partials.header')

    {{-- CONTENT --}}
    <div  class="az-content-dashboard">
        @include('partials.profile')
        @include('partials.change-password')
        
        <div class="container">
            <div class="az-content-body">
                <div class="az-dashboard-one-title ">
                    <div>
                        <h2 class="az-dashboard-title">{{ $page_title }}</h2>
                        <p class="az-dashboard-text">{{ $page_sub }}</p>
                       
                    </div>
                </div>
                @yield('message')
                @yield('content')
            </div>
        </div>
    </div>

    {{-- FOOTER --}}
    @include('partials.footer')
    <script>  
        let imgUrl = '{{ route("upload.photo") }}';
        let chngePass = '{{ route("change.password") }}';
    </script>
    <script src="{{ asset('js/vue2.js') }}"></script>
    <script src="{{ asset('js/axios.min.js') }}"></script>
    <script src="{{ asset('js/master.js') }}"></script>
    <!-- Vendor JS -->
    <script src="{{ asset('lib/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('lib/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('lib/ionicons/ionicons.js') }}"></script>
    <script src="{{ asset('lib/jquery.flot/jquery.flot.js') }}"></script>
    <script src="{{ asset('lib/jquery.flot/jquery.flot.resize.js') }}"></script>
    <script src="{{ asset('lib/chart.js/Chart.bundle.min.js') }}"></script>
    <script src="{{ asset('lib/peity/jquery.peity.min.js') }}"></script>

    
    <script src="{{ asset('js/chart.flot.sampledata.js') }}"></script>
    <script src="{{ asset('js/dashboard.sampledata.js') }}"></script>
    
    @yield('js')
    <script src="{{ asset('js/azia.js') }}"></script>
    
</body>
</html>
