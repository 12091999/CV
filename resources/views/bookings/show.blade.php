<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pesanan | SIGAPRODUCTION</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-50 text-slate-800">

<header class="bg-slate-950 text-white">
    <div class="mx-auto max-w-5xl px-6 py-5">
        <h1 class="text-xl font-bold">SIGAPRODUCTION</h1>
        <p class="text-sm text-slate-400">Bookings & Orders Management</p>
    </div>
</header>

@php
    $total = (float) $booking->total_amount;
    $paid = (float) $booking->amount_paid;
    $remaining = max(0, $total - $paid);

    $bookingStyles = [
        'pending' => 'bg-amber-100 text-amber-700',
        'confirmed' => 'bg-blue-100 text-blue-700',
        'in_progress' => 'bg-violet-100 text-violet-700',
        'completed' => 'bg-green-100 text-green-700',
        'cancelled' => 'bg-red-100 text-red-700',
    ];

    $paymentStyles = [
        'unpaid' => 'bg-red-100 text-red-700',
        'partial' => 'bg-amber-100 text-amber-700',
        'paid' => 'bg-green-100 text-green-700',
    ];

    $paymentPercentage = $total > 0
        ? min(100, ($paid / $total) * 100)
        : 0;
@endphp

<main class="mx-auto max-w-5xl px-6 py-10">

    <a href="{{ route('bookings.index') }}"
       class="text-sm font-semibold text-indigo-600 hover:text-indigo-800">
        ← Kembali ke daftar pesanan
    </a>

    <div class="my-6 flex flex-col justify-between gap-4 sm:flex-row sm:items-center">
        <div>
            <p class="text-sm font-semibold uppercase tracking-wider text-indigo-600">
                Order Details
            </p>
            <h2 class="mt-1 text-3xl font-bold text-slate-900">
                Detail Pesanan
            </h2>
            <p class="mt-2 text-slate-500">
                Informasi lengkap transaksi SIGAPRODUCTION.
            </p>
        </div>

        <a href="{{ route('bookings.edit', $booking) }}"
           class="rounded-xl bg-indigo-600 px-5 py-3 text-center font-semibold text-white hover:bg-indigo-700">
            Edit Pesanan
        </a>
    </div>

    <div class="mb-6 rounded-2xl bg-slate-950 p-6 text-white shadow-sm sm:p-8">
        <p class="text-sm text-slate-400">Booking Code</p>
        <h3 class="mt-2 text-2xl font-bold tracking-wide">
            {{ $booking->booking_code }}
        </h3>

        <p class="mt-4 text-lg font-semibold">{{ $booking->title }}</p>

        <div class="mt-5 flex flex-wrap gap-2">
            <span class="rounded-full px-3 py-1 text-xs font-semibold {{ $bookingStyles[$booking->booking_status] ?? 'bg-slate-700 text-white' }}">
                {{ str($booking->booking_status)->replace('_', ' ')->title() }}
            </span>

            <span class="rounded-full px-3 py-1 text-xs font-semibold {{ $paymentStyles[$booking->payment_status] ?? 'bg-slate-700 text-white' }}">
                Payment: {{ str($booking->payment_status)->title() }}
            </span>
        </div>
    </div>

    <div class="mb-6 grid gap-4 sm:grid-cols-3">

        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <p class="text-sm text-slate-500">Total Pesanan</p>
            <p class="mt-2 text-xl font-bold text-slate-900">
                Rp{{ number_format($total, 0, ',', '.') }}
            </p>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <p class="text-sm text-slate-500">Pembayaran Diterima</p>
            <p class="mt-2 text-xl font-bold text-green-600">
                Rp{{ number_format($paid, 0, ',', '.') }}
            </p>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <p class="text-sm text-slate-500">Sisa Tagihan</p>
            <p class="mt-2 text-xl font-bold text-red-600">
                Rp{{ number_format($remaining, 0, ',', '.') }}
            </p>
        </div>

    </div>

    <div class="mb-6 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
        <div class="mb-3 flex items-center justify-between">
            <h3 class="font-bold text-slate-900">Progres Pembayaran</h3>
            <span class="text-sm font-bold text-indigo-600">
                {{ number_format($paymentPercentage, 1) }}%
            </span>
        </div>

        <div class="h-3 overflow-hidden rounded-full bg-slate-100">
            <div class="h-full rounded-full bg-indigo-600"
                 style="width: {{ $paymentPercentage }}%">
            </div>
        </div>

        <div class="mt-3 flex justify-between text-xs text-slate-500">
            <span>Rp{{ number_format($paid, 0, ',', '.') }} dibayar</span>
            <span>Rp{{ number_format($total, 0, ',', '.') }} total</span>
        </div>
    </div>

    <div class="grid gap-6 md:grid-cols-2">

        <section class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <h3 class="mb-5 border-b border-slate-200 pb-3 font-bold text-slate-900">
                Informasi Pelanggan
            </h3>

            <div class="space-y-4">
                <div>
                    <p class="text-sm text-slate-500">Nama Pelanggan</p>
                    <p class="mt-1 font-semibold">{{ $booking->customer->name }}</p>
                </div>

                <div>
                    <p class="text-sm text-slate-500">Perusahaan</p>
                    <p class="mt-1 font-semibold">
                        {{ $booking->customer->company_name ?: '-' }}
                    </p>
                </div>

                <div>
                    <p class="text-sm text-slate-500">Email</p>
                    <p class="mt-1 font-semibold">
                        {{ $booking->customer->email ?: '-' }}
                    </p>
                </div>

                <div>
                    <p class="text-sm text-slate-500">Telepon</p>
                    <p class="mt-1 font-semibold">
                        {{ $booking->customer->phone ?: '-' }}
                    </p>
                </div>

                <div>
                    <p class="text-sm text-slate-500">Alamat Pelanggan</p>
                    <p class="mt-1 whitespace-pre-line font-semibold">
                        {{ $booking->customer->address ?: '-' }}
                    </p>
                </div>

                <a href="{{ route('customers.show', $booking->customer) }}"
                   class="inline-block text-sm font-semibold text-indigo-600 hover:underline">
                    Lihat profil pelanggan →
                </a>
            </div>
        </section>

        <section class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <h3 class="mb-5 border-b border-slate-200 pb-3 font-bold text-slate-900">
                Informasi Unit Bisnis
            </h3>

            <div class="space-y-4">
                <div>
                    <p class="text-sm text-slate-500">Unit Bisnis</p>
                    <p class="mt-1 font-semibold">
                        {{ $booking->businessUnit->name }}
                    </p>
                </div>

                <div>
                    <p class="text-sm text-slate-500">Deskripsi Unit</p>
                    <p class="mt-1 whitespace-pre-line font-semibold">
                        {{ $booking->businessUnit->description ?: '-' }}
                    </p>
                </div>

                <a href="{{ route('business-units.index') }}"
                   class="inline-block text-sm font-semibold text-indigo-600 hover:underline">
                    Lihat seluruh unit bisnis →
                </a>
            </div>
        </section>

    </div>

    <section class="mt-6 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
        <h3 class="mb-5 border-b border-slate-200 pb-3 font-bold text-slate-900">
            Rincian Pesanan
        </h3>

        <div class="grid gap-5 sm:grid-cols-2">

            <div>
                <p class="text-sm text-slate-500">Nama Pesanan</p>
                <p class="mt-1 font-semibold">{{ $booking->title }}</p>
            </div>

            <div>
                <p class="text-sm text-slate-500">Tanggal Pelaksanaan</p>
                <p class="mt-1 font-semibold">
                    {{ $booking->event_date?->format('d F Y') ?? '-' }}
                </p>
            </div>

            <div>
                <p class="text-sm text-slate-500">Lokasi</p>
                <p class="mt-1 font-semibold">{{ $booking->location ?: '-' }}</p>
            </div>

            <div>
                <p class="text-sm text-slate-500">Jumlah</p>
                <p class="mt-1 font-semibold">
                    {{ number_format($booking->quantity) }}
                </p>
            </div>

            <div>
                <p class="text-sm text-slate-500">Harga Satuan</p>
                <p class="mt-1 font-semibold">
                    Rp{{ number_format((float) $booking->unit_price, 0, ',', '.') }}
                </p>
            </div>

            <div>
                <p class="text-sm text-slate-500">Total</p>
                <p class="mt-1 font-bold text-indigo-600">
                    Rp{{ number_format($total, 0, ',', '.') }}
                </p>
            </div>

            <div class="sm:col-span-2">
                <p class="text-sm text-slate-500">Deskripsi</p>
                <p class="mt-1 whitespace-pre-line font-medium">
                    {{ $booking->description ?: '-' }}
                </p>
            </div>

            <div class="sm:col-span-2">
                <p class="text-sm text-slate-500">Catatan Internal</p>
                <p class="mt-1 whitespace-pre-line font-medium">
                    {{ $booking->notes ?: '-' }}
                </p>
            </div>

        </div>
    </section>

    <section class="mt-6 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
        <h3 class="mb-5 border-b border-slate-200 pb-3 font-bold text-slate-900">
            Informasi Sistem
        </h3>

        <div class="grid gap-4 sm:grid-cols-2">
            <div>
                <p class="text-sm text-slate-500">Dibuat</p>
                <p class="mt-1 font-semibold">
                    {{ $booking->created_at->format('d-m-Y H:i') }}
                </p>
            </div>

            <div>
                <p class="text-sm text-slate-500">Terakhir Diperbarui</p>
                <p class="mt-1 font-semibold">
                    {{ $booking->updated_at->format('d-m-Y H:i') }}
                </p>
            </div>
        </div>

        <div class="mt-6 border-t border-slate-200 pt-5">
            <form action="{{ route('bookings.destroy', $booking) }}"
                  method="POST"
                  onsubmit="return confirm('Yakin ingin menghapus pesanan ini?')">
                @csrf
                @method('DELETE')

                <button type="submit"
                        class="rounded-xl bg-red-50 px-5 py-3 font-semibold text-red-700 hover:bg-red-100">
                    Hapus Pesanan
                </button>
            </form>
        </div>
    </section>

</main>
</body>
</html>
