<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Laravel App</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-slate-100 flex items-center justify-center p-4">

    <div class="w-full max-w-md bg-white rounded-2xl shadow-xl p-8">

        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-slate-800">Create Account</h1>
            <p class="text-slate-500 mt-2">Silakan buat akun baru Anda</p>
        </div>

        @if ($errors->any())
            <div class="mb-4 p-3 rounded-lg bg-red-100 text-red-700 text-sm">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-slate-700 mb-2">
                    Nama Lengkap
                </label>

                <input
                    type="text"
                    id="name"
                    name="name"
                    value="{{ old('name') }}"
                    required
                    autocomplete="name"
                    placeholder="Nama lengkap"
                    class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none"
                >
            </div>

            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-slate-700 mb-2">
                    Email
                </label>

                <input
                    type="email"
                    id="email"
                    name="email"
                    value="{{ old('email') }}"
                    required
                    autocomplete="username"
                    placeholder="nama@email.com"
                    class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none"
                >
            </div>

            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-slate-700 mb-2">
                    Password
                </label>

                <input
                    type="password"
                    id="password"
                    name="password"
                    required
                    autocomplete="new-password"
                    placeholder="Buat password"
                    class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none"
                >
            </div>

            <div class="mb-6">
                <label for="password_confirmation" class="block text-sm font-medium text-slate-700 mb-2">
                    Konfirmasi Password
                </label>

                <input
                    type="password"
                    id="password_confirmation"
                    name="password_confirmation"
                    required
                    autocomplete="new-password"
                    placeholder="Ulangi password"
                    class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none"
                >
            </div>

            <button
                type="submit"
                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 rounded-lg transition"
            >
                Register
            </button>
        </form>

        <p class="text-center text-sm text-slate-600 mt-6">
            Sudah punya akun?
            <a href="{{ route('login') }}" class="text-blue-600 font-semibold hover:underline">
                Login
            </a>
        </p>

    </div>

</body>
</html>
