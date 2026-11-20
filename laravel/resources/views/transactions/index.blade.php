@extends('layouts.app')

@section('title', 'Finance & Transactions')
@section('breadcrumb', 'Finance & Transactions')
@section('page-title', 'Finance & Transactions')

@section('content')
<div class="mb-8 flex flex-col justify-between gap-4 sm:flex-row sm:items-center">
        <div>
            <p class="text-sm font-semibold uppercase tracking-wider text-blue-600">
                Financial Management
            </p>
            <h2 class="mt-1 text-3xl font-bold text-slate-900">
                Finance & Transactions
            </h2>
            <p class="mt-2 text-slate-500">
                Kelola pemasukan, pengeluaran, dan pembayaran seluruh unit bisnis.
            </p>
        </div>

        <a href="{{ route('transactions.create') }}"
           class="rounded-xl bg-blue-600 px-5 py-3 text-center font-semibold text-white hover:bg-blue-700">
            + Catat Transaksi
        </a>
    </div>

    @if(session('success'))
        <div class="mb-6 rounded-xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-emerald-800">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="mb-6 rounded-xl border border-red-200 bg-red-50 px-5 py-4 text-red-700">
            <p class="font-semibold">Terjadi kesalahan:</p>
            <ul class="mt-2 list-inside list-disc text-sm">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Financial Summary --}}
    <div class="mb-8 grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">

        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="flex items-center justify-between">
                <p class="text-sm font-medium text-slate-500">Total Income</p>
                <span class="rounded-lg bg-emerald-100 px-3 py-2 text-emerald-700">↗</span>
            </div>
            <h3 class="mt-4 text-2xl font-bold text-emerald-600">
                Rp {{ number_format((float) $totalIncome, 0, ',', '.') }}
            </h3>
            <p class="mt-2 text-xs text-slate-400">Seluruh pemasukan selesai</p>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="flex items-center justify-between">
                <p class="text-sm font-medium text-slate-500">Total Expense</p>
                <span class="rounded-lg bg-red-100 px-3 py-2 text-red-700">↘</span>
            </div>
            <h3 class="mt-4 text-2xl font-bold text-red-600">
                Rp {{ number_format((float) $totalExpense, 0, ',', '.') }}
            </h3>
            <p class="mt-2 text-xs text-slate-400">Seluruh pengeluaran selesai</p>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="flex items-center justify-between">
                <p class="text-sm font-medium text-slate-500">Net Income</p>
                <span class="rounded-lg bg-blue-100 px-3 py-2 text-blue-700">◈</span>
            </div>
            <h3 class="mt-4 text-2xl font-bold {{ $netIncome >= 0 ? 'text-blue-600' : 'text-red-600' }}">
                Rp {{ number_format((float) $netIncome, 0, ',', '.') }}
            </h3>
            <p class="mt-2 text-xs text-slate-400">Income dikurangi expense</p>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="flex items-center justify-between">
                <p class="text-sm font-medium text-slate-500">Transactions</p>
                <span class="rounded-lg bg-amber-100 px-3 py-2 text-amber-700">▤</span>
            </div>
            <h3 class="mt-4 text-2xl font-bold text-slate-900">
                {{ $transactions->total() }}
            </h3>
            <p class="mt-2 text-xs text-slate-400">Jumlah sesuai filter</p>
        </div>

    </div>

    {{-- Transaction List --}}
    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

        <div class="border-b border-slate-200 p-6">
            <h3 class="text-lg font-bold text-slate-900">Transaction Records</h3>
            <p class="mt-1 text-sm text-slate-500">
                Riwayat seluruh transaksi keuangan SIGAPRODUCTION.
            </p>
        </div>

        {{-- Filters --}}
        <form action="{{ route('transactions.index') }}"
              method="GET"
              class="grid grid-cols-1 gap-4 border-b border-slate-200 bg-slate-50 p-6 md:grid-cols-2 lg:grid-cols-3">

            <div>
                <label class="mb-2 block text-sm font-medium">Cari transaksi</label>
                <input type="text"
                       name="search"
                       value="{{ request('search') }}"
                       placeholder="Kode, deskripsi, booking..."
                       class="w-full rounded-lg border border-slate-300 bg-white px-4 py-2.5 outline-none focus:border-blue-500">
            </div>

            <div>
                <label class="mb-2 block text-sm font-medium">Jenis transaksi</label>
                <select name="type"
                        class="w-full rounded-lg border border-slate-300 bg-white px-4 py-2.5">
                    <option value="">Semua jenis</option>
                    <option value="income" @selected(request('type') === 'income')>Income</option>
                    <option value="expense" @selected(request('type') === 'expense')>Expense</option>
                </select>
            </div>

            <div>
                <label class="mb-2 block text-sm font-medium">Unit bisnis</label>
                <select name="business_unit_id"
                        class="w-full rounded-lg border border-slate-300 bg-white px-4 py-2.5">
                    <option value="">Semua unit bisnis</option>
                    @foreach($businessUnits as $unit)
                        <option value="{{ $unit->id }}"
                            @selected((string) request('business_unit_id') === (string) $unit->id)>
                            {{ $unit->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="mb-2 block text-sm font-medium">Status</label>
                <select name="status"
                        class="w-full rounded-lg border border-slate-300 bg-white px-4 py-2.5">
                    <option value="">Semua status</option>
                    <option value="completed" @selected(request('status') === 'completed')>Completed</option>
                    <option value="voided" @selected(request('status') === 'voided')>Voided</option>
                </select>
            </div>

            <div>
                <label class="mb-2 block text-sm font-medium">Dari tanggal</label>
                <input type="date"
                       name="start_date"
                       value="{{ request('start_date') }}"
                       class="w-full rounded-lg border border-slate-300 bg-white px-4 py-2.5">
            </div>

            <div>
                <label class="mb-2 block text-sm font-medium">Sampai tanggal</label>
                <input type="date"
                       name="end_date"
                       value="{{ request('end_date') }}"
                       class="w-full rounded-lg border border-slate-300 bg-white px-4 py-2.5">
            </div>

            <div class="flex flex-wrap gap-2 md:col-span-2 lg:col-span-3">
                <button type="submit"
                        class="rounded-lg bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white hover:bg-blue-700">
                    Terapkan Filter
                </button>

                <a href="{{ route('transactions.index') }}"
                   class="rounded-lg border border-slate-300 bg-white px-5 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-100">
                    Reset
                </a>
            </div>
        </form>

        {{-- Table --}}
        <div class="overflow-x-auto">
            <table class="w-full min-w-[950px] text-left text-sm">
                <thead class="bg-slate-100 text-xs uppercase tracking-wider text-slate-500">
                    <tr>
                        <th class="px-6 py-4">Transaction</th>
                        <th class="px-6 py-4">Date</th>
                        <th class="px-6 py-4">Business Unit</th>
                        <th class="px-6 py-4">Category</th>
                        <th class="px-6 py-4">Type</th>
                        <th class="px-6 py-4 text-right">Amount</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-center">Action</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100">
                    @forelse($transactions as $transaction)
                        <tr class="hover:bg-slate-50">
                            <td class="px-6 py-4">
                                <p class="font-semibold text-slate-900">
                                    {{ $transaction->transaction_code }}
                                </p>
                                <p class="mt-1 max-w-xs truncate text-xs text-slate-500">
                                    {{ $transaction->description }}
                                </p>
                                @if($transaction->booking)
                                    <p class="mt-1 text-xs text-blue-600">
                                        {{ $transaction->booking->booking_code }}
                                    </p>
                                @endif
                            </td>

                            <td class="whitespace-nowrap px-6 py-4 text-slate-600">
                                {{ $transaction->transaction_date->format('d M Y') }}
                            </td>

                            <td class="px-6 py-4 text-slate-600">
                                {{ $transaction->businessUnit->name }}
                            </td>

                            <td class="px-6 py-4 text-slate-600">
                                {{ $transaction->category }}
                            </td>

                            <td class="px-6 py-4">
                                @if($transaction->type === 'income')
                                    <span class="rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700">
                                        Income
                                    </span>
                                @else
                                    <span class="rounded-full bg-red-100 px-3 py-1 text-xs font-semibold text-red-700">
                                        Expense
                                    </span>
                                @endif
                            </td>

                            <td class="whitespace-nowrap px-6 py-4 text-right font-semibold {{ $transaction->type === 'income' ? 'text-emerald-600' : 'text-red-600' }}">
                                {{ $transaction->type === 'income' ? '+' : '-' }}
                                Rp {{ number_format((float) $transaction->amount, 0, ',', '.') }}
                            </td>

                            <td class="px-6 py-4">
                                @if($transaction->status === 'completed')
                                    <span class="rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700">
                                        Completed
                                    </span>
                                @else
                                    <span class="rounded-full bg-slate-200 px-3 py-1 text-xs font-semibold text-slate-600">
                                        Voided
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
                            <td colspan="8" class="px-6 py-16 text-center">
                                <p class="font-semibold text-slate-700">Belum ada transaksi</p>
                                <p class="mt-2 text-sm text-slate-500">
                                    Catat pemasukan atau pengeluaran pertama perusahaan.
                                </p>
                                <a href="{{ route('transactions.create') }}"
                                   class="mt-4 inline-block font-semibold text-blue-600">
                                    + Tambah transaksi
                                </a>
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
