PERBAIKAN BOOKING & PEMBAYARAN - SIGAPRODUCTION

Isi ZIP mempertahankan struktur folder proyek Laravel.

GANTI FILE BERIKUT DI PROYEK:
1. app/Http/Controllers/BookingController.php
2. app/Http/Controllers/TransactionController.php
3. resources/views/bookings/_form.blade.php
4. resources/views/bookings/show.blade.php
5. resources/views/transactions/_form.blade.php

PERUBAHAN:
- Input harga dan pembayaran memakai format ribuan Indonesia (contoh 200.000).
- Nilai diformat di browser dan dibersihkan di server sebelum validasi.
- Harga katalog tetap diambil dari database.
- Pembayaran awal yang dimasukkan saat membuat booking otomatis dibuat sebagai transaksi pemasukan.
- Metode pembayaran awal: Cash atau Transfer.
- amount_paid dan payment_status disinkronkan dari transaksi pemasukan berstatus completed.
- Halaman detail menggunakan amount_paid yang sudah disinkronkan untuk menampilkan total diterima dan sisa tagihan.

CATATAN:
- Nominal rupiah diperlakukan sebagai bilangan bulat (tanpa pecahan desimal).
- Sebelum mengganti file, buat salinan/backup lima file lama.
- Setelah mengganti, jalankan:
    php artisan optimize:clear
- Lalu uji buat booking dengan total Rp200.000 dan pembayaran awal Rp150.000.
  Hasil yang diharapkan: diterima Rp150.000, sisa Rp50.000, status pembayaran Partial.
