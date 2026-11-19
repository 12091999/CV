@extends('layouts.app')

@section('title', 'Dashboard')
@section('breadcrumb', 'Overview')
@section('page-title', 'Dashboard')

@section('content')
<div class="space-y-8">


            <!-- WELCOME -->
            <section id="dashboard"
                class="relative overflow-hidden rounded-2xl bg-slate-950 p-7 lg:p-9 text-white">

                <div class="absolute -right-10 -top-20 w-72 h-72 rounded-full bg-orange-500/20 blur-3xl"></div>

                <div class="relative z-10 max-w-2xl">
                    <p class="text-orange-400 font-semibold text-sm mb-3">
                        COMPANY MANAGEMENT SYSTEM
                    </p>

                    <h1 class="text-2xl md:text-3xl lg:text-4xl font-bold leading-tight mb-4">
                        Welcome back, {{ auth()->user()->name }}!
                    </h1>

                    <p class="text-slate-300 leading-relaxed mb-6">
                        Selamat datang di pusat manajemen CV. Sigaproduction.
                        Kelola layanan musik, event, penyewaan, merchandise,
                        dan seluruh aktivitas bisnis perusahaan dari satu tempat.
                    </p>

                    <a href="#business"
                        class="inline-flex items-center gap-2 bg-orange-500 hover:bg-orange-600 px-5 py-3 rounded-xl font-semibold text-sm transition">
                        Explore Business Units →
                    </a>
                </div>

                <div class="absolute right-12 bottom-5 text-8xl opacity-10 hidden md:block">
                    🎸
                </div>
            </section>

            <!-- STATISTICS -->
            <section>
                <div class="flex justify-between items-center mb-5">
                    <div>
                        <h2 class="text-lg font-bold">Business Overview</h2>
                        <p class="text-sm text-slate-500">Ringkasan aktivitas perusahaan</p>
                    </div>

                    <span class="text-xs text-slate-400">Demo data</span>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-5">

                    <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm">
                        <div class="flex justify-between items-center mb-5">
                            <div class="w-11 h-11 bg-orange-100 text-orange-600 rounded-xl flex items-center justify-center text-xl">Rp</div>
                            <span class="text-xs bg-orange-50 text-orange-600 px-3 py-1 rounded-full">Revenue</span>
                        </div>
                        <p class="text-sm text-slate-500">Total Pendapatan</p>
                        <h3 class="text-2xl font-bold mt-1">Rp 0</h3>
                        <p class="text-xs text-slate-400 mt-3">Menunggu integrasi transaksi</p>
                    </div>

                    <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm">
                        <div class="flex justify-between items-center mb-5">
                            <div class="w-11 h-11 bg-blue-100 text-blue-600 rounded-xl flex items-center justify-center text-xl">▣</div>
                            <span class="text-xs bg-blue-50 text-blue-600 px-3 py-1 rounded-full">Bookings</span>
                        </div>
                        <p class="text-sm text-slate-500">Total Pemesanan</p>
                        <h3 class="text-2xl font-bold mt-1">0</h3>
                        <p class="text-xs text-slate-400 mt-3">Pemesanan pelanggan</p>
                    </div>

                    <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm">
                        <div class="flex justify-between items-center mb-5">
                            <div class="w-11 h-11 bg-green-100 text-green-600 rounded-xl flex items-center justify-center text-xl">♙</div>
                            <span class="text-xs bg-green-50 text-green-600 px-3 py-1 rounded-full">Clients</span>
                        </div>
                        <p class="text-sm text-slate-500">Total Pelanggan</p>
                        <h3 class="text-2xl font-bold mt-1">0</h3>
                        <p class="text-xs text-slate-400 mt-3">Pelanggan terdaftar</p>
                    </div>

                    <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm">
                        <div class="flex justify-between items-center mb-5">
                            <div class="w-11 h-11 bg-purple-100 text-purple-600 rounded-xl flex items-center justify-center text-xl">✦</div>
                            <span class="text-xs bg-purple-50 text-purple-600 px-3 py-1 rounded-full">Projects</span>
                        </div>
                        <p class="text-sm text-slate-500">Proyek Berjalan</p>
                        <h3 class="text-2xl font-bold mt-1">0</h3>
                        <p class="text-xs text-slate-400 mt-3">Event dan proyek aktif</p>
                    </div>

                </div>
            </section>

            <!-- CHARTS -->
            <section id="analytics" class="grid grid-cols-1 xl:grid-cols-3 gap-5">

                <div class="xl:col-span-2 bg-white border border-slate-200 rounded-2xl p-5 lg:p-6 shadow-sm">
                    <div class="flex justify-between items-center mb-6">
                        <div>
                            <h2 class="font-bold text-lg">Revenue Overview</h2>
                            <p class="text-sm text-slate-500">Contoh visualisasi pendapatan bulanan</p>
                        </div>
                        <span class="text-xs text-slate-400">Demo</span>
                    </div>

                    <div class="h-72">
                        <canvas id="revenueChart"></canvas>
                    </div>
                </div>

                <div class="bg-white border border-slate-200 rounded-2xl p-5 lg:p-6 shadow-sm">
                    <h2 class="font-bold text-lg">Business Distribution</h2>
                    <p class="text-sm text-slate-500 mb-5">Contoh distribusi unit bisnis</p>

                    <div class="h-56">
                        <canvas id="businessChart"></canvas>
                    </div>

                    <p class="text-xs text-center text-slate-400 mt-4">
                        Data contoh, bukan transaksi aktual
                    </p>
                </div>

            </section>

            <!-- BUSINESS UNITS -->
            <section id="business">
                <div class="mb-5">
                    <h2 class="text-lg font-bold">Business Units</h2>
                    <p class="text-sm text-slate-500">Kelola seluruh layanan CV. Sigaproduction</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-5">

                    @php
                        $businessUnits = [
                            ['icon' => '🎤', 'name' => 'Music Services', 'desc' => 'Jasa musik, performer, band, dan kebutuhan pertunjukan.'],
                            ['icon' => '🎪', 'name' => 'Event Organizer', 'desc' => 'Perencanaan, pengelolaan, dan penyelenggaraan event.'],
                            ['icon' => '👕', 'name' => 'SIGA Merch', 'desc' => 'Pengelolaan merchandise, produk, dan pesanan.'],
                            ['icon' => '🎭', 'name' => 'Music Event Properties', 'desc' => 'Properti, perlengkapan, dan kebutuhan produksi event.'],
                            ['icon' => '🎧', 'name' => 'Music Studio Rental', 'desc' => 'Jadwal, fasilitas, dan reservasi studio musik.'],
                            ['icon' => '🎸', 'name' => 'Musical Equipment Rental', 'desc' => 'Penyewaan dan inventaris alat musik.'],
                            ['icon' => '🎼', 'name' => 'Music Courses', 'desc' => 'Program les musik, siswa, pengajar, dan jadwal kelas.'],
                        ];
                    @endphp

                    @foreach($businessUnits as $unit)
                        <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm hover:shadow-md hover:border-orange-300 transition">
                            <div class="w-12 h-12 rounded-xl bg-orange-50 flex items-center justify-center text-2xl mb-4">
                                {{ $unit['icon'] }}
                            </div>

                            <h3 class="font-bold text-base mb-2">{{ $unit['name'] }}</h3>

                            <p class="text-sm text-slate-500 leading-relaxed mb-5">
                                {{ $unit['desc'] }}
                            </p>

                            <a href="#management" class="text-sm text-orange-600 font-semibold hover:text-orange-700">
                                Manage Unit →
                            </a>
                        </div>
                    @endforeach

                </div>
            </section>

            <!-- CALENDAR AND ACTIVITY -->
            <section id="calendar" class="grid grid-cols-1 xl:grid-cols-2 gap-5">

                <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm">
                    <div class="flex justify-between items-center mb-5">
                        <div>
                            <h2 class="font-bold text-lg">Upcoming Events</h2>
                            <p class="text-sm text-slate-500">Agenda perusahaan</p>
                        </div>
                        <span class="text-xs text-slate-400">Demo</span>
                    </div>

                    <div class="border border-dashed border-slate-300 rounded-xl p-8 text-center">
                        <div class="text-4xl mb-3">📅</div>
                        <h3 class="font-semibold">Belum ada jadwal event</h3>
                        <p class="text-sm text-slate-400 mt-2">
                            Jadwal event akan ditampilkan setelah modul kalender terintegrasi.
                        </p>
                    </div>
                </div>

                <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm">
                    <div class="flex justify-between items-center mb-5">
                        <div>
                            <h2 class="font-bold text-lg">Recent Activities</h2>
                            <p class="text-sm text-slate-500">Aktivitas sistem terbaru</p>
                        </div>
                        <span class="text-xs text-slate-400">Demo</span>
                    </div>

                    <div class="flex gap-4 items-center py-4 border-b border-slate-100">
                        <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">✓</div>
                        <div>
                            <p class="text-sm font-semibold">Login berhasil</p>
                            <p class="text-xs text-slate-400">Anda berhasil masuk ke sistem.</p>
                        </div>
                    </div>

                    <div class="flex gap-4 items-center py-4">
                        <div class="w-10 h-10 bg-orange-100 rounded-full flex items-center justify-center">♙</div>
                        <div>
                            <p class="text-sm font-semibold">Akun pengguna aktif</p>
                            <p class="text-xs text-slate-400">Selamat datang di CV. Sigaproduction.</p>
                        </div>
                    </div>
                </div>

            </section>

            <!-- MANAGEMENT -->
            <section id="management" class="bg-slate-950 rounded-2xl p-7 text-white">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <div>
                        <p class="text-orange-400 text-sm font-semibold mb-2">SYSTEM MANAGEMENT</p>
                        <h2 class="text-xl font-bold mb-2">Company Management Center</h2>
                        <p class="text-sm text-slate-400">
                            Pusat pengelolaan pelanggan, pemesanan, keuangan, inventaris, dan tim perusahaan.
                        </p>
                    </div>

                    <div class="text-4xl">🏢</div>
                </div>
            </section>

            <!-- FOOTER -->
            <footer class="text-center text-sm text-slate-400 py-4">
                © {{ date('Y') }} CV. Sigaproduction. All rights reserved.
                <br>
                Company Management System
            </footer>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<section id="analytics" class="grid grid-cols-1 xl:grid-cols-3 gap-5">

                <div class="xl:col-span-2 bg-white border border-slate-200 rounded-2xl p-5 lg:p-6 shadow-sm">
                    <div class="flex justify-between items-center mb-6">
                        <div>
                            <h2 class="font-bold text-lg">Revenue Overview</h2>
                            <p class="text-sm text-slate-500">Contoh visualisasi pendapatan bulanan</p>
                        </div>
                        <span class="text-xs text-slate-400">Demo</span>
                    </div>

                    <div class="h-72">
                        <canvas id="revenueChart"></canvas>
                    </div>
                </div>

                <div class="bg-white border border-slate-200 rounded-2xl p-5 lg:p-6 shadow-sm">
                    <h2 class="font-bold text-lg">Business Distribution</h2>
                    <p class="text-sm text-slate-500 mb-5">Contoh distribusi unit bisnis</p>

                    <div class="h-56">
                        <canvas id="businessChart"></canvas>
                    </div>

                    <p class="text-xs text-center text-slate-400 mt-4">
                        Data contoh, bukan transaksi aktual
                    </p>
                </div>

            </section>

            <!-- BUSINESS UNITS -->
            <section id="business">
                <div class="mb-5">
                    <h2 class="text-lg font-bold">Business Units</h2>
                    <p class="text-sm text-slate-500">Kelola seluruh layanan CV. Sigaproduction</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-5">

                    @php
                        $businessUnits = [
                            ['icon' => '🎤', 'name' => 'Music Services', 'desc' => 'Jasa musik, performer, band, dan kebutuhan pertunjukan.'],
                            ['icon' => '🎪', 'name' => 'Event Organizer', 'desc' => 'Perencanaan, pengelolaan, dan penyelenggaraan event.'],
                            ['icon' => '👕', 'name' => 'SIGA Merch', 'desc' => 'Pengelolaan merchandise, produk, dan pesanan.'],
                            ['icon' => '🎭', 'name' => 'Music Event Properties', 'desc' => 'Properti, perlengkapan, dan kebutuhan produksi event.'],
                            ['icon' => '🎧', 'name' => 'Music Studio Rental', 'desc' => 'Jadwal, fasilitas, dan reservasi studio musik.'],
                            ['icon' => '🎸', 'name' => 'Musical Equipment Rental', 'desc' => 'Penyewaan dan inventaris alat musik.'],
                            ['icon' => '🎼', 'name' => 'Music Courses', 'desc' => 'Program les musik, siswa, pengajar, dan jadwal kelas.'],
                        ];
                    @endphp

                    @foreach($businessUnits as $unit)
                        <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm hover:shadow-md hover:border-orange-300 transition">
                            <div class="w-12 h-12 rounded-xl bg-orange-50 flex items-center justify-center text-2xl mb-4">
                                {{ $unit['icon'] }}
                            </div>

                            <h3 class="font-bold text-base mb-2">{{ $unit['name'] }}</h3>

                            <p class="text-sm text-slate-500 leading-relaxed mb-5">
                                {{ $unit['desc'] }}
                            </p>

                            <a href="#management" class="text-sm text-orange-600 font-semibold hover:text-orange-700">
                                Manage Unit →
                            </a>
                        </div>
                    @endforeach

                </div>
            </section>

            <!-- CALENDAR AND ACTIVITY -->
            <section id="calendar" class="grid grid-cols-1 xl:grid-cols-2 gap-5">

                <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm">
                    <div class="flex justify-between items-center mb-5">
                        <div>
                            <h2 class="font-bold text-lg">Upcoming Events</h2>
                            <p class="text-sm text-slate-500">Agenda perusahaan</p>
                        </div>
                        <span class="text-xs text-slate-400">Demo</span>
                    </div>

                    <div class="border border-dashed border-slate-300 rounded-xl p-8 text-center">
                        <div class="text-4xl mb-3">📅</div>
                        <h3 class="font-semibold">Belum ada jadwal event</h3>
                        <p class="text-sm text-slate-400 mt-2">
                            Jadwal event akan ditampilkan setelah modul kalender terintegrasi.
                        </p>
                    </div>
                </div>

                <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm">
                    <div class="flex justify-between items-center mb-5">
                        <div>
                            <h2 class="font-bold text-lg">Recent Activities</h2>
                            <p class="text-sm text-slate-500">Aktivitas sistem terbaru</p>
                        </div>
                        <span class="text-xs text-slate-400">Demo</span>
                    </div>

                    <div class="flex gap-4 items-center py-4 border-b border-slate-100">
                        <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">✓</div>
                        <div>
                            <p class="text-sm font-semibold">Login berhasil</p>
                            <p class="text-xs text-slate-400">Anda berhasil masuk ke sistem.</p>
                        </div>
                    </div>

                    <div class="flex gap-4 items-center py-4">
                        <div class="w-10 h-10 bg-orange-100 rounded-full flex items-center justify-center">♙</div>
                        <div>
                            <p class="text-sm font-semibold">Akun pengguna aktif</p>
                            <p class="text-xs text-slate-400">Selamat datang di CV. Sigaproduction.</p>
                        </div>
                    </div>
                </div>

            </section>

            <!-- MANAGEMENT -->
            <section id="management" class="bg-slate-950 rounded-2xl p-7 text-white">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <div>
                        <p class="text-orange-400 text-sm font-semibold mb-2">SYSTEM MANAGEMENT</p>
                        <h2 class="text-xl font-bold mb-2">Company Management Center</h2>
                        <p class="text-sm text-slate-400">
                            Pusat pengelolaan pelanggan, pemesanan, keuangan, inventaris, dan tim perusahaan.
                        </p>
                    </div>

                    <div class="text-4xl">🏢</div>
                </div>
            </section>

            <!-- FOOTER -->
            <footer class="text-center text-sm text-slate-400 py-4">
                © {{ date('Y') }} CV. Sigaproduction. All rights reserved.
                <br>
                Company Management System
            </footer>

        </div>
    </main>
