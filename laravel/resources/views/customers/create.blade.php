@extends('layouts.app')

@section('title', 'Tambah Pelanggan')
@section('breadcrumb', 'Customers & Clients')
@section('page-title', 'Tambah Pelanggan')

@section('content')
<a href="{{ route('customers.index') }}"
       class="text-sm font-semibold text-blue-600">
        ← Kembali ke daftar pelanggan
    </a>

    <div class="my-6">
        <h2 class="text-3xl font-bold text-slate-900">Tambah Pelanggan</h2>
        <p class="mt-2 text-slate-500">
            Masukkan informasi pelanggan atau klien baru.
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
        <form action="{{ route('customers.store') }}" method="POST">
            @csrf

            @php
                $customer = null;
                $submitLabel = 'Simpan Pelanggan';
            @endphp

            @include('customers._form')
        </form>
    </div>
@endsection
