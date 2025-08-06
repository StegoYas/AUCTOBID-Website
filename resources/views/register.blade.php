<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex h-screen bg-white">
    <div class="w-1/2 bg-[#d59b3d] flex flex-col justify-between p-12">
        <div>
            <img src="https://cdn-icons-png.flaticon.com/512/2329/2329108.png" class="w-20 mb-5">
            <h1 class="text-white text-3xl font-bold">Create Account</h1>
        </div>
        <div class="text-white text-sm">
            <p>Sudah punya akun?</p>
            <a href="{{ route('login') }}" class="underline">Login</a>
            <a href="{{ route('landing') }}" class="underline block">← Kembali ke Landing Page</a>
        </div>
    </div>

    <div class="w-1/2 flex items-center justify-center">
        <form id="registerForm" class="w-[80%] max-w-md space-y-4">
            <h2 class="text-3xl font-bold text-[#743f00]">Create Account</h2>

            <div>
                <label class="block text-sm font-semibold text-[#743f00]">Nama Lengkap</label>
                <input type="text" name="nama_lengkap" required placeholder="Contoh: Bayu Pratama"
                    class="w-full px-4 py-2 mt-1 border rounded-md bg-[#e9c176] focus:outline-none focus:ring-2 focus:ring-[#743f00]">
            </div>

            <div>
                <label class="block text-sm font-semibold text-[#743f00]">Username</label>
                <input type="text" name="username" required placeholder="bayu123"
                    class="w-full px-4 py-2 mt-1 border rounded-md bg-[#e9c176] focus:outline-none focus:ring-2 focus:ring-[#743f00]">
            </div>

            <div>
                <label class="block text-sm font-semibold text-[#743f00]">Email</label>
                <input type="email" name="email" required placeholder="example@mail.com"
                    class="w-full px-4 py-2 mt-1 border rounded-md bg-[#e9c176] focus:outline-none focus:ring-2 focus:ring-[#743f00]">
            </div>

            <div>
                <label class="block text-sm font-semibold text-[#743f00]">Telp</label>
                <input type="text" name="telp" required placeholder="08123456789"
                    class="w-full px-4 py-2 mt-1 border rounded-md bg-[#e9c176] focus:outline-none focus:ring-2 focus:ring-[#743f00]">
            </div>

            <div>
                <label class="block text-sm font-semibold text-[#743f00]">Password</label>
                <input type="password" name="password" required placeholder="********"
                    class="w-full px-4 py-2 mt-1 border rounded-md bg-[#e9c176] focus:outline-none focus:ring-2 focus:ring-[#743f00]">
            </div>
            <div>
    <label class="block text-sm font-semibold text-[#743f00]">Konfirmasi Password</label>
    <input type="password" name="password_confirmation" placeholder="********"
        class="w-full px-4 py-2 mt-1 border rounded-md bg-[#e9c176] focus:outline-none focus:ring-2 focus:ring-[#743f00]">
</div>
            <button type="submit"
                class="w-full bg-[#e9c176] text-[#743f00] font-semibold py-2 rounded-md shadow hover:shadow-lg">Register</button>
        </form>

    <script>
        document.getElementById('registerForm').addEventListener('submit', async function (e) {
            e.preventDefault();

            const form = this;

            const data = {
                nama_lengkap: form.nama_lengkap.value,
                username: form.username.value,
                email: form.email.value,
                telp: form.telp.value,
                password: form.password.value,
                password_confirmation: form.password_confirmation.value,
            };

            try {
                const response = await fetch('/api/masyarakat/register', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify(data)
                });

                const result = await response.json();

                if (response.ok) {
                    alert('Registrasi berhasil!');
                    // window.location.href = '/login';
                } else {
                    let errorMessages = '';
                    for (let field in result.errors) {
                        errorMessages += `${result.errors[field][0]}\n`;
                    }
                    alert(errorMessages || result.message || 'Registrasi gagal');
                }
            } catch (error) {
                console.error(error);
                alert('Terjadi kesalahan saat registrasi.');
            }
        });
    </script>
</body>
</html>
