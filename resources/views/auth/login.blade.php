<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login || Aplikasi Peminjaman</title>
    <!-- Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!-- Font Awesome for icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-image: url('{{ asset('images/bg-gedung-a.png') }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }
        .centered-text {
            text-align: center;
        }
        .login-container {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            align-items: center;
            justify-content: center;
        }
        .login-card {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 20px;
            overflow: hidden;
            max-width: 900px;
            width: 100%;
            display: flex;
            background-color: white;
            margin-bottom: 20px;
        }
        .login-image {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-image img {
            max-width: 80%;
            height: auto;
        }
        .login-form {
            flex: 1;
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        .btn-custom {
            background-color: #030d38;
            border-color: #00bfff;
            color: white;
            border-radius: 30px;
            width: 100%;
            padding: 10px 0;
            margin-top: 10px;
        }
        .btn-custom:hover {
            background-color: #00a1e0;
            border-color: #00a1e0;
        }
        .form-group {
            margin-bottom: 1.5rem;
        }
        .form-control {
            display: flex;
            align-items: center;
            border: 1px solid #ccc;
            border-radius: 30px;
            overflow: hidden;
            padding-left: 10px;
        }
        .form-control input {
            border: none;
            padding: 10px;
            width: 100%;
            outline: none;
            border-radius: 30px;
        }
        .form-control span {
            padding: 0 15px;
            color: #aaa;
        }
        .form-check {
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
        }
        .form-check input {
            margin-right: 10px;
        }
        .form-check span {
            margin-left: 5px;
        }
        .form-submit {
            margin-top: 2rem;
            display: flex;
            justify-content: center;
        }
        /* Style for the round button in the bottom right corner */
        .floating-button {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background-color: #00318b;
            color: white;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .floating-button:hover {
            background-color: #00a1e0;
        }
    </style>
</head>
<body>
<div class="login-container">
    <div class="login-card">
        <div class="login-image">
            <img src="{{ asset('images/logo-mi.png') }}" alt="Login Image">
        </div>
        <div class="login-form">
            <div class="centered-text">
                <h2 class="text-2xl mb-4 font-semibold">Login</h2>
            </div>
            <form method="POST" action="{{ route('login') }}">
    @csrf
    <div class="form-group">
        <label for="email" class="block mb-2">Email</label>
        <div class="form-control">
            <span><i class="fas fa-envelope"></i></span>
            <input type="email" id="email" name="email" placeholder="Email" value="{{ old('email') }}" required autofocus>
        </div>
    </div>
    <div class="form-group">
        <label for="password" class="block mb-2">Password</label>
        <div class="form-control relative">
            <span><i class="fas fa-lock"></i></span>
            <input type="password" id="password" name="password" placeholder="Password" required>
            <span class="absolute inset-y-0 right-0 flex items-center pr-3 cursor-pointer" id="togglePassword">
                <i class="fas fa-eye" id="eyeIcon"></i>
            </span>
        </div>
    </div>
    <div class="form-check">
        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
        <span>Remember me</span>
    </div>
    <button type="submit" class="btn-custom">Sign In</button>
</form>
            <div class="text-center mt-4">
                <p>Don't have an account? <a href="register" class="text-blue-500 hover:underline">Sign Up</a></p>
            </div>
        </div>
    </div>
</div>

<!-- Floating Button for Landing Page -->
<a href="/" class="floating-button">
    <i class="fas fa-home"></i>
</a>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<!-- Font Awesome -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#password');
        const eyeIcon = document.querySelector('#eyeIcon');

        togglePassword.addEventListener('click', function (e) {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            eyeIcon.classList.toggle('fa-eye');
            eyeIcon.classList.toggle('fa-eye-slash');
        });
    });
</script>
</body>
</html>
