<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Transaction | SIGAPRODUCTION</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-50 text-slate-800">

<header class="bg-slate-950 text-white">
    <div class="mx-auto flex max-w-7xl items-center justify-between px-6 py-5">
        <div>
            <h1 class="text-xl font-bold">SIGAPRODUCTION</h1>
            <p class="text-sm text-slate-400">Finance Management System</p>
        </div>
        <a href="{{ route('transactions.show', $transaction) }}"
           class="rounded-lg bg-slate-800 px-4 py-2 text-sm hover:bg-slate-700">
            Detail Transaksi
        </a>
    </div>
</header>

<main class="mx-auto max-w-5xl px-6 py-10">

    <div class="mb-8">
        <p class="text-sm font-semibold uppercase tracking-wider text-indigo-600">
            Finance Management
        </p>
        <h2 class="mt-1 text-3xl font-bold text-slate-900">
            Edit Transaksi
        </h2>
        <p class="mt-2 text-slate-500">
            {{ $transaction->transaction_code }}
        </p>
    </div>

    <div class="mb-6 rounded-xl border border-amber-200 bg-amber-50 p-4 text-sm text-amber-800">
        Perubahan nominal, status, atau hubungan booking akan memperbarui perhitungan pembayaran booking terkait.
    </div>

    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">

        <form action="{{ route('transactions.update', $transaction) }}" method="POST">
            @csrf
            @method('PUT')

            @include('transactions._form')

        </form>

    </div>

</main>
</body>
</html>
