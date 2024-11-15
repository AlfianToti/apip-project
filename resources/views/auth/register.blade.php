<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register || Aplikasi Peminjaman</title>
    <!-- Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!-- Font Awesome for icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <link rel="icon" href="/images/Fix2.png" type="image/png">
    <style>
        body {
            background-image: url('/images/bg.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }
        .centered-text {
            text-align: center;
        }
        .register-container {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            align-items: center;
            justify-content: center;
            padding: 10px;
        }
        .register-card {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 15px;
            overflow: hidden;
            max-width: 850px;
            width: 100%;
            display: flex;
            background-color: white;
            margin-bottom: 20px;
        }
        .register-image {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #002871e7;
            padding: 20px;
        }
        .register-image img {
            max-width: 70%;
            height: auto;
        }
        .register-form {
            flex: 1;
            padding: 20px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        .btn-custom {
            background-color: #030d38;
            border-color: #00bfff;
            color: white;
            border-radius: 30px;
            padding: 12px 20px;
            margin-top: 20px;
            min-width: 150px;
            max-width: 200px;
            display: block;
            margin: 20px auto;
            text-align: center;
        }
        .btn-custom:hover {
            background-color: #00a1e0;
            border-color: #00a1e0;
        }
        .form-group {
            margin-bottom: 1rem;
        }
        .form-control {
            display: flex;
            align-items: center;
            border: 1px solid #ccc;
            border-radius: 30px;
            overflow: hidden;
            padding-left: 8px;
        }
        .form-control input {
            border: none;
            padding: 8px;
            width: 100%;
            outline: none;
            border-radius: 30px;
        }
        .form-control span {
            padding: 0 10px;
            color: #aaa;
        }
        .floating-button {
            position: fixed;
            bottom: 15px;
            right: 15px;
            background-color: #00318b;
            color: white;
            border-radius: 50%;
            width: 45px;
            height: 45px;
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
<div class="register-container">
    <div class="register-card">
        <div class="register-image">
            <img src="{{ asset('img/logo-mi.png') }}" alt="Register Image">
        </div>
        <div class="register-form">
            <div class="centered-text">
                <h2 class="text-xl mb-4 font-semibold">Registrasi</h2>
            </div>
            <!-- Formulir Pendaftaran -->
            <form method="POST" action="{{ route('register') }}">
                @csrf <!-- Token CSRF untuk keamanan -->

                <!-- Input Username dan NIM -->
                <div class="flex space-x-4">
                    <!-- Username -->
                    <div class="form-group w-1/2">
                        <label for="name" class="block mb-1">Username</label>
                        <div class="form-control">
                            <span><i class="fas fa-user"></i></span>
                            <input type="text" id="name" name="name" placeholder="Username" required>
                        </div>
                    </div>

                    <!-- NIM -->
                    <div class="form-group w-1/2">
                        <label for="nim" class="block mb-1">NIM</label>
                        <div class="form-control">
                            <span><i class="fas fa-id-card"></i></span>
                            <input type="text" id="nim" name="nim" placeholder="NIM">
                        </div>
                    </div>
                </div>

                <!-- Input Email dan Password -->
                <div class="flex space-x-4">
                    <!-- Email -->
                    <div class="form-group w-1/2">
                        <label for="email" class="block mb-1">Email</label>
                        <div class="form-control">
                            <span><i class="fas fa-envelope"></i></span>
                            <input type="email" id="email" name="email" placeholder="Email" required>
                        </div>
                    </div>

                    <!-- Password -->
                    <div class="form-group w-1/2">
                        <label for="password" class="block mb-1">Password</label>
                        <div class="form-control">
                            <span><i class="fas fa-lock"></i></span>
                            <input type="password" id="password" name="password" placeholder="Password" required>
                        </div>
                    </div>
                </div>

                <!-- Input No. HP dan Konfirmasi Password -->
                <div class="flex space-x-4">
                    <!-- No. HP -->
                    <div class="form-group w-1/2">
                        <label for="no_hp" class="block mb-1">No. HP</label>
                        <div class="form-control">
                            <span><i class="fas fa-phone"></i></span>
                            <input type="text" id="no_hp" name="no_hp" placeholder="No. HP">
                        </div>
                    </div>

                    <!-- Konfirmasi Password -->
                    <div class="form-group w-1/2">
                        <label for="password_confirmation" class="block mb-1">Confirm Password</label>
                        <div class="form-control">
                            <span><i class="fas fa-lock"></i></span>
                            <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Confirm Password" required>
                        </div>
                    </div>
                </div>

                <!-- Tombol Submit -->
                <button type="submit" class="btn-custom">Daftar</button>
            </form>
        </div>
    </div>

    <!-- Floating Button for Landing Page -->
    <a href="/" class="floating-button">
        <i class="fas fa-home"></i>
    </a>
</div>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<!-- Font Awesome -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js"></script>
</body>
</html>
