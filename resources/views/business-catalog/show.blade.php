@extends('layouts.app')

@section('title', $businessUnit->name)
@section('breadcrumb', 'Business Units / ' . $businessUnit->name)
@section('page-title', $businessUnit->name)

@section('content')
<div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
    <div>
        <a href="{{ route('business-units.index') }}" class="text-sm font-semibold text-indigo-600 hover:text-indigo-800">← Kembali ke Business Units</a>
        <p class="mt-5 text-sm font-semibold uppercase tracking-wider text-orange-600">Katalog Layanan</p>
        <h1 class="mt-1 text-3xl font-bold text-slate-900">{{ $businessUnit->name }}</h1>
        <p class="mt-2 max-w-2xl text-slate-500">{{ $businessUnit->description }}</p>
    </div>
    <a href="{{ route('bookings.create', ['business_unit_id' => $businessUnit->id]) }}" class="inline-flex items-center justify-center rounded-xl bg-orange-500 px-5 py-3 font-semibold text-white hover:bg-orange-600">Pesan Layanan</a>
</div>

@if(session('success'))
    <div class="mb-6 rounded-xl border border-green-200 bg-green-50 px-5 py-4 text-green-700">{{ session('success') }}</div>
@endif

<div class="mb-5 flex items-center justify-between">
    <div>
        <h2 class="text-xl font-bold text-slate-900">Daftar Item</h2>
        <p class="mt-1 text-sm text-slate-500">Pilih item yang sesuai dengan kebutuhan Anda.</p>
    </div>
    <span class="rounded-full bg-slate-200 px-3 py-1 text-xs font-semibold text-slate-600">{{ $businessUnit->items->count() }} item</span>
</div>

<div class="grid gap-5 sm:grid-cols-2 xl:grid-cols-3">
    @forelse($businessUnit->items as $item)
        <article class="flex flex-col rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-xl bg-orange-100 text-2xl text-orange-600">♫</div>
            <h3 class="text-lg font-bold text-slate-900">{{ $item->name }}</h3>
            <p class="mt-2 flex-1 text-sm leading-6 text-slate-500">{{ $item->description }}</p>
            <div class="mt-5 border-t border-slate-100 pt-4">
                <p class="text-xs text-slate-400">Harga per {{ $item->unit_label }}</p>
                @if((float) $item->price > 0)
                    <p class="mt-1 text-xl font-bold text-slate-900">Rp{{ number_format((float) $item->price, 0, ',', '.') }}</p>
                @else
                    <p class="mt-1 text-sm font-semibold text-amber-600">Harga dikonfirmasi saat pemesanan</p>
                @endif
                <a href="{{ route('bookings.create', ['business_unit_id' => $businessUnit->id, 'business_item_id' => $item->id]) }}" class="mt-4 inline-flex w-full items-center justify-center rounded-xl bg-orange-500 px-4 py-3 text-sm font-semibold text-white hover:bg-orange-600">Pesan Item Ini</a>
            </div>
        </article>
    @empty
        <div class="rounded-2xl border border-dashed border-slate-300 bg-white p-10 text-center sm:col-span-2 xl:col-span-3">
            <h3 class="font-semibold text-slate-800">Belum ada item katalog</h3>
            <p class="mt-2 text-sm text-slate-500">Item untuk unit bisnis ini belum ditambahkan.</p>
        </div>
    @endforelse
</div>

<footer class="mt-10 text-center text-xs text-slate-400">© {{ date('Y') }} CV. Sigaproduction. All rights reserved.</footer>
@endsection
