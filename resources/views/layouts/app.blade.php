<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AuctoBid</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

<!-- NAVBAR -->
<nav class="flex justify-between items-center px-6 py-4 bg-[#d4a856] text-white">
  <div class="text-2xl font-bold">AuctoBid</div>
  <ul class="flex space-x-6 items-center">
    <li><a href="/" class="hover:underline">Home</a></li>
    <li><a href="/#contact" class="hover:underline">Contact</a></li>
    <li><a href="/dashboard" class="hover:underline" id="dashboardLink">Dashboard</a></li>
    <li id="logoutSection" class="hidden">
      <button onclick="logout()" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded">
        Logout
      </button>
    </li>
  </ul>
</nav>

<!-- CONTENT -->
<main class="p-6">
    @yield('content')
</main>

<!-- FOOTER -->
<footer class="text-center py-4 bg-white shadow mt-10">
    <p class="text-gray-500 text-sm">© {{ date('Y') }} AuctoBid. All rights reserved.</p>
</footer>

<!-- SCRIPT -->
<script>
  document.addEventListener('DOMContentLoaded', function () {
  const token = localStorage.getItem('token');
  const logoutSection = document.getElementById('logoutSection');
  const dashboardLink = document.getElementById('dashboardLink');

  if (token) {
    logoutSection.classList.remove('hidden');
    dashboardLink.classList.remove('hidden');
  } else {
    logoutSection.classList.add('hidden');
    dashboardLink.classList.add('hidden');
  }
});


  function logout() {
    localStorage.removeItem('token');
    localStorage.removeItem('role');
    localStorage.removeItem('user');
    alert("Berhasil logout.");
    window.location.href = "/"; // Redirect ke halaman utama
  }
</script>

</body>
</html>
