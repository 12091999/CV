@extends('layouts.app')

@section('title', 'Detail Pelanggan')
@section('breadcrumb', 'Customers & Clients')
@section('page-title', 'Detail Pelanggan')

@section('content')
<a href="{{ route('customers.index') }}"
       class="text-sm font-semibold text-indigo-600">
        ← Kembali ke daftar pelanggan
    </a>

    <div class="my-6 flex flex-col justify-between gap-4 sm:flex-row sm:items-center">
        <div>
            <p class="text-sm font-semibold uppercase tracking-wider text-indigo-600">
                Customer Profile
            </p>
            <h2 class="mt-1 text-3xl font-bold text-slate-900">
                {{ $customer->name }}
            </h2>
            <p class="mt-2 text-slate-500">
                Detail informasi pelanggan SIGAPRODUCTION.
            </p>
        </div>

        <a href="{{ route('customers.edit', $customer) }}"
           class="rounded-xl bg-indigo-600 px-5 py-3 text-center font-semibold text-white hover:bg-indigo-700">
            Edit Pelanggan
        </a>
    </div>

    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
        <div class="mb-6 flex flex-wrap items-center gap-3">
            <span class="rounded-full bg-indigo-50 px-3 py-1 text-sm font-semibold text-indigo-700">
                {{ $customer->customer_type === 'company' ? 'Company' : 'Individual' }}
            </span>

            @if($customer->is_active)
                <span class="rounded-full bg-green-100 px-3 py-1 text-sm font-semibold text-green-700">
                    Aktif
                </span>
            @else
                <span class="rounded-full bg-red-100 px-3 py-1 text-sm font-semibold text-red-700">
                    Nonaktif
                </span>
            @endif
        </div>

        <div class="grid gap-6 sm:grid-cols-2">
            <div>
                <p class="text-sm text-slate-500">Nama Pelanggan / Penanggung Jawab</p>
                <p class="mt-1 font-semibold">{{ $customer->name }}</p>
            </div>

            <div>
                <p class="text-sm text-slate-500">Nama Perusahaan</p>
                <p class="mt-1 font-semibold">{{ $customer->company_name ?: '-' }}</p>
            </div>

            <div>
                <p class="text-sm text-slate-500">Email</p>
                <p class="mt-1 font-semibold">{{ $customer->email ?: '-' }}</p>
            </div>

            <div>
                <p class="text-sm text-slate-500">Nomor Telepon</p>
                <p class="mt-1 font-semibold">{{ $customer->phone ?: '-' }}</p>
            </div>

            <div class="sm:col-span-2">
                <p class="text-sm text-slate-500">Alamat</p>
                <p class="mt-1 whitespace-pre-line font-semibold">{{ $customer->address ?: '-' }}</p>
            </div>

            <div class="sm:col-span-2">
                <p class="text-sm text-slate-500">Catatan</p>
                <p class="mt-1 whitespace-pre-line font-semibold">{{ $customer->notes ?: '-' }}</p>
            </div>

            <div>
                <p class="text-sm text-slate-500">Tanggal Terdaftar</p>
                <p class="mt-1 font-semibold">
                    {{ $customer->created_at->format('d-m-Y H:i') }}
                </p>
            </div>

            <div>
                <p class="text-sm text-slate-500">Terakhir Diperbarui</p>
                <p class="mt-1 font-semibold">
                    {{ $customer->updated_at->format('d-m-Y H:i') }}
                </p>
            </div>
        </div>

        <div class="mt-8 border-t border-slate-200 pt-6">
            <form action="{{ route('customers.destroy', $customer) }}"
                  method="POST"
                  onsubmit="return confirm('Yakin ingin menghapus pelanggan ini?')">
                @csrf
                @method('DELETE')

                <button type="submit"
                        class="rounded-xl bg-red-50 px-5 py-3 font-semibold text-red-700 hover:bg-red-100">
                    Hapus Pelanggan
                </button>
            </form>
        </div>
    </div>
@endsection
