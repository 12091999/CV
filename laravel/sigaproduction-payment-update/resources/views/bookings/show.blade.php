@extends('layouts.app')

@section('title', 'Detail Pesanan')
@section('breadcrumb', 'Bookings & Orders')
@section('page-title', 'Detail Pesanan')

@section('content')
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
            <p class="text-sm text-slate-500">Total Pesanan (Tagihan)</p>
            <p class="mt-2 text-xl font-bold text-slate-900">
                Rp{{ number_format($total, 0, ',', '.') }}
            </p>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <p class="text-sm text-slate-500">Pembayaran Diterima (Cash / Transfer)</p>
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

    <section class="mb-6 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
        <div class="mb-5 flex flex-col gap-3 border-b border-slate-200 pb-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h3 class="font-bold text-slate-900">Riwayat Pembayaran</h3>
                <p class="mt-1 text-sm text-slate-500">Pembayaran yang diterima melalui Cash atau Transfer.</p>
            </div>
            @if($remaining > 0 && $booking->booking_status !== 'cancelled')
                <a href="{{ route('transactions.create', ['booking_id' => $booking->id]) }}"
                   class="rounded-xl bg-green-600 px-4 py-2.5 text-center text-sm font-semibold text-white hover:bg-green-700">
                    + Catat Pembayaran
                </a>
            @endif
        </div>

        @if($booking->transactions->isEmpty())
            <p class="rounded-xl bg-slate-50 p-4 text-sm text-slate-500">Belum ada pembayaran yang tercatat.</p>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full text-left text-sm">
                    <thead class="border-b border-slate-200 text-xs uppercase tracking-wide text-slate-500">
                        <tr>
                            <th class="px-3 py-3">Tanggal</th>
                            <th class="px-3 py-3">Kode Transaksi</th>
                            <th class="px-3 py-3">Metode</th>
                            <th class="px-3 py-3 text-right">Nominal Diterima</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($booking->transactions as $payment)
                            <tr>
                                <td class="px-3 py-3">{{ $payment->transaction_date?->format('d-m-Y') ?? '-' }}</td>
                                <td class="px-3 py-3 font-medium">{{ $payment->transaction_code }}</td>
                                <td class="px-3 py-3">{{ $payment->payment_method === 'transfer' ? 'Transfer' : 'Cash' }}</td>
                                <td class="px-3 py-3 text-right font-semibold text-green-700">Rp{{ number_format((float) $payment->amount, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </section>

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
@endsection
