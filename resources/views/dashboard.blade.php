@extends('layouts.app')

@section('content')

{{-- ===== Landing Section ===== --}}
<!-- Banner -->
<section class="bg-[#d4a856] text-white py-20 px-4 text-center">
    <img src="{{ asset('logo.png') }}" alt="Logo" class="w-24 h-24 mb-6 rounded-full shadow-lg mx-auto">
    <h1 class="text-4xl font-bold mb-4">Selamat Datang di AuctoBid</h1>
    <p class="text-lg max-w-xl mx-auto mb-6">
        Platform lelang terpercaya untuk tanah, rumah, kendaraan, dan banyak lagi. 
        Temukan penawaran terbaik hanya di sini!
    </p>
</section>

<!-- Kategori Lot -->
<section class="bg-white rounded-t-3xl shadow-lg pt-8 pb-12 px-4 max-w-6xl mx-auto -mt-12">
    <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
        @php
            $kategori = [
                ['label' => 'Tanah', 'icon' => '🏞️'],
                ['label' => 'Rumah', 'icon' => '🏠'],
                ['label' => 'Mobil', 'icon' => '🚗'],
                ['label' => 'Motor', 'icon' => '🛵'],
                ['label' => 'Ruko', 'icon' => '🏢'],
            ];
        @endphp
        @foreach ($kategori as $item)
        <a href="{{ url('/lelang/' . strtolower($item['label'])) }}"
           class="flex flex-col items-center border rounded-lg p-4 hover:shadow hover:bg-yellow-50 transition">
            <span class="text-3xl mb-2">{{ $item['icon'] }}</span>
            <span class="font-semibold">{{ $item['label'] }}</span>
        </a>
        @endforeach
    </div>
</section>

@php
    $level = auth()->guard('admin')->user()->level ?? null; // atau ganti sesuai guard kamu
@endphp

@if ($level === 'admin' || $level === 'petugas')

    {{-- ===== Dashboard Section ===== --}}
    <div class="p-6 max-w-6xl mx-auto">
        <h2 class="text-3xl font-bold text-[#743f00] mb-6 mt-12">Dashboard AuctoBid</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white rounded-lg shadow-md p-6 border-t-4 border-[#d1a75e]">
                <h3 class="text-xl font-semibold text-[#743f00] mb-2">Total Lot Lelang</h3>
                <p class="text-3xl font-bold">24</p>
            </div>
            <div class="bg-white rounded-lg shadow-md p-6 border-t-4 border-[#d1a75e]">
                <h3 class="text-xl font-semibold text-[#743f00] mb-2">User Terdaftar</h3>
                <p class="text-3xl font-bold">104</p>
            </div>
            <div class="bg-white rounded-lg shadow-md p-6 border-t-4 border-[#d1a75e]">
                <h3 class="text-xl font-semibold text-[#743f00] mb-2">Lelang Aktif</h3>
                <p class="text-3xl font-bold">6</p>
            </div>
        </div>

        <div class="mt-10">
            <h3 class="text-2xl font-bold text-[#743f00] mb-4">Riwayat Lelang Terbaru</h3>
            <div class="overflow-x-auto bg-white rounded shadow">
                <table class="min-w-full text-sm text-left">
                    <thead class="bg-[#d1a75e] text-white">
                        <tr>
                            <th class="py-3 px-4">Lot</th>
                            <th class="py-3 px-4">Kategori</th>
                            <th class="py-3 px-4">Penawar</th>
                            <th class="py-3 px-4">Harga Tertinggi</th>
                            <th class="py-3 px-4">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="border-b hover:bg-gray-50">
                            <td class="py-2 px-4">MTR001</td>
                            <td class="py-2 px-4">Motor</td>
                            <td class="py-2 px-4">Bayu</td>
                            <td class="py-2 px-4">Rp 12.000.000</td>
                            <td class="py-2 px-4 text-green-600 font-semibold">Selesai</td>
                        </tr>
                        <tr class="border-b hover:bg-gray-50">
                            <td class="py-2 px-4">RMH012</td>
                            <td class="py-2 px-4">Rumah</td>
                            <td class="py-2 px-4">Putri</td>
                            <td class="py-2 px-4">Rp 250.000.000</td>
                            <td class="py-2 px-4 text-yellow-600 font-semibold">Berlangsung</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endif


{{-- ===== Contact Section ===== --}}
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
    <script>
  const token = localStorage.getItem('token');
  if (!token) {
    alert("Silakan login terlebih dahulu.");
    window.location.href = "/login";
  }
</script>
</section>
@endsection
