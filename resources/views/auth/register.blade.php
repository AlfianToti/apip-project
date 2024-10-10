<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Horizontal Registration</title>
    <!-- Tailwind CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        .background {
            background-image: url('/images/bg.jpg'); /* Replace with your background image URL */
            background-size: cover;
            background-position: center;
            height: 100vh;
        }
    </style>
</head>
<body class="background flex items-center justify-center">

    <!-- Main Container -->
    <div class="bg-white bg-opacity-80 rounded-lg p-8 flex items-center space-x-8 shadow-lg">
        <!-- Logo Section -->
        <div class="flex-shrink-0">
            <img src="/images/Fix2.png" alt="Logo" class="w-40 h-40 rounded-full shadow-lg"> <!-- Adjust the image size as needed -->
        </div>

        <!-- Registration Form -->
        <div class="w-full max-w-xl"> <!-- Changed max-w-md to max-w-xl -->
            <h2 class="text-2xl font-bold mb-6 text-center">REGISTRASI</h2>
            <form class="space-y-4" method="POST" action="{{ route('register') }}">
                @csrf <!-- Tambahkan CSRF token untuk keamanan -->

                <!-- Username and NIM in Horizontal Layout -->
                <div class="flex space-x-4">
                    <!-- Username -->
                    <div class="w-1/2">
                        <label class="block text-sm font-medium text-gray-700">Username</label>
                        <input type="text" name="name" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" required>
                    </div>

                    <!-- NIM -->
                    <div class="w-1/2">
                        <label class="block text-sm font-medium text-gray-700">NIM</label>
                        <input type="text" name="nim" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    </div>
                </div>

                <!-- Email and Password in Horizontal Layout -->
                <div class="flex space-x-4">
                    <!-- Email -->
                    <div class="w-1/2">
                        <label class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" name="email" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" required>
                    </div>

                    <!-- Password -->
                    <div class="w-1/2">
                        <label class="block text-sm font-medium text-gray-700">Password</label>
                        <input type="password" name="password" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" required>
                    </div>
                </div>

                <!-- No. HP -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">No. HP</label>
                    <input type="text" name="no_hp" class="mt-1 block w-1/2 px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                </div>

                <!-- Submit Button -->
                <div class="text-center">
                    <button type="submit" class="w-1/2 py-2 px-4 bg-blue-600 text-white rounded-md shadow-md hover:bg-blue-700 focus:outline-none">DAFTAR</button>
                </div>
            </form>
        </div>
    </div>

</body>
</html>
