<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Landing Page</title>
    <!-- Import Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

    <link rel="icon" href="/images/Fix2.png" type="image/png">

    <style>
        body {
            overflow-x: hidden; /* Mencegah scroll ke kanan/kiri */
            margin: 0; /* Menghilangkan margin default */
            padding: 0; /* Menghilangkan padding default */
            width: 100%; /* Memastikan lebar 100% dari viewport */
        }
        .lingkaran1{
            width: 600px; /* Ukuran lingkaran */
            height: 600px;
            background: #97D9F7;
            border-radius: 100%;
            position: absolute; /* Menentukan posisi absolute */
            top: -150px; /* Jarak dari atas */
            right: -150px; /* Jarak dari kanan */
            z-index: -1; /* Di belakang elemen lain */
            opacity: 0.5; /* Transparansi */
        }
    </style>
</head>
<body class="bg-gray-100 font-sans antialiased">

    <div class="navbar bg-base-100 px-4" style="background-color: #000C7B; display: flex; align-items: center;">
        <img src="/images/Fix2.png" alt="Logo" style="width: 18px; height: 18px; margin-right: 10px;">
        <a class="btn btn-ghost text-xl text-white">MANAJEMEN INFORMATIKA</a>
    </div>



    <!-- Container Utama -->
    <div class="container mx-auto flex flex-col lg:flex-row justify-center items-center mt-10 lg:mt-20">

<!-- Teks dan Tombol -->
<div class="flex flex-col justify-center items-center lg:items-start text-center lg:text-left lg:w-1/2 p-6 ml-6 lg:ml-12">
    <h1 class="text-3xl lg:text-4xl font-bold mb-4">Selamat Datang di Web Peminjaman Barang Manajemen Informatika</h1>
    <div class="flex space-x-4 mt-6">
        <a href="register" class="bg-blue-500 text-white font-semibold px-6 py-3 rounded shadow hover:bg-blue-600 transition duration-300">DAFTAR</a>

        <a href="login" class="bg-white text-blue-500 font-semibold px-6 py-3 rounded shadow hover:bg-gray-100 transition duration-300">MASUK</a>
    </div>
</div>


        <!-- Gambar Ilustrasi -->
        <div class="lg:w-1/2 mt-10 lg:mt-0">
            <img src="/images/page.png" alt="Ilustrasi" class="w-full h-auto" style="width: 400px; height: 400px; margin-left:150px; ">
        </div>

        <!-- Lingkaran di Pojok Kanan Atas -->
        <div class="lingkaran1"></div>
    </div>

</body>
</html>
