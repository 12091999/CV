@extends('layouts.app')

@section('title', 'Riwayat Transaksi')
@section('breadcrumb', 'Riwayat Transaksi')
@section('page-title', 'Riwayat Transaksi')

@section('content')
    <div class="mb-8 flex flex-col justify-between gap-4 sm:flex-row sm:items-end">
        <div>
            <p class="text-sm font-semibold uppercase tracking-wider text-blue-600">
                Finance & Transactions
            </p>
            <h2 class="mt-1 text-3xl font-bold text-slate-900">
                Riwayat Bulanan
            </h2>
            <p class="mt-2 text-slate-500">
                Arsip transaksi untuk {{ $monthLabel }}.
            </p>
        </div>

        <form action="{{ route('transactions.history') }}" method="GET" class="flex flex-wrap items-end gap-3">
            <div>
                <label for="month" class="mb-2 block text-sm font-medium">Pilih bulan</label>
                <input id="month"
                       type="month"
                       name="month"
                       value="{{ $month }}"
                       class="rounded-lg border border-slate-300 bg-white px-4 py-2.5">
            </div>
            <button type="submit"
                    class="rounded-lg bg-blue-600 px-5 py-2.5 font-semibold text-white hover:bg-blue-700">
                Tampilkan
            </button>
        </form>
    </div>

    <div class="mb-8 grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-sm font-medium text-slate-500">Total Pemasukan</p>
            <h3 class="mt-4 text-2xl font-bold text-emerald-600">
                Rp {{ number_format((float) $totalIncome, 0, ',', '.') }}
            </h3>
            <p class="mt-2 text-xs text-slate-400">Transaksi selesai pada bulan terpilih</p>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-sm font-medium text-slate-500">Total Pengeluaran</p>
            <h3 class="mt-4 text-2xl font-bold text-red-600">
                Rp {{ number_format((float) $totalExpense, 0, ',', '.') }}
            </h3>
            <p class="mt-2 text-xs text-slate-400">Transaksi selesai pada bulan terpilih</p>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-sm font-medium text-slate-500">Pendapatan Bersih</p>
            <h3 class="mt-4 text-2xl font-bold {{ $netIncome >= 0 ? 'text-blue-600' : 'text-red-600' }}">
                Rp {{ number_format((float) $netIncome, 0, ',', '.') }}
            </h3>
            <p class="mt-2 text-xs text-slate-400">Pemasukan dikurangi pengeluaran</p>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-sm font-medium text-slate-500">Jumlah Transaksi</p>
            <h3 class="mt-4 text-2xl font-bold text-slate-900">{{ $transactions->total() }}</h3>
            <p class="mt-2 text-xs text-slate-400">Termasuk transaksi dibatalkan</p>
        </div>
    </div>

    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
        <div class="border-b border-slate-200 p-6">
            <h3 class="text-lg font-bold text-slate-900">Transaksi {{ $monthLabel }}</h3>
            <p class="mt-1 text-sm text-slate-500">
                Riwayat transaksi berdasarkan tanggal transaksi pada bulan yang dipilih.
            </p>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full min-w-[850px] text-left text-sm">
                <thead class="bg-slate-100 text-xs uppercase tracking-wider text-slate-500">
                    <tr>
                        <th class="px-6 py-4">Transaksi</th>
                        <th class="px-6 py-4">Tanggal</th>
                        <th class="px-6 py-4">Unit Bisnis</th>
                        <th class="px-6 py-4">Jenis</th>
                        <th class="px-6 py-4 text-right">Jumlah</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($transactions as $transaction)
                        <tr class="hover:bg-slate-50">
                            <td class="px-6 py-4">
                                <p class="font-semibold text-slate-900">{{ $transaction->transaction_code }}</p>
                                <p class="mt-1 max-w-xs truncate text-xs text-slate-500">
                                    {{ $transaction->description }}
                                </p>
                            </td>
                            <td class="whitespace-nowrap px-6 py-4 text-slate-600">
                                {{ $transaction->transaction_date->format('d M Y') }}
                            </td>
                            <td class="px-6 py-4 text-slate-600">{{ $transaction->businessUnit->name }}</td>
                            <td class="px-6 py-4">
                                <span class="rounded-full px-3 py-1 text-xs font-semibold {{ $transaction->type === 'income' ? 'bg-emerald-100 text-emerald-700' : 'bg-red-100 text-red-700' }}">
                                    {{ $transaction->type === 'income' ? 'Pemasukan' : 'Pengeluaran' }}
                                </span>
                            </td>
                            <td class="whitespace-nowrap px-6 py-4 text-right font-semibold {{ $transaction->type === 'income' ? 'text-emerald-600' : 'text-red-600' }}">
                                {{ $transaction->type === 'income' ? '+' : '-' }}
                                Rp {{ number_format((float) $transaction->amount, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4">
                                @if($transaction->status === 'completed')
                                    <span class="rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700">
                                        Selesai
                                    </span>
                                @else
                                    <span class="rounded-full bg-slate-200 px-3 py-1 text-xs font-semibold text-slate-600">
                                        Dibatalkan
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center">
                                <a href="{{ route('transactions.show', $transaction) }}"
                                   class="font-semibold text-blue-600 hover:text-blue-800">
                                    Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-16 text-center">
                                <p class="font-semibold text-slate-700">Belum ada transaksi</p>
                                <p class="mt-2 text-sm text-slate-500">
                                    Tidak ada transaksi pada {{ $monthLabel }}.
                                </p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="border-t border-slate-200 p-6">
            {{ $transactions->links() }}
        </div>
    </div>
@endsection
