@extends('layouts.app')

@section('content')

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Landing Page - AuctoBid</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-white min-h-screen">

    

    <!-- Banner -->
    <section class="bg-[#d4a856] text-white py-20 px-4 text-center">
        <img src="{{ asset('logo.png') }}" alt="Logo" class="w-24 h-24 mb-6 rounded-full shadow-lg mx-auto">
        <h1 class="text-4xl font-bold mb-4">Selamat Datang di AuctoBid</h1>
        <p class="text-lg max-w-xl mx-auto mb-6">
            Platform lelang terpercaya untuk tanah, rumah, kendaraan, dan banyak lagi. 
            Temukan penawaran terbaik hanya di sini!
        </p>
        <div class="space-x-4">
            <a href="{{ route('register') }}" class="bg-white text-[#d4a856] font-semibold px-6 py-2 rounded-lg shadow hover:bg-gray-100">
                Daftar Sekarang
            </a>
            <a href="{{ route('login') }}" class="border border-white px-6 py-2 rounded-lg font-semibold hover:bg-white hover:text-[#d4a856]">
                Masuk
            </a>
        </div>
    </section>

    <!-- Kategori Lot Lelang -->
    <section class="bg-white rounded-t-3xl shadow-lg mt-[-40px] pt-8 pb-12 px-4 max-w-6xl mx-auto">
        <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
    <a href="{{ url('/lelang/tanah') }}" class="flex flex-col items-center border rounded-lg p-4 hover:shadow hover:bg-yellow-50 transition">
        <span class="text-3xl mb-2">🏞️</span>
        <span class="font-semibold">Tanah</span>
    </a>

    <a href="{{ url('/lelang/rumah') }}" class="flex flex-col items-center border rounded-lg p-4 hover:shadow hover:bg-yellow-50 transition">
        <span class="text-3xl mb-2">🏠</span>
        <span class="font-semibold">Rumah</span>
    </a>

    <a href="{{ url('/lelang/mobil') }}" class="flex flex-col items-center border rounded-lg p-4 hover:shadow hover:bg-yellow-50 transition">
        <span class="text-3xl mb-2">🚗</span>
        <span class="font-semibold">Mobil</span>
    </a>

    <a href="{{ url('/lelang/motor') }}" class="flex flex-col items-center border rounded-lg p-4 hover:shadow hover:bg-yellow-50 transition">
        <span class="text-3xl mb-2">🛵</span>
        <span class="font-semibold">Motor</span>
    </a>

    <a href="{{ url('/lelang/ruko') }}" class="flex flex-col items-center border rounded-lg p-4 hover:shadow hover:bg-yellow-50 transition">
        <span class="text-3xl mb-2">🏢</span>
        <span class="font-semibold">Ruko</span>
    </a>
</div>

    </section>

    <!-- Cara Penawaran Lelang -->
    <section class="bg-gray-50 py-16 px-4">
        <div class="max-w-4xl mx-auto text-center">
            <h2 class="text-2xl font-bold text-[#1a237e] mb-8">Cara Penawaran Lelang</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-left">
                <div class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition">
                    <h3 class="text-lg font-semibold mb-2 text-[#d4a856]">1. Daftar / Masuk</h3>
                    <p class="text-gray-700">Buat akun AuctoBid atau masuk ke akun Anda untuk memulai.</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition">
                    <h3 class="text-lg font-semibold mb-2 text-[#d4a856]">2. Pilih Lot</h3>
                    <p class="text-gray-700">Telusuri dan pilih properti atau kendaraan yang ingin Anda tawar.</p>
                </div>      
                <div class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition">
                    <h3 class="text-lg font-semibold mb-2 text-[#d4a856]">3. Lakukan Penawaran</h3>
                    <p class="text-gray-700">Masukkan nominal penawaran Anda dan pantau perkembangan lelang secara real-time.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Hubungi Kami -->
<section id="contact" class="bg-[#1a237e] text-white py-12 px-6">
    <div class="max-w-6xl mx-auto grid md:grid-cols-2 gap-8">
        <div>
            <h2 class="text-2xl font-bold mb-4">Hubungi Kami</h2>
            <p class="mb-2">📍 Jl. Contoh No. 123, Jakarta</p>
            <p class="mb-2">📞 021-12345678</p>
            <p class="mb-2">✉️ support@auctobid.id</p>
        </div>
        <div>
            <h2 class="text-2xl font-bold mb-4">Kirim Pesan</h2>
            <form class="space-y-4">
                <input type="text" placeholder="Nama" class="w-full px-4 py-2 rounded text-black" required>
                <input type="email" placeholder="Email" class="w-full px-4 py-2 rounded text-black" required>
                <textarea rows="4" placeholder="Pesan" class="w-full px-4 py-2 rounded text-black" required></textarea>
                <button type="submit" class="bg-white text-[#1a237e] px-6 py-2 rounded font-semibold hover:bg-gray-100">
                    Kirim
                </button>
            </form>
        </div>
    </div>
</section>
</body>
</html>

@endsection
