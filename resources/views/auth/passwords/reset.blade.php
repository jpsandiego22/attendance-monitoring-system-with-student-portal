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
       /* Center card and make it responsive */
 .az-card-signin { min-width: 450px; height: auto; margin: auto; margin-top:10%; padding: 30px; }
        .btn-az-primary { background-color: #007bff; border-color: #007bff; }
        .btn-az-primary:hover { background-color: #0069d9; }

/* Adjust form labels on small screens */
@media (max-width: 576px) {
    .col-form-label.text-md-end {
        text-align: left !important;
    }
   
}
    </style>
</head>

<body class="az-body">

<div id="app" class="az-signin-wrapper" v-cloak>
    <div class="az-card-signin shadow-sm rounded">

                <div class="card-header">{{ __('Reset Password') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf

                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                            <div class="col-md-8">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                            <div class="col-md-8">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>

                            <div class="col-md-8">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Reset Password') }}
                                </button>
                            </div>
                        </div>
                    </form>
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
