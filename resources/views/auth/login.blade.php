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

    <!-- Azia CSS -->
    <link rel="stylesheet" href="{{ asset('css/azia.css') }}">
    <link rel="stylesheet" href="{{ asset('css/master.css') }}">
</head>

<body class="az-body">

<div id="app" class="az-signin-wrapper">
    <div class="az-card-signin">
        <h1 class="az-logo">AMS</h1>

        <div class="az-signin-header">
            <h2>Welcome back!</h2>
            <h5>Please sign in to continue</h5>

              <form method="POST" action="{{ route('login') }}">
              @csrf
                @include('partials.message')
                <div class="form-group">
                   
                    <input type="email" name="email" class="form-control" placeholder=" " value="{{ old('email') }}" required>
                 <label>Email</label>
                </div>

                <div class="form-group">
                   
                    <input type="password" name="password" class="form-control" placeholder=" " required>
                 <label>Password</label>
                </div>

                <button type="submit" class="btn btn-az-primary btn-block">
                    Sign In
                </button>

                
               
               
            </form>
      
        </div>
        <div class="row">
            <div class="col-md-12">
                <p>
                    <hr>
                </p>
                <button type="submit" class="btn btn-primary  btn-block">
                    <i class="fab fa-google float-left bg-white text-primary p-1"></i> Sign In Using Google
                </button>
            </div>
            
            
           
            
        </div>
        <div class="az-signin-footer">
            <p>
                {{-- <a href="{{ route('password.request') }}">Forgot password?</a> --}}
            </p>
            <p>
                Don't have an account?
                <a href="{{ route('login.register') }}">Create an Account</a>
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

</body>
</html>
