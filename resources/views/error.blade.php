<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Error Page</title>

    <!-- Bootstrap 4 CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.6.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .error-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            text-align: center;
        }
        .error-code {
            font-size: 120px;
            font-weight: 700;
            color: #dc3545;
        }
        .error-message {
            font-size: 24px;
            margin-bottom: 20px;
        }
        .btn-home {
            font-size: 18px;
        }
    </style>
</head>
<body>

<div class="container error-container text-center mt-5">
    <div class="error-code">{{ session('code') ?? 'Error' }}</div>
    <div class="error-message">{{ session('message') ?? 'Something went wrong' }}</div>
    <p class="text-muted mb-4">
        The page you are looking for might have been removed, had its name changed, or is temporarily unavailable.
    </p>
    <a href="{{ route('login') }}" class="btn btn-primary btn-home">Go Back Login</a>
</div>

<!-- Bootstrap 4 JS -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.6.2/js/bootstrap.min.js"></script>
</body>
</html>