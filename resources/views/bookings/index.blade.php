<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bookings & Orders | SIGAPRODUCTION</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-50 text-slate-800">

<header class="bg-slate-950 text-white">
    <div class="mx-auto flex max-w-7xl items-center justify-between px-6 py-5">
        <div>
            <h1 class="text-xl font-bold tracking-wide">SIGAPRODUCTION</h1>
            <p class="text-sm text-slate-400">Company Management System</p>
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
                Transaction Management
            </p>
            <h2 class="mt-1 text-3xl font-bold text-slate-900">
                Bookings & Orders
            </h2>
            <p class="mt-2 text-slate-500">
                Kelola seluruh pemesanan dari tujuh unit bisnis SIGAPRODUCTION.
            </p>
        </div>

        <a href="{{ route('bookings.create') }}"
           class="rounded-xl bg-indigo-600 px-5 py-3 text-center font-semibold text-white hover:bg-indigo-700">
            + Buat Pesanan
        </a>
    </div>

    @if(session('success'))
        <div class="mb-6 rounded-xl border border-green-200 bg-green-50 px-5 py-4 text-green-700">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="mb-6 rounded-xl border border-red-200 bg-red-50 px-5 py-4 text-red-700">
            <p class="font-semibold">Terjadi kesalahan:</p>
            <ul class="mt-2 list-inside list-disc text-sm">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="mb-6 grid gap-4 sm:grid-cols-2 xl:grid-cols-4">

        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-sm text-slate-500">Total Pesanan</p>
            <p class="mt-2 text-3xl font-bold text-slate-900">
                {{ number_format($totalBookings) }}
            </p>
            <p class="mt-2 text-xs text-slate-400">Seluruh pesanan terdaftar</p>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-sm text-slate-500">Menunggu Konfirmasi</p>
            <p class="mt-2 text-3xl font-bold text-amber-600">
                {{ number_format($pendingBookings) }}
            </p>
            <p class="mt-2 text-xs text-slate-400">Status pending</p>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-sm text-slate-500">Pesanan Selesai</p>
            <p class="mt-2 text-3xl font-bold text-green-600">
                {{ number_format($completedBookings) }}
            </p>
            <p class="mt-2 text-xs text-slate-400">Status completed</p>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-sm text-slate-500">Total Pembayaran Masuk</p>
            <p class="mt-2 text-2xl font-bold text-indigo-600">
                Rp{{ number_format($totalRevenue, 0, ',', '.') }}
            </p>
            <p class="mt-2 text-xs text-slate-400">Akumulasi pembayaran tercatat</p>
        </div>

    </div>

    <div class="mb-6 rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
        <form action="{{ route('bookings.index') }}" method="GET"
              class="grid gap-3 lg:grid-cols-4">

            <input
                type="text"
                name="search"
                value="{{ $search }}"
                placeholder="Cari kode, pesanan, pelanggan..."
                class="rounded-xl border border-slate-300 px-4 py-3 outline-none focus:border-indigo-500 lg:col-span-2"
            >

            <select name="status"
                    class="rounded-xl border border-slate-300 px-4 py-3 outline-none focus:border-indigo-500">
                <option value="all">Semua Status Pesanan</option>
                <option value="pending" @selected($status === 'pending')>Pending</option>
                <option value="confirmed" @selected($status === 'confirmed')>Confirmed</option>
                <option value="in_progress" @selected($status === 'in_progress')>In Progress</option>
                <option value="completed" @selected($status === 'completed')>Completed</option>
                <option value="cancelled" @selected($status === 'cancelled')>Cancelled</option>
            </select>

            <select name="payment_status"
                    class="rounded-xl border border-slate-300 px-4 py-3 outline-none focus:border-indigo-500">
                <option value="all">Semua Pembayaran</option>
                <option value="unpaid" @selected($paymentStatus === 'unpaid')>Unpaid</option>
                <option value="partial" @selected($paymentStatus === 'partial')>Partial</option>
                <option value="paid" @selected($paymentStatus === 'paid')>Paid</option>
            </select>

            <div class="flex gap-2 lg:col-span-4">
                <button type="submit"
                        class="rounded-lg bg-slate-900 px-5 py-2.5 font-semibold text-white hover:bg-slate-700">
                    Cari / Filter
                </button>

                <a href="{{ route('bookings.index') }}"
                   class="rounded-lg border border-slate-300 px-5 py-2.5 font-semibold text-slate-600 hover:bg-slate-50">
                    Reset
                </a>
            </div>
        </form>
    </div>

    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
        <div class="border-b border-slate-200 px-6 py-5">
            <h3 class="text-lg font-bold text-slate-900">Daftar Pesanan</h3>
            <p class="mt-1 text-sm text-slate-500">
                {{ $bookings->total() }} pesanan ditemukan
            </p>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-slate-50 text-xs uppercase text-slate-500">
                    <tr>
                        <th class="px-6 py-4">Kode / Pesanan</th>
                        <th class="px-6 py-4">Pelanggan</th>
                        <th class="px-6 py-4">Unit Bisnis</th>
                        <th class="px-6 py-4">Tanggal</th>
                        <th class="px-6 py-4">Total</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4">Pembayaran</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100">
                    @forelse($bookings as $index => $booking)
                        @php
                            $bookingStyles = [
                                'pending' => 'bg-amber-100 text-amber-700',
                                'confirmed' => 'bg-blue-100 text-blue-700',
                                'in_progress' => 'bg-violet-100 text-violet-700',
                                'completed' => 'bg-green-100 text-green-700',
                                'cancelled' => 'bg-red-100 text-red-700',
                            ];

                            $paymentStyles = [
                                'unpaid' => 'bg-red-100 text-red-700',
                                'partial' => 'bg-amber-100 text-amber-700',
                                'paid' => 'bg-green-100 text-green-700',
                            ];
                        @endphp

                        <tr class="hover:bg-slate-50">
                            <td class="px-6 py-5">
                                <p class="font-bold text-indigo-600">
                                    {{ $booking->booking_code }}
                                </p>
                                <p class="mt-1 font-medium text-slate-800">
                                    {{ $booking->title }}
                                </p>
                            </td>

                            <td class="px-6 py-5">
                                <p class="font-semibold">{{ $booking->customer->name }}</p>
                                <p class="mt-1 text-xs text-slate-500">
                                    {{ $booking->customer->company_name ?: $booking->customer->email ?: '-' }}
                                </p>
                            </td>

                            <td class="px-6 py-5">
                                {{ $booking->businessUnit->name }}
                            </td>

                            <td class="px-6 py-5 whitespace-nowrap">
                                {{ $booking->event_date?->format('d M Y') ?? '-' }}
                            </td>

                            <td class="px-6 py-5 whitespace-nowrap font-semibold">
                                Rp{{ number_format((float) $booking->total_amount, 0, ',', '.') }}
                            </td>

                            <td class="px-6 py-5">
                                <span class="rounded-full px-3 py-1 text-xs font-semibold {{ $bookingStyles[$booking->booking_status] ?? 'bg-slate-100 text-slate-700' }}">
                                    {{ str($booking->booking_status)->replace('_', ' ')->title() }}
                                </span>
                            </td>

                            <td class="px-6 py-5">
                                <span class="rounded-full px-3 py-1 text-xs font-semibold {{ $paymentStyles[$booking->payment_status] ?? 'bg-slate-100 text-slate-700' }}">
                                    {{ str($booking->payment_status)->title() }}
                                </span>
                            </td>

                            <td class="px-6 py-5">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('bookings.show', $booking) }}"
                                       class="rounded-lg bg-slate-100 px-3 py-2 text-xs font-semibold hover:bg-slate-200">
                                        Detail
                                    </a>

                                    <a href="{{ route('bookings.edit', $booking) }}"
                                       class="rounded-lg bg-amber-100 px-3 py-2 text-xs font-semibold text-amber-700 hover:bg-amber-200">
                                        Edit
                                    </a>

                                    <form action="{{ route('bookings.destroy', $booking) }}"
                                          method="POST"
                                          onsubmit="return confirm('Yakin ingin menghapus pesanan {{ $booking->booking_code }}?')">
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
                            <td colspan="8" class="px-6 py-14 text-center">
                                <p class="font-semibold text-slate-700">Belum ada pesanan</p>
                                <p class="mt-1 text-sm text-slate-500">
                                    Buat pesanan pertama untuk mulai menggunakan modul ini.
                                </p>
                                <a href="{{ route('bookings.create') }}"
                                   class="mt-4 inline-block rounded-lg bg-indigo-600 px-4 py-2 font-semibold text-white">
                                    Buat Pesanan
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($bookings->hasPages())
            <div class="border-t border-slate-200 px-6 py-4">
                {{ $bookings->links() }}
            </div>
        @endif
    </div>

    <footer class="mt-8 text-center text-xs text-slate-400">
        © {{ date('Y') }} CV. Sigaproduction. All rights reserved.
    </footer>

</main>
</body>
</html>
