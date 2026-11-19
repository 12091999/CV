@extends('layouts.app')

@section('title', 'Create Transaction')
@section('breadcrumb', 'Finance & Transactions')
@section('page-title', 'Create Transaction')

@section('content')
<div class="mb-8">
        <p class="text-sm font-semibold uppercase tracking-wider text-indigo-600">
            Finance Management
        </p>
        <h2 class="mt-1 text-3xl font-bold text-slate-900">
            Catat Transaksi Baru
        </h2>
        <p class="mt-2 text-slate-500">
            Catat pemasukan, pengeluaran, atau pembayaran booking pelanggan.
        </p>
    </div>

    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">

        <form action="{{ route('transactions.store') }}" method="POST">
            @csrf

            @include('transactions._form')

        </form>

    </div>
@endsection
