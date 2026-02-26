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
    <script src="https://cdn.jsdelivr.net/npm/vue@2/dist/vue.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
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
    <script>
        new Vue({
            el: '#app_img',
            data: {
                img: null,
            },
            methods: {
                 handleFile(event) {
                    this.img = event.target.files[0];
                    this.img_upload(); // auto upload after select
                },

                img_upload() {
                    let formData = new FormData();
                    formData.append('img', this.img);

                    axios.post('{{ route("upload.photo") }}', formData, {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    })
                    .then(response => {
                        console.log(response.data);
                        if (response.data.status === 'success') {
                            location.reload();
                        }
                    })
                    .catch(error => {
                        console.error(error);
                    });
                },
            }
        });
        </script>
    @yield('js')
    <script src="{{ asset('js/azia.js') }}"></script>
   
</body>
</html>
