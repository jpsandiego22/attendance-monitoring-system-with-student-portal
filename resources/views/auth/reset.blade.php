<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AMS | Registration</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Vendor CSS -->
    <link href="{{ asset('lib/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('lib/ionicons/css/ionicons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('lib/typicons.font/typicons.css') }}" rel="stylesheet">

    <!-- Vue & Axios -->
    <script src="{{ asset('js/vue2.js') }}"></script>
    <script src="{{ asset('js/axios.min.js') }}"></script>

    <!-- Azia CSS -->
    <link rel="stylesheet" href="{{ asset('css/azia.css') }}">
    <style>
        [v-cloak] { display: none; }
        .az-card-signin { min-width: 450px; height: auto; margin: auto; margin-top:10%; padding: 30px; }
        .btn-az-primary { background-color: #007bff; border-color: #007bff; }
        .btn-az-primary:hover { background-color: #0069d9; }
    </style>
</head>

<body class="az-body">

<div id="app" class="az-signin-wrapper" v-cloak>
    <div class="az-card-signin shadow-sm rounded">
        <h2 class="text-center mb-4">Forgot Password</h2>
        @include('partials.message')
        <!-- Error Message -->
        <div v-if="message" :class="['alert', 'alert-' + alertClass , 'alert-dismissible' , 'fade' , 'show']" role="alert">
            <div v-html="message"></div>
            <button type="button" @click="message = ''" class="close" data-dismiss="alert" aria-label="Close">
                <span>&times;</span>
            </button>
        </div>
        <!-- Search Identification -->
        <div class="input-group mb-3">
           <input type="text" v-model="vemail" @keyup.enter="searchEmail" class="form-control" placeholder="Enter your email address" required>
            <div class="input-group-append">
                <button class="btn btn-primary"
                        :disabled="loading"
                        @click="searchEmail"
                        type="button">
                    <i v-if="!loading" class="fa fa-search"></i>
                    <span v-else>Sending...</span>
                </button>
            </div>
        </div>

        <!-- Footer -->
        <div class="az-signin-footer mt-3 text-center">
            <p>Already have an account? <a href="{{ route('login') }}">Sign In</a></p>
        </div>
    </div>
</div>

<!-- Vendor JS -->
<script src="{{ asset('lib/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('lib/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('lib/ionicons/ionicons.js') }}"></script>
<script src="{{ asset('js/jquery.cookie.js') }}"></script>
<script src="{{ asset('js/azia.js') }}"></script>

<!-- Vue Script -->
<script>
axios.defaults.headers.common['X-CSRF-TOKEN'] =
document.querySelector('meta[name="csrf-token"]').getAttribute('content');
new Vue({
    el: '#app',
    data: {
        message: '',
        alertClass: '',
        vemail: '',
        loading: false
    },
    methods: {
        searchEmail() {
            if (!this.vemail) {
                this.message = 'Please enter email address.';
                this.alertClass = 'danger';
                return;
            }

            this.loading = true;

            axios.post('{{ route('forgot.password.send') }}', {
                email: this.vemail
            })
            .then(response => {
                this.message = response.data.message;
                this.alertClass = response.data.class;
            })
            .catch(error => {
                this.message = error.response?.data?.message 
                                || 'Something went wrong.';
                this.alertClass = 'danger';
            })
            .finally(() => {
                this.loading = false;
            });
        }
       
    }
});
</script>

</body>
</html>