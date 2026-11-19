@extends('layouts.app')

@section('title', 'Business Units')
@section('breadcrumb', 'Business Units')
@section('page-title', 'Business Units')

@section('content')
<div class="mb-8 flex flex-col justify-between gap-4 sm:flex-row sm:items-center">
            <div>
                <p class="text-sm font-semibold uppercase tracking-wider text-indigo-600">
                    Management
                </p>
                <h2 class="mt-1 text-3xl font-bold text-slate-900">
                    Business Units
                </h2>
                <p class="mt-2 text-slate-500">
                    Kelola seluruh unit bisnis CV. Sigaproduction.
                </p>
            </div>

            <a href="{{ route('business-units.create') }}"
               class="inline-flex items-center justify-center rounded-xl bg-indigo-600 px-5 py-3 font-semibold text-white shadow hover:bg-indigo-700">
                + Tambah Unit Bisnis
            </a>
        </div>

        @if(session('success'))
            <div class="mb-6 rounded-xl border border-green-200 bg-green-50 px-5 py-4 text-green-700">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="mb-6 rounded-xl border border-red-200 bg-red-50 px-5 py-4 text-red-700">
                Terdapat kesalahan saat memproses data.
            </div>
        @endif

        <div class="mb-6 grid gap-4 sm:grid-cols-2">
            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <p class="text-sm text-slate-500">Total Unit Bisnis</p>
                <p class="mt-2 text-3xl font-bold text-slate-900">
                    {{ $businessUnits->total() }}
                </p>
            </div>

            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <p class="text-sm text-slate-500">Unit Bisnis Aktif</p>
                <p class="mt-2 text-3xl font-bold text-green-600">
                    {{ \App\Models\BusinessUnit::where('is_active', true)->count() }}
                </p>
            </div>
        </div>

        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
            <div class="border-b border-slate-200 px-6 py-5">
                <h3 class="text-lg font-bold text-slate-900">Daftar Unit Bisnis</h3>
                <p class="mt-1 text-sm text-slate-500">
                    Data unit bisnis yang tersimpan di database.
                </p>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="bg-slate-50 text-xs uppercase tracking-wider text-slate-500">
                        <tr>
                            <th class="px-6 py-4">No.</th>
                            <th class="px-6 py-4">Nama Unit</th>
                            <th class="px-6 py-4">Slug</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4 text-right">Aksi</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-100">
                        @forelse($businessUnits as $index => $unit)
                            <tr class="hover:bg-slate-50">
                                <td class="px-6 py-5 text-slate-500">
                                    {{ $businessUnits->firstItem() + $index }}
                                </td>

                                <td class="px-6 py-5">
                                    <p class="font-semibold text-slate-900">
                                        {{ $unit->name }}
                                    </p>
                                    <p class="mt-1 max-w-sm text-xs text-slate-500">
                                        {{ $unit->description ?: 'Belum ada deskripsi.' }}
                                    </p>
                                </td>

                                <td class="px-6 py-5">
                                    <span class="rounded-md bg-slate-100 px-2 py-1 text-xs text-slate-600">
                                        {{ $unit->slug }}
                                    </span>
                                </td>

                                <td class="px-6 py-5">
                                    @if($unit->is_active)
                                        <span class="rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-700">
                                            Aktif
                                        </span>
                                    @else
                                        <span class="rounded-full bg-red-100 px-3 py-1 text-xs font-semibold text-red-700">
                                            Nonaktif
                                        </span>
                                    @endif
                                </td>

                                <td class="px-6 py-5">
                                    <div class="flex justify-end gap-2">
                                        <a href="{{ route('business-units.edit', $unit) }}"
                                           class="rounded-lg bg-amber-100 px-3 py-2 text-xs font-semibold text-amber-700 hover:bg-amber-200">
                                            Edit
                                        </a>

                                        <form action="{{ route('business-units.destroy', $unit) }}"
                                              method="POST"
                                              onsubmit="return confirm('Apakah Anda yakin ingin menghapus unit bisnis ini?')">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                    class="rounded-lg bg-red-100 px-3 py-2 text-xs font-semibold text-red-700 hover:bg-red-200">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-slate-500">
                                    Belum ada unit bisnis. Silakan tambahkan unit bisnis baru.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($businessUnits->hasPages())
                <div class="border-t border-slate-200 px-6 py-4">
                    {{ $businessUnits->links() }}
                </div>
            @endif
        </div>

        <footer class="mt-8 text-center text-xs text-slate-400">
            © {{ date('Y') }} CV. Sigaproduction. All rights reserved.
        </footer>
@endsection
