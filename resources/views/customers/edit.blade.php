<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pelanggan | SIGAPRODUCTION</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-50 text-slate-800">

<header class="bg-slate-950 text-white">
    <div class="mx-auto max-w-5xl px-6 py-5">
        <h1 class="text-xl font-bold">SIGAPRODUCTION</h1>
        <p class="text-sm text-slate-400">Customer Management System</p>
    </div>
</header>

<main class="mx-auto max-w-5xl px-6 py-10">
    <a href="{{ route('customers.index') }}"
       class="text-sm font-semibold text-indigo-600">
        ← Kembali ke daftar pelanggan
    </a>

    <div class="my-6">
        <h2 class="text-3xl font-bold text-slate-900">Edit Pelanggan</h2>
        <p class="mt-2 text-slate-500">
            Perbarui informasi {{ $customer->name }}.
        </p>
    </div>

    @if($errors->any())
        <div class="mb-6 rounded-xl border border-red-200 bg-red-50 p-4 text-red-700">
            <p class="mb-2 font-semibold">Terdapat kesalahan:</p>
            <ul class="list-inside list-disc text-sm">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
        <form action="{{ route('customers.update', $customer) }}" method="POST">
            @csrf
            @method('PUT')

            @php
                $submitLabel = 'Simpan Perubahan';
            @endphp

            @include('customers._form')
        </form>
    </div>
</main>
</body>
</html>
