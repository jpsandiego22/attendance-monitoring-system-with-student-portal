<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Google Analytics -->


    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Responsive Bootstrap 4 Dashboard Template">
    <meta name="author" content="BootstrapDash">

    <title>AMS | Login</title>

    <!-- Vendor CSS -->
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"> --}}
    <link href="{{ asset('lib/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('lib/ionicons/css/ionicons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('lib/typicons.font/typicons.css') }}" rel="stylesheet">
    <script src="{{ asset('js/vue2.js') }}"></script>
    <script src="{{ asset('js/axios.min.js') }}"></script>
    <!-- Azia CSS -->
    <link rel="stylesheet" href="{{ asset('css/azia.css') }}">
    <style>
    [v-cloak] {
        display: none;
    }
</style>
</head>

<body class="az-body">

<div id="app" class="az-signin-wrapper" v-cloak>
    <div class="az-card-signin">
        <h2>Registration</h2>
        <div class="container mt-1">
            <div class="input-group mb-1">
                <input type="text" v-model="search" class="form-control" placeholder="Search Identification No." required>
                <span class="input-group-btn">
                    <button class="btn btn-primary" @click="searchUser" type="button"><i class="fa fa-search"></i></button>
                </span>
            </div>
            <div class="mt-1" v-if="users.length">
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <span v-for="user in users" :key="user.id">
                        <b>@{{ user.user ? user.user.email : 'Please link your account to your email.' }}</b>
                        
                    </span>
                    <button type="button"  @click="users = []" class="close" data-dismiss="alert" aria-label="Close">
                            <span>&times;</span>
                        </button>
                </div>
                <hr>
                <div class="mt-5" v-if="message.length">
                    <div v-if="message.length" class="alert alert-danger alert-dismissible fade show" role="alert">
                        @{{ message }}
                        <button type="button"  @click="message = ''" class="close" data-dismiss="alert" aria-label="Close">
                            <span>&times;</span>
                        </button>
                    </div>
                </div>
                <form @submit.prevent="registerUser">
                    @csrf
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email"  v-model="vemail" class="form-control" placeholder="Enter your email" value="{{ old('email') }}" required>
                    </div>

                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" v-model="vpassword" class="form-control" placeholder="Enter your password" required>
                    </div>
                    <button type="submit" class="btn btn-az-primary btn-block">
                        Register
                    </button>
                    <button type="button" class="btn btn-primary  btn-block">
                        <i class="fab fa-google float-left bg-white text-primary p-1"></i> Register Using Google
                    </button>
                </form>
            </div>
          
            
            
        </div>
        

        <div class="az-signin-footer">
            <p>
                {{-- <a href="{{ route('password.request') }}">Forgot password?</a> --}}
            </p>
            <p>
                Already have an Account?
                <a href="{{ route('login') }}">Sign In</a>
            </p>
        </div>
    </div>
</div>

<!-- Vendor JS -->
<script src="{{ asset('lib/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('lib/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('lib/ionicons/ionicons.js') }}"></script>
<script src="{{ asset('js/jquery.cookie.js') }}"></script>

<!-- Azia JS -->
<script src="{{ asset('js/azia.js') }}"></script>

<script>
    $(function(){
        'use strict';
    });
</script>
<script>
new Vue({
    el: '#app',
    data: {
        search: '',
        vemail:'',
        vpassword:'',
        users: [],
        message:'Please Enter Identification No.'
    },
    methods: {
        searchUser() {
            axios.post('{{ route('registration.search') }}',{ query: this.search })
                 .then(response => {
                    if (response.data.status === 'error') {
                        this.users = [];
                        this.message = response.data.message;
                    } else {
                        this.message = '';
                        this.users = [response.data]; // wrap object in array
                    }
                    console.error(response.data);
                 })
                 .catch(error => {
                     console.error(error);
                 });
        },
        registerUser() {
            axios.post('{{ route('registration.registerUser') }}',{ data: this.users, email: this.vemail, password: this.vpassword })
                 .then(response => {
                    if (response.data.status === 'success') {
                        this.users = [];
                        this.search ='';
                        this.vemail ='';
                        this.vpassword ='';
                        this.message ='';
                    } else {
                        this.message = response.data.message;
                    }
                    console.error(response.data);
                 })
                 .catch(error => {
                     console.error(error);
                 });
        }
    }
});
</script>
</body>
</html>
