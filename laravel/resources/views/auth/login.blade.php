<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Laravel App</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-slate-100 flex items-center justify-center p-4">

    <div class="w-full max-w-md bg-white rounded-2xl shadow-xl p-8">

        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-slate-800">Welcome Back</h1>
            <p class="text-slate-500 mt-2">Silakan login ke akun Anda</p>
        </div>

        @if (session('status'))
            <div class="mb-4 p-3 rounded-lg bg-green-100 text-green-700 text-sm">
                {{ session('status') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-4 p-3 rounded-lg bg-red-100 text-red-700 text-sm">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="mb-5">
                <label for="email" class="block text-sm font-medium text-slate-700 mb-2">
                    Email
                </label>

                <input
                    type="email"
                    id="email"
                    name="email"
                    value="{{ old('email') }}"
                    required
                    autofocus
                    autocomplete="username"
                    placeholder="nama@email.com"
                    class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none"
                >
            </div>

            <div class="mb-6">
                <label for="password" class="block text-sm font-medium text-slate-700 mb-2">
                    Password
                </label>

                <input
                    type="password"
                    id="password"
                    name="password"
                    required
                    autocomplete="current-password"
                    placeholder="Masukkan password"
                    class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none"
                >
            </div>

            <div class="flex items-center mb-6">
                <input
                    type="checkbox"
                    id="remember"
                    name="remember"
                    value="1"
                    class="w-4 h-4 text-blue-600"
                >

                <label for="remember" class="ml-2 text-sm text-slate-600">
                    Ingat saya
                </label>
            </div>

            <button
                type="submit"
                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 rounded-lg transition"
            >
                Login
            </button>
        </form>

        <p class="text-center text-sm text-slate-600 mt-6">
            Belum punya akun?
            <a href="{{ route('register') }}" class="text-blue-600 font-semibold hover:underline">
                Register
            </a>
        </p>

    </div>

</body>
</html>
