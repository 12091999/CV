@extends('layouts.app')

@section('title', 'Edit Transaction')
@section('breadcrumb', 'Finance & Transactions')
@section('page-title', 'Edit Transaction')

@section('content')
<div class="mb-8">
        <p class="text-sm font-semibold uppercase tracking-wider text-blue-600">
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
@endsection
