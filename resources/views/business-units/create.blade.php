@extends('layouts.app')

@section('title', 'Tambah Unit Bisnis')
@section('breadcrumb', 'Business Units')
@section('page-title', 'Tambah Unit Bisnis')

@section('content')
<div class="mb-8">
            <a href="{{ route('business-units.index') }}"
               class="text-sm font-semibold text-indigo-600 hover:text-indigo-800">
                ← Kembali ke daftar unit bisnis
            </a>

            <h2 class="mt-5 text-3xl font-bold text-slate-900">
                Tambah Unit Bisnis
            </h2>

            <p class="mt-2 text-slate-500">
                Masukkan informasi unit bisnis baru CV. Sigaproduction.
            </p>
        </div>

        @if($errors->any())
            <div class="mb-6 rounded-xl border border-red-200 bg-red-50 p-4 text-sm text-red-700">
                <p class="mb-2 font-semibold">Periksa kembali data berikut:</p>
                <ul class="list-inside list-disc">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
            <form action="{{ route('business-units.store') }}" method="POST">
                @csrf

                @php
                    $businessUnit = null;
                    $submitLabel = 'Simpan Unit Bisnis';
                @endphp

                @include('business-units._form')
            </form>
        </div>
@endsection
