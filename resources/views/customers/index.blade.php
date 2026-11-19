<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customers & Clients | SIGAPRODUCTION</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-50 text-slate-800">

<header class="bg-slate-950 text-white">
    <div class="mx-auto flex max-w-7xl items-center justify-between px-6 py-5">
        <div>
            <h1 class="text-xl font-bold">SIGAPRODUCTION</h1>
            <p class="text-sm text-slate-400">Customer Management System</p>
        </div>
        <a href="{{ route('home') }}"
           class="rounded-lg bg-slate-800 px-4 py-2 text-sm hover:bg-slate-700">
            Dashboard
        </a>
    </div>
</header>

<main class="mx-auto max-w-7xl px-6 py-10">

    <div class="mb-8 flex flex-col justify-between gap-4 sm:flex-row sm:items-center">
        <div>
            <p class="text-sm font-semibold uppercase tracking-wider text-indigo-600">
                Management
            </p>
            <h2 class="mt-1 text-3xl font-bold text-slate-900">
                Customers & Clients
            </h2>
            <p class="mt-2 text-slate-500">
                Kelola data pelanggan dan klien CV. Sigaproduction.
            </p>
        </div>

        <a href="{{ route('customers.create') }}"
           class="rounded-xl bg-indigo-600 px-5 py-3 text-center font-semibold text-white hover:bg-indigo-700">
            + Tambah Pelanggan
        </a>
    </div>

    @if (session('success'))
    <div class="mb-4 rounded-lg bg-green-100 px-4 py-3 text-green-800">
        {{ session('success') }}
    </div>
        @endif

        @if (session('error'))
            <div class="mb-4 rounded-lg bg-red-100 px-4 py-3 text-red-800">
                {{ session('error') }}
            </div>
        @endif

    <div class="mb-6 grid gap-4 sm:grid-cols-3">
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-sm text-slate-500">Total Pelanggan</p>
            <p class="mt-2 text-3xl font-bold">{{ $totalCustomers }}</p>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-sm text-slate-500">Pelanggan Aktif</p>
            <p class="mt-2 text-3xl font-bold text-green-600">{{ $activeCustomers }}</p>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-sm text-slate-500">Pelanggan Nonaktif</p>
            <p class="mt-2 text-3xl font-bold text-red-600">{{ $inactiveCustomers }}</p>
        </div>
    </div>

    <div class="mb-6 rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
        <form action="{{ route('customers.index') }}" method="GET"
              class="grid gap-3 md:grid-cols-3">

            <input
                type="text"
                name="search"
                value="{{ $search }}"
                placeholder="Cari nama, perusahaan, email, telepon..."
                class="rounded-xl border border-slate-300 px-4 py-3 outline-none focus:border-indigo-500 md:col-span-2"
            >

            <select name="status"
                    class="rounded-xl border border-slate-300 px-4 py-3 outline-none focus:border-indigo-500">
                <option value="all" @selected($status === 'all')>Semua Status</option>
                <option value="active" @selected($status === 'active')>Aktif</option>
                <option value="inactive" @selected($status === 'inactive')>Nonaktif</option>
            </select>

            <div class="flex gap-2 md:col-span-3">
                <button type="submit"
                        class="rounded-lg bg-slate-900 px-5 py-2.5 font-semibold text-white hover:bg-slate-700">
                    Cari / Filter
                </button>

                <a href="{{ route('customers.index') }}"
                   class="rounded-lg border border-slate-300 px-5 py-2.5 font-semibold text-slate-600 hover:bg-slate-50">
                    Reset
                </a>
            </div>
        </form>
    </div>

    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
        <div class="border-b border-slate-200 px-6 py-5">
            <h3 class="text-lg font-bold">Daftar Pelanggan</h3>
            <p class="mt-1 text-sm text-slate-500">
                Total hasil: {{ $customers->total() }} pelanggan
            </p>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-slate-50 text-xs uppercase text-slate-500">
                    <tr>
                        <th class="px-6 py-4">No.</th>
                        <th class="px-6 py-4">Pelanggan</th>
                        <th class="px-6 py-4">Kontak</th>
                        <th class="px-6 py-4">Tipe</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100">
                    @forelse($customers as $index => $customer)
                        <tr class="hover:bg-slate-50">
                            <td class="px-6 py-5 text-slate-500">
                                {{ $customers->firstItem() + $index }}
                            </td>

                            <td class="px-6 py-5">
                                <p class="font-semibold text-slate-900">
                                    {{ $customer->name }}
                                </p>
                                @if($customer->company_name)
                                    <p class="mt-1 text-xs text-slate-500">
                                        {{ $customer->company_name }}
                                    </p>
                                @endif
                            </td>

                            <td class="px-6 py-5">
                                <p>{{ $customer->email ?: '-' }}</p>
                                <p class="mt-1 text-xs text-slate-500">
                                    {{ $customer->phone ?: '-' }}
                                </p>
                            </td>

                            <td class="px-6 py-5">
                                <span class="rounded-full bg-indigo-50 px-3 py-1 text-xs font-semibold text-indigo-700">
                                    {{ $customer->customer_type === 'company' ? 'Company' : 'Individual' }}
                                </span>
                            </td>

                            <td class="px-6 py-5">
                                @if($customer->is_active)
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
                                    <a href="{{ route('customers.show', $customer) }}"
                                       class="rounded-lg bg-slate-100 px-3 py-2 text-xs font-semibold hover:bg-slate-200">
                                        Detail
                                    </a>

                                    <a href="{{ route('customers.edit', $customer) }}"
                                       class="rounded-lg bg-amber-100 px-3 py-2 text-xs font-semibold text-amber-700 hover:bg-amber-200">
                                        Edit
                                    </a>

                                    <form action="{{ route('customers.destroy', $customer) }}"
                                          method="POST"
                                          onsubmit="return confirm('Yakin ingin menghapus pelanggan ini?')">
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
                            <td colspan="6" class="px-6 py-12 text-center text-slate-500">
                                Belum ada data pelanggan atau tidak ada hasil pencarian.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($customers->hasPages())
            <div class="border-t border-slate-200 px-6 py-4">
                {{ $customers->links() }}
            </div>
        @endif
    </div>

    <footer class="mt-8 text-center text-xs text-slate-400">
        © {{ date('Y') }} CV. Sigaproduction. All rights reserved.
    </footer>
</main>
</body>
</html>
