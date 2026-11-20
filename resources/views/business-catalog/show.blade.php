@extends('layouts.app')

@section('title', $businessUnit->name)
@section('breadcrumb', 'Business Units / ' . $businessUnit->name)
@section('page-title', $businessUnit->name)

@section('content')
<div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
    <div>
        <a href="{{ route('business-units.index') }}" class="popup-danger-hover text-sm font-semibold text-blue-300 transition">← Kembali ke Business Units</a>
        <p class="mt-5 text-sm font-semibold uppercase tracking-wider text-red-400">Katalog Layanan</p>
        <h1 class="mt-1 text-3xl font-bold text-white">{{ $businessUnit->name }}</h1>
        <p class="mt-2 max-w-2xl text-slate-400">{{ $businessUnit->description }}</p>
    </div>
    <div class="flex flex-wrap gap-3">
        <a href="{{ route('business-catalog.items.create', ['business_unit_id' => $businessUnit->id]) }}" class="inline-flex items-center justify-center rounded-xl bg-red-600 px-5 py-3 font-semibold text-white transition hover:bg-red-500">+ Tambah Katalog</a>
        <a href="{{ route('bookings.create', ['business_unit_id' => $businessUnit->id]) }}" class="inline-flex items-center justify-center rounded-xl bg-blue-600 px-5 py-3 font-semibold text-white transition hover:bg-blue-500">Pesan Layanan</a>
    </div>
</div>

@if(session('success'))
    <div class="mb-6 rounded-xl border border-green-500/30 bg-green-500/10 px-5 py-4 text-green-300">{{ session('success') }}</div>
@endif

<div class="mb-5 flex items-center justify-between">
    <div>
        <h2 class="text-xl font-bold text-white">Daftar Katalog</h2>
        <p class="mt-1 text-sm text-slate-400">Setiap item tersimpan khusus untuk {{ $businessUnit->name }}.</p>
    </div>
    <span class="rounded-full bg-slate-800 px-3 py-1 text-xs font-semibold text-slate-300">{{ $businessUnit->items->count() }} item</span>
</div>

<div class="grid gap-5 sm:grid-cols-2 xl:grid-cols-3">
    @forelse($businessUnit->items as $item)
        <article class="flex flex-col rounded-2xl border border-slate-800 bg-slate-900 p-6 shadow-lg transition hover:border-red-500/50">
            <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-xl bg-blue-500/15 text-2xl text-blue-300">♫</div>
            @if($item->category)
                <p class="mb-1 text-xs font-semibold uppercase tracking-wider text-red-400">{{ $item->category }}</p>
            @endif
            <div class="flex items-start justify-between gap-3">
                <h3 class="text-lg font-bold text-white">{{ $item->name }}</h3>
                @if(!$item->is_active)
                    <span class="shrink-0 rounded-full bg-red-500/10 px-2 py-1 text-[10px] font-semibold text-red-300">Nonaktif</span>
                @endif
            </div>
            <p class="mt-2 flex-1 text-sm leading-6 text-slate-400">{{ $item->description ?: 'Belum ada deskripsi.' }}</p>
            <div class="mt-5 border-t border-slate-800 pt-4">
                <p class="text-xs text-slate-500">Harga per {{ $item->unit_label }}</p>
                @if((float) $item->price > 0)
                    <p class="mt-1 text-xl font-bold text-white">Rp{{ number_format((float) $item->price, 0, ',', '.') }}</p>
                @else
                    <p class="mt-1 text-sm font-semibold text-amber-300">Harga dikonfirmasi saat pemesanan</p>
                @endif
                @if($item->is_active)
                    <a href="{{ route('bookings.create', ['business_unit_id' => $businessUnit->id, 'business_item_id' => $item->id]) }}" class="mt-4 inline-flex w-full items-center justify-center rounded-xl bg-blue-600 px-4 py-3 text-sm font-semibold text-white transition hover:bg-blue-500">Pesan Item Ini</a>
                @else
                    <div class="mt-4 rounded-xl bg-slate-800 px-4 py-3 text-center text-sm font-semibold text-slate-500">Katalog tidak aktif</div>
                @endif
                <div class="mt-3 flex gap-2">
                    <a href="{{ route('business-catalog.items.edit', $item) }}" class="popup-danger-hover flex-1 rounded-lg border border-slate-700 px-3 py-2 text-center text-xs font-semibold text-slate-300 transition hover:border-red-500 hover:bg-red-500/10">Edit Katalog</a>
                    <form action="{{ route('business-catalog.items.destroy', $item) }}" method="POST" class="flex-1" onsubmit="return confirm('Hapus katalog {{ addslashes($item->name) }}?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="popup-danger-hover w-full rounded-lg border border-slate-700 px-3 py-2 text-xs font-semibold text-slate-300 transition hover:border-red-500 hover:bg-red-500/10">Hapus</button>
                    </form>
                </div>
            </div>
        </article>
    @empty
        <div class="rounded-2xl border border-dashed border-slate-700 bg-slate-900/60 p-10 text-center sm:col-span-2 xl:col-span-3">
            <div class="mx-auto mb-3 flex h-12 w-12 items-center justify-center rounded-full bg-red-500/10 text-2xl text-red-400">+</div>
            <h3 class="font-semibold text-white">Belum ada katalog</h3>
            <p class="mt-2 text-sm text-slate-400">Tambahkan katalog pertama untuk {{ $businessUnit->name }}.</p>
            <a href="{{ route('business-catalog.items.create', ['business_unit_id' => $businessUnit->id]) }}" class="mt-5 inline-flex rounded-xl bg-red-600 px-5 py-3 text-sm font-semibold text-white transition hover:bg-red-500">+ Tambah Katalog Pertama</a>
        </div>
    @endforelse
</div>

<footer class="mt-10 text-center text-xs text-slate-500">© {{ date('Y') }} CV. Sigaproduction. All rights reserved.</footer>
@endsection
