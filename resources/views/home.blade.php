@extends('layouts.app')

@section('title', 'Dashboard')
@section('breadcrumb', 'Overview')
@section('page-title', 'Dashboard')

@section('content')
<div class="space-y-8">


            <!-- WELCOME -->
            <section id="dashboard"
                class="relative overflow-hidden rounded-2xl bg-slate-950 p-7 lg:p-9 text-white">

                <div class="absolute -right-10 -top-20 w-72 h-72 rounded-full bg-blue-500/20 blur-3xl"></div>

                <div class="relative z-10 max-w-2xl">
                    <p class="text-blue-400 font-semibold text-sm mb-3">
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
                        class="inline-flex items-center gap-2 bg-blue-500 hover:bg-blue-600 px-5 py-3 rounded-xl font-semibold text-sm transition">
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
                            <div class="w-11 h-11 bg-blue-100 text-blue-600 rounded-xl flex items-center justify-center text-xl">Rp</div>
                            <span class="text-xs bg-blue-50 text-blue-600 px-3 py-1 rounded-full">Revenue</span>
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
        </div>
@endsection
