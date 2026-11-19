@extends('layouts.app')

@section('title', 'Transaction Detail')
@section('breadcrumb', 'Finance & Transactions')
@section('page-title', 'Transaction Detail')

@section('content')
@if(session('success'))
        <div class="mb-6 rounded-xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-emerald-800">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="mb-6 rounded-xl border border-red-200 bg-red-50 p-4 text-red-700">
            @foreach($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <div class="mb-8 flex flex-col justify-between gap-4 sm:flex-row sm:items-center">
        <div>
            <p class="text-sm font-semibold uppercase tracking-wider text-blue-600">
                Transaction Detail
            </p>
            <h2 class="mt-1 text-3xl font-bold text-slate-900">
                Detail Transaksi
            </h2>
            <p class="mt-2 text-slate-500">
                {{ $transaction->transaction_code }}
            </p>
        </div>

        <div class="flex flex-wrap gap-2">
            @if($transaction->status === 'completed')
                <a href="{{ route('transactions.edit', $transaction) }}"
                   class="rounded-xl bg-blue-600 px-5 py-3 text-sm font-semibold text-white hover:bg-blue-700">
                    Edit Transaksi
                </a>

                <form action="{{ route('transactions.destroy', $transaction) }}"
                      method="POST"
                      onsubmit="return confirm('Batalkan transaksi ini? Pembayaran booking terkait akan dihitung ulang.')">
                    @csrf
                    @method('DELETE')

                    <button type="submit"
                            class="rounded-xl border border-red-200 bg-white px-5 py-3 text-sm font-semibold text-red-600 hover:bg-red-50">
                        Batalkan
                    </button>
                </form>
            @endif
        </div>
    </div>

    {{-- Amount --}}
    <div class="mb-6 rounded-2xl border border-slate-200 bg-white p-8 shadow-sm">
        <p class="text-sm font-medium text-slate-500">Transaction Amount</p>

        <h3 class="mt-3 text-3xl font-bold {{ $transaction->type === 'income' ? 'text-emerald-600' : 'text-red-600' }}">
            {{ $transaction->type === 'income' ? '+' : '-' }}
            Rp {{ number_format((float) $transaction->amount, 0, ',', '.') }}
        </h3>

        <div class="mt-5 flex flex-wrap items-center gap-3">
            @if($transaction->type === 'income')
                <span class="rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700">
                    Income
                </span>
            @else
                <span class="rounded-full bg-red-100 px-3 py-1 text-xs font-semibold text-red-700">
                    Expense
                </span>
            @endif

            @if($transaction->status === 'completed')
                <span class="rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700">
                    Completed
                </span>
            @else
                <span class="rounded-full bg-slate-200 px-3 py-1 text-xs font-semibold text-slate-600">
                    Voided
                </span>
            @endif
        </div>
    </div>

    {{-- Information --}}
    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">

        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <h3 class="mb-5 text-lg font-bold text-slate-900">
                Informasi Transaksi
            </h3>

            <dl class="space-y-4 text-sm">
                <div>
                    <dt class="text-slate-500">Kode Transaksi</dt>
                    <dd class="mt-1 font-semibold">{{ $transaction->transaction_code }}</dd>
                </div>

                <div>
                    <dt class="text-slate-500">Deskripsi</dt>
                    <dd class="mt-1 font-semibold">{{ $transaction->description }}</dd>
                </div>

                <div>
                    <dt class="text-slate-500">Kategori</dt>
                    <dd class="mt-1 font-semibold">{{ $transaction->category }}</dd>
                </div>

                <div>
                    <dt class="text-slate-500">Unit Bisnis</dt>
                    <dd class="mt-1 font-semibold">{{ $transaction->businessUnit->name }}</dd>
                </div>

                <div>
                    <dt class="text-slate-500">Tanggal Transaksi</dt>
                    <dd class="mt-1 font-semibold">
                        {{ $transaction->transaction_date->format('d F Y') }}
                    </dd>
                </div>

                <div>
                    <dt class="text-slate-500">Metode Pembayaran</dt>
                    <dd class="mt-1 font-semibold">
                        {{ $transaction->payment_method
                            ? ucwords(str_replace('_', ' ', $transaction->payment_method))
                            : '-' }}
                    </dd>
                </div>

                <div>
                    <dt class="text-slate-500">Nomor Referensi</dt>
                    <dd class="mt-1 font-semibold">
                        {{ $transaction->reference_number ?: '-' }}
                    </dd>
                </div>

                <div>
                    <dt class="text-slate-500">Dicatat Oleh</dt>
                    <dd class="mt-1 font-semibold">
                        {{ $transaction->recorder?->name ?? 'User tidak tersedia' }}
                    </dd>
                </div>
            </dl>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <h3 class="mb-5 text-lg font-bold text-slate-900">
                Informasi Booking
            </h3>

            @if($transaction->booking)
                <dl class="space-y-4 text-sm">
                    <div>
                        <dt class="text-slate-500">Kode Booking</dt>
                        <dd class="mt-1 font-semibold">
                            {{ $transaction->booking->booking_code }}
                        </dd>
                    </div>

                    <div>
                        <dt class="text-slate-500">Nama Pesanan</dt>
                        <dd class="mt-1 font-semibold">
                            {{ $transaction->booking->title }}
                        </dd>
                    </div>

                    <div>
                        <dt class="text-slate-500">Pelanggan</dt>
                        <dd class="mt-1 font-semibold">
                            {{ $transaction->booking->customer->name }}
                        </dd>
                    </div>

                    <div>
                        <dt class="text-slate-500">Total Tagihan</dt>
                        <dd class="mt-1 font-semibold">
                            Rp {{ number_format((float) $transaction->booking->total_amount, 0, ',', '.') }}
                        </dd>
                    </div>

                    <div>
                        <dt class="text-slate-500">Total Dibayar</dt>
                        <dd class="mt-1 font-semibold text-emerald-600">
                            Rp {{ number_format((float) $transaction->booking->amount_paid, 0, ',', '.') }}
                        </dd>
                    </div>

                    <div>
                        <dt class="text-slate-500">Status Pembayaran Booking</dt>
                        <dd class="mt-1 font-semibold">
                            {{ ucfirst($transaction->booking->payment_status) }}
                        </dd>
                    </div>

                    <div>
                        <dt class="text-slate-500">Sisa Tagihan</dt>
                        <dd class="mt-1 font-semibold text-amber-600">
                            Rp {{ number_format(max(0, (float) $transaction->booking->total_amount - (float) $transaction->booking->amount_paid), 0, ',', '.') }}
                        </dd>
                    </div>
                </dl>
            @else
                <div class="rounded-xl bg-slate-50 p-5 text-sm text-slate-500">
                    Transaksi ini tidak terhubung dengan booking pelanggan.
                    <p class="mt-2">
                        Transaksi ini dapat berupa pendapatan non-booking atau biaya operasional.
                    </p>
                </div>
            @endif
        </div>

    </div>

    @if($transaction->notes)
        <div class="mt-6 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <h3 class="font-bold text-slate-900">Catatan Tambahan</h3>
            <p class="mt-3 whitespace-pre-line text-sm text-slate-600">
                {{ $transaction->notes }}
            </p>
        </div>
    @endif

    <p class="mt-6 text-xs text-slate-400">
        Dibuat {{ $transaction->created_at->format('d M Y H:i') }}
        · Diperbarui {{ $transaction->updated_at->format('d M Y H:i') }}
    </p>
@endsection
