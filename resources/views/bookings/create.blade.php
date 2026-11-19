<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Pesanan | SIGAPRODUCTION</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-50 text-slate-800">

<header class="bg-slate-950 text-white">
    <div class="mx-auto max-w-5xl px-6 py-5">
        <h1 class="text-xl font-bold">SIGAPRODUCTION</h1>
        <p class="text-sm text-slate-400">Bookings & Orders Management</p>
    </div>
</header>

<main class="mx-auto max-w-5xl px-6 py-10">

    <a href="{{ route('bookings.index') }}"
       class="text-sm font-semibold text-indigo-600 hover:text-indigo-800">
        ← Kembali ke daftar pesanan
    </a>

    <div class="my-6">
        <p class="text-sm font-semibold uppercase tracking-wider text-indigo-600">
            New Transaction
        </p>
        <h2 class="mt-1 text-3xl font-bold text-slate-900">Buat Pesanan Baru</h2>
        <p class="mt-2 text-slate-500">
            Hubungkan pelanggan dengan salah satu unit bisnis SIGAPRODUCTION.
        </p>
    </div>

    @if($errors->any())
        <div class="mb-6 rounded-xl border border-red-200 bg-red-50 p-5 text-red-700">
            <p class="font-semibold">Pesanan belum dapat disimpan.</p>
            <ul class="mt-2 list-inside list-disc text-sm">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
        <form action="{{ route('bookings.store') }}" method="POST">
            @csrf

            @php
                $booking = null;
                $submitLabel = 'Simpan Pesanan';
            @endphp

            @include('bookings._form')
        </form>
    </div>

</main>
</body>
</html>
