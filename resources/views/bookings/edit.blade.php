@extends('layouts.app')

@section('title', 'Edit Pesanan')
@section('breadcrumb', 'Bookings & Orders')
@section('page-title', 'Edit Pesanan')

@section('content')
<a href="{{ route('bookings.index') }}"
       class="text-sm font-semibold text-indigo-600 hover:text-indigo-800">
        ← Kembali ke daftar pesanan
    </a>

    <div class="my-6">
        <p class="text-sm font-semibold uppercase tracking-wider text-indigo-600">
            Update Transaction
        </p>
        <h2 class="mt-1 text-3xl font-bold text-slate-900">Edit Pesanan</h2>
        <p class="mt-2 text-slate-500">
            Perbarui informasi pesanan {{ $booking->booking_code }}.
        </p>
    </div>

    <div class="mb-6 rounded-xl border border-indigo-100 bg-indigo-50 p-4">
        <p class="text-sm text-indigo-700">Kode Pesanan</p>
        <p class="mt-1 text-lg font-bold text-indigo-900">
            {{ $booking->booking_code }}
        </p>
        <p class="mt-1 text-xs text-indigo-700">
            Kode pesanan dibuat otomatis dan tidak dapat diubah.
        </p>
    </div>

    @if($errors->any())
        <div class="mb-6 rounded-xl border border-red-200 bg-red-50 p-5 text-red-700">
            <p class="font-semibold">Perubahan belum dapat disimpan.</p>
            <ul class="mt-2 list-inside list-disc text-sm">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
        <form action="{{ route('bookings.update', $booking) }}" method="POST">
            @csrf
            @method('PUT')

            @php
                $submitLabel = 'Simpan Perubahan';
            @endphp

            @include('bookings._form')
        </form>
    </div>
@endsection