</div>


<script>
    const revenueCanvas = document.getElementById('revenueChart');

    new Chart(revenueCanvas, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
            datasets: [{
                label: 'Contoh pendapatan',
                data: [12, 19, 15, 25, 22, 30, 27, 35, 32, 40, 36, 45],
                borderColor: '#f97316',
                backgroundColor: 'rgba(249, 115, 22, 0.10)',
                fill: true,
                tension: 0.4,
                borderWidth: 3,
                pointRadius: 3
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: '#f1f5f9'
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            }
        }
    });

    const businessCanvas = document.getElementById('businessChart');

    new Chart(businessCanvas, {
        type: 'doughnut',
        data: {
            labels: [
                'Music Services',
                'Event Organizer',
                'SIGA Merch',
                'Studio Rental',
                'Equipment Rental',
                'Music Courses',
                'Properties'
            ],
            datasets: [{
                data: [20, 20, 10, 15, 15, 10, 10],
                backgroundColor: [
                    '#f97316',
                    '#3b82f6',
                    '#10b981',
                    '#8b5cf6',
                    '#eab308',
                    '#ec4899',
                    '#64748b'
                ],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '68%',
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        boxWidth: 10,
                        padding: 12,
                        font: {
                            size: 10
                        }
                    }
                }
            }
        }
    });
    
</script>
@endpush
