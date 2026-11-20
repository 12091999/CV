@extends('layouts.app')

@section('title', 'Tambah Katalog')
@section('breadcrumb', 'Business Units / Tambah Katalog')
@section('page-title', 'Tambah Katalog')

@section('content')
<div class="mx-auto max-w-3xl">
    <div class="mb-7">
        <p class="text-sm font-semibold uppercase tracking-wider text-red-400">Catalog Management</p>
        <h1 class="mt-1 text-3xl font-bold text-white">Tambah Katalog Baru</h1>
        <p class="mt-2 text-slate-400">Pilih unit bisnis tujuan. Katalog akan tersimpan khusus pada unit bisnis tersebut.</p>
    </div>

    @if($errors->any())
        <div class="mb-6 rounded-xl border border-red-500/40 bg-red-500/10 px-5 py-4 text-red-300">
            <p class="font-semibold">Periksa kembali data yang dimasukkan.</p>
            <ul class="mt-2 list-inside list-disc text-sm">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div>
    @endif

    <form method="POST" action="{{ route('business-catalog.items.store') }}" class="rounded-2xl border border-slate-800 bg-slate-900/90 p-6 shadow-xl sm:p-8">
        @csrf
        @include('business-catalog._form', ['submitLabel' => 'Simpan Katalog'])
    </form>
</div>
@endsection
