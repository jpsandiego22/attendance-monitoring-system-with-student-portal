<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AMS | Registration</title>

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
        .az-card-signin { min-width: 450px; height: auto; margin: auto; padding: 30px; }
        .btn-az-primary { background-color: #007bff; border-color: #007bff; }
        .btn-az-primary:hover { background-color: #0069d9; }
    </style>
</head>
<body class="az-body">

<div id="app" class="az-signin-wrapper" v-cloak>
    <div class="az-card-signin shadow-sm rounded">
        <h2 class="text-center mb-4">Registration</h2>
        @include('partials.message')
        <!-- Search Identification -->
        <div class="input-group mb-3">
            <input type="text" v-model="search" class="form-control" placeholder="Search Identification No." required>
            <div class="input-group-append">
                <button class="btn btn-primary" @click="searchUser" type="button">
                    <i class="fa fa-search"></i>
                </button>
            </div>
        </div>

        <!-- Error Message -->
        <div v-if="message" class="alert alert-danger alert-dismissible fade show" role="alert">
            <div v-html="message"></div>
            <button type="button" @click="message = ''" class="close" data-dismiss="alert" aria-label="Close">
                <span>&times;</span>
            </button>
        </div>

        <!-- User Info -->
        <div v-if="users.length" class="alert alert-success alert-dismissible fade show" role="alert">
            <div v-for="user in users" :key="user.id">
                <b>@{{ user.user ? user.user.email : 'Please link your account to your email.' }}</b>
            </div>
            <button type="button" @click="users = []" class="close" data-dismiss="alert" aria-label="Close">
                <span>&times;</span>
            </button>
        </div>

        <hr v-if="users.length">

        <!-- Registration Form -->
        <form @submit.prevent="registerUser" v-if="users.length">
            @csrf
            <div class="form-group">
                <label>Email</label>
                <input type="email" v-model="vemail" class="form-control" placeholder="Enter your email" required>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" v-model="vpassword" class="form-control" placeholder="Enter your password" required>
            </div>
            <button type="submit" class="btn btn-az-primary btn-block mb-2">
                Register
            </button>
        </form>

        <!-- Google Login Button -->
        <a v-if="users.length" 
           :href="redirectUrl" 
           class="btn btn-primary btn-block">
            <i class="fab fa-google float-left bg-white text-primary p-1"></i> 
            Sign In Using Google
        </a>

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
new Vue({
    el: '#app',
    data: {
        search: '',
        vemail: '',
        vpassword: '',
        users: [],
        message: 'Please enter Identification No.'
    },
    computed: {
        redirectUrl() {
            return "{{ route('login.google.redirect') }}" +
                   "?auth_type=registration&regrem=" +
                   encodeURIComponent(JSON.stringify(this.users));
        },
    },
    methods: {
        searchUser() {
            if (!this.search) {
                this.message = 'Please enter Identification No.';
                return;
            }
            axios.post('{{ route('registration.search') }}', { query: this.search })
                .then(response => {
                    if (response.data.status === 'error') {
                        this.users = [];
                        this.message = response.data.message;
                    } else {
                        this.message = '';
                        this.users = Array.isArray(response.data) ? response.data : [response.data];
                    }
                })
                .catch(error => {
                    console.error(error);
                    this.message = 'An error occurred while searching.';
                });
        },
        registerUser() {
            axios.post('{{ route('registration.registerUser') }}', { 
                users: this.users, 
                email: this.vemail, 
                password: this.vpassword 
            })
            .then(response => {
                if (response.data.status === 'success') {
                    this.users = [];
                    this.search = '';
                    this.vemail = '';
                    this.vpassword = '';
                    this.message = 'Registration successful!';
                } else {
                    this.message = response.data.message || 'Registration failed!';
                }
            })
            .catch(error => {
                console.error(error);
                this.message = 'An error occurred during registration.';
            });
        }
    }
});
</script>

</body>
</html>