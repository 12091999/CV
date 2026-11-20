@extends('layouts.app')

@section('title', 'Business Units')
@section('breadcrumb', 'Business Units')
@section('page-title', 'Business Units')

@section('content')
<div class="mb-8 flex flex-col justify-between gap-4 sm:flex-row sm:items-center">
    <div>
        <p class="text-sm font-semibold uppercase tracking-wider text-red-400">Management</p>
        <h2 class="mt-1 text-3xl font-bold text-white">Business Units</h2>
        <p class="mt-2 text-slate-400">Kelola unit bisnis dan katalog layanan CV. Sigaproduction.</p>
    </div>
    <a href="{{ route('business-units.create') }}" class="inline-flex items-center justify-center rounded-xl bg-blue-600 px-5 py-3 font-semibold text-white shadow transition hover:bg-blue-500">+ Tambah Unit Bisnis</a>
</div>

@if(session('success'))
    <div class="mb-6 rounded-xl border border-green-500/30 bg-green-500/10 px-5 py-4 text-green-300">{{ session('success') }}</div>
@endif
@if($errors->any())
    <div class="mb-6 rounded-xl border border-red-500/30 bg-red-500/10 px-5 py-4 text-red-300">Terdapat kesalahan saat memproses data.</div>
@endif

<div class="mb-6 grid gap-4 sm:grid-cols-2">
    <div class="rounded-2xl border border-slate-800 bg-slate-900 p-6 shadow-sm">
        <p class="text-sm text-slate-400">Total Unit Bisnis</p>
        <p class="mt-2 text-3xl font-bold text-white">{{ $businessUnits->total() }}</p>
    </div>
    <div class="rounded-2xl border border-slate-800 bg-slate-900 p-6 shadow-sm">
        <p class="text-sm text-slate-400">Unit Bisnis Aktif</p>
        <p class="mt-2 text-3xl font-bold text-blue-400">{{ \App\Models\BusinessUnit::where('is_active', true)->count() }}</p>
    </div>
</div>

<div class="overflow-hidden rounded-2xl border border-slate-800 bg-slate-900 shadow-sm">
    <div class="border-b border-slate-800 px-6 py-5">
        <h3 class="text-lg font-bold text-white">Daftar Unit Bisnis</h3>
        <p class="mt-1 text-sm text-slate-400">Tambahkan katalog langsung dari unit bisnis yang dipilih.</p>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm">
            <thead class="bg-slate-950/80 text-xs uppercase tracking-wider text-slate-400">
                <tr>
                    <th class="px-6 py-4">No.</th><th class="px-6 py-4">Nama Unit</th><th class="px-6 py-4">Slug</th><th class="px-6 py-4">Status</th><th class="px-6 py-4 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-800">
                @forelse($businessUnits as $index => $unit)
                    <tr class="transition hover:bg-slate-800/60">
                        <td class="px-6 py-5 text-slate-400">{{ $businessUnits->firstItem() + $index }}</td>
                        <td class="px-6 py-5">
                            <p class="font-semibold text-white">{{ $unit->name }}</p>
                            <p class="mt-1 max-w-sm text-xs text-slate-400">{{ $unit->description ?: 'Belum ada deskripsi.' }}</p>
                        </td>
                        <td class="px-6 py-5"><span class="rounded-md bg-slate-950 px-2 py-1 text-xs text-slate-300">{{ $unit->slug }}</span></td>
                        <td class="px-6 py-5">
                            @if($unit->is_active)
                                <span class="rounded-full bg-green-500/10 px-3 py-1 text-xs font-semibold text-green-300">Aktif</span>
                            @else
                                <span class="rounded-full bg-red-500/10 px-3 py-1 text-xs font-semibold text-red-300">Nonaktif</span>
                            @endif
                        </td>
                        <td class="px-6 py-5">
                            <div class="flex flex-wrap justify-end gap-2">
                                @if($unit->is_active)
                                    <a href="{{ route('business-catalog.items.create', ['business_unit_id' => $unit->id]) }}" class="rounded-lg bg-red-600/15 px-3 py-2 text-xs font-semibold text-red-300 transition hover:bg-red-600 hover:text-white">+ Tambah Katalog</a>
                                    <a href="{{ route('business-catalog.show', $unit->slug) }}" class="rounded-lg bg-blue-500/15 px-3 py-2 text-xs font-semibold text-blue-300 transition hover:bg-blue-500 hover:text-white">Lihat Katalog</a>
                                @endif
                                <a href="{{ route('business-units.edit', $unit) }}" class="popup-danger-hover rounded-lg bg-slate-800 px-3 py-2 text-xs font-semibold text-slate-300 transition hover:bg-slate-700">Edit</a>
                                <form action="{{ route('business-units.destroy', $unit) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus unit bisnis ini beserta katalog terkait?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="popup-danger-hover rounded-lg bg-slate-800 px-3 py-2 text-xs font-semibold text-slate-300 transition hover:bg-red-500/15">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="px-6 py-12 text-center text-slate-400">Belum ada unit bisnis. Silakan tambahkan unit bisnis baru.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($businessUnits->hasPages())
        <div class="border-t border-slate-800 px-6 py-4">{{ $businessUnits->links() }}</div>
    @endif
</div>
<footer class="mt-8 text-center text-xs text-slate-500">© {{ date('Y') }} CV. Sigaproduction. All rights reserved.</footer>
@endsection
