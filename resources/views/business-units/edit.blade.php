@extends('layouts.app')

@section('title', 'Edit Unit Bisnis')
@section('breadcrumb', 'Business Units')
@section('page-title', 'Edit Unit Bisnis')

@section('content')
<div class="mb-8">
            <a href="{{ route('business-units.index') }}"
               class="text-sm font-semibold text-blue-600 hover:text-blue-800">
                ← Kembali ke daftar unit bisnis
            </a>

            <h2 class="mt-5 text-3xl font-bold text-slate-900">
                Edit Unit Bisnis
            </h2>

            <p class="mt-2 text-slate-500">
                Perbarui informasi {{ $businessUnit->name }}.
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
            <form action="{{ route('business-units.update', $businessUnit) }}" method="POST">
                @csrf
                @method('PUT')

                @php
                    $submitLabel = 'Simpan Perubahan';
                @endphp

                @include('business-units._form')
            </form>
        </div>
@endsection
