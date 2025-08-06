<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex h-screen bg-white">
    <div class="w-1/2 bg-[#d59b3d] flex flex-col justify-between p-12">
        <div>
            <img src="https://cdn-icons-png.flaticon.com/512/2329/2329108.png" class="w-20 mb-5">
            <h1 class="text-white text-3xl font-bold">Login</h1>
        </div>
        <div class="text-white text-sm space-y-2">
            <p>Belum punya akun?</p>
            <a href="{{ route('register') }}" class="underline block">Create Account</a>
            <a href="{{ route('landing') }}" class="underline block">← Kembali ke Landing Page</a>
        </div>
    </div>

    <div class="w-1/2 flex items-center justify-center">
        <form id="loginForm" class="w-[80%] max-w-md space-y-6">
            <h2 class="text-3xl font-bold text-[#743f00]">Login</h2>
            <div>
                <label class="block text-sm font-semibold text-[#743f00]">Username</label>
                <input type="text" name="username" required placeholder="bayu123"
                    class="w-full px-4 py-2 mt-1 border rounded-md bg-[#e9c176] focus:outline-none focus:ring-2 focus:ring-[#743f00]">
            </div>
            <div>
                <label class="block text-sm font-semibold text-[#743f00]">Email</label>
                <input type="email" name="email" placeholder="e.g. example@mail.com"
                    class="w-full px-4 py-2 mt-1 border rounded-md bg-[#e9c176] focus:outline-none focus:ring-2 focus:ring-[#743f00]" required>
            </div>

            <div>
                <label class="block text-sm font-semibold text-[#743f00]">Password</label>
                <input type="password" name="password" placeholder="••••••••"
                    class="w-full px-4 py-2 mt-1 border rounded-md bg-[#e9c176] focus:outline-none focus:ring-2 focus:ring-[#743f00]" required>
            </div>

            <div id="errorMessage" class="text-red-600 text-sm"></div>

            <button type="submit"
                class="w-full bg-[#e9c176] text-[#743f00] font-semibold py-2 rounded-md shadow hover:shadow-lg">Login</button>
        </form>
    </div>

    <script>
        document.getElementById('loginForm').addEventListener('submit', async function (e) {
            e.preventDefault();

            const username = this.username.value;
            const email = this.email.value;
            const password = this.password.value;
            const errorBox = document.getElementById('errorMessage');

            try {
                const response = await fetch('/api/masyarakat/login', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({
                        username: username,
                        email: email,
                        password: password
                    })
                });

                const result = await response.json();

                if (response.ok) {
                    localStorage.setItem('token', result.token);  // ⬅️ Simpan token
                    localStorage.setItem('role', result.role);    // ⬅️ Simpan role (jika dikirim oleh backend)
                    alert('Login berhasil!');
                    window.location.href = '{{ route("dashboard") }}';
                    }
                    else {
                    if (result.errors) {
                        // Tampilkan semua pesan error validasi
                        const messages = Object.values(result.errors).flat().join('<br>');
                        errorBox.innerHTML = messages;
                    } else {
                        errorBox.innerText = result.message || 'Login gagal.';
                    }
                }
            } catch (error) {
                console.error(error);
                errorBox.innerText = 'Terjadi kesalahan saat menghubungi server.';
            }
        });
    </script>
</body>
</html>
