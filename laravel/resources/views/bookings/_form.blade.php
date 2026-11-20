
@php
    $booking = $booking ?? null;
    $selectedCustomer = old('customer_id', $booking?->customer_id);
    $selectedBusinessUnit = old('business_unit_id', $booking?->business_unit_id ?? ($selectedUnit ?? null));
    $selectedItem = $selectedItem ?? null;
    $quantity = old('quantity', $booking?->quantity ?? 1);
    $unitPrice = old('unit_price', $booking ? (int) round((float) $booking->unit_price) : ($selectedItem ? (int) round((float) $selectedItem->price) : ''));
    $amountPaid = old('amount_paid', $booking ? (int) round((float) $booking->amount_paid) : '');
@endphp

<div class="space-y-8">
    @if($selectedItem)
        <input type="hidden" name="business_item_id" value="{{ $selectedItem->id }}">
        <div class="rounded-xl border border-blue-200 bg-blue-50 p-4 text-sm text-blue-800">Item katalog dipilih: <strong>{{ $selectedItem->name }}</strong>. Harga akan mengikuti data katalog yang tersimpan.</div>
    @endif

    <section>
        <div class="mb-5 border-b border-slate-200 pb-3">
            <h3 class="font-bold text-slate-900">Informasi Pelanggan & Unit Bisnis</h3>
            <p class="mt-1 text-sm text-slate-500">
                Tentukan pelanggan dan unit bisnis yang menerima pesanan.
            </p>
        </div>

        <div class="grid gap-5 md:grid-cols-2">

            <div>
                <label for="customer_id" class="mb-2 block text-sm font-semibold">
                    Pelanggan <span class="text-red-500">*</span>
                </label>

                <select name="customer_id" id="customer_id" required
                        class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 focus:border-blue-500">
                    <option value="">Pilih pelanggan</option>

                    @foreach($customers as $customer)
                        <option value="{{ $customer->id }}"
                            @selected((string) $selectedCustomer === (string) $customer->id)>
                            {{ $customer->name }}
                            @if($customer->company_name)
                                — {{ $customer->company_name }}
                            @endif
                        </option>
                    @endforeach
                </select>

                @error('customer_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror

                @if($customers->isEmpty())
                    <p class="mt-2 text-sm text-red-600">
                        Belum ada pelanggan aktif.
                        <a href="{{ route('customers.create') }}" class="font-semibold underline">
                            Tambahkan pelanggan
                        </a>
                    </p>
                @endif
            </div>

            <div>
                <label for="business_unit_id" class="mb-2 block text-sm font-semibold">
                    Unit Bisnis <span class="text-red-500">*</span>
                </label>

                <select name="business_unit_id" id="business_unit_id" required
                        class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 focus:border-blue-500">
                    <option value="">Pilih unit bisnis</option>

                    @foreach($businessUnits as $unit)
                        <option value="{{ $unit->id }}"
                            @selected((string) $selectedBusinessUnit === (string) $unit->id)>
                            {{ $unit->name }}
                        </option>
                    @endforeach
                </select>

                @error('business_unit_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror

                @if($businessUnits->isEmpty())
                    <p class="mt-2 text-sm text-red-600">
                        Belum ada unit bisnis aktif. Periksa pengaturan Business Units.
                    </p>
                @endif
            </div>

        </div>
    </section>

    <section>
        <div class="mb-5 border-b border-slate-200 pb-3">
            <h3 class="font-bold text-slate-900">Detail Pesanan</h3>
            <p class="mt-1 text-sm text-slate-500">
                Informasi jasa, produk, atau layanan yang dipesan.
            </p>
        </div>

        <div class="space-y-5">

            <div>
                <label for="title" class="mb-2 block text-sm font-semibold">
                    Nama Pesanan <span class="text-red-500">*</span>
                </label>

                <input type="text" name="title" id="title" required maxlength="255"
                       value="{{ old('title', $booking?->title ?? $selectedItem?->name) }}"
                       placeholder="Contoh: Sound System untuk Wedding Event"
                       @readonly((bool) $selectedItem)
                       class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-blue-500">

                @error('title')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="description" class="mb-2 block text-sm font-semibold">
                    Deskripsi Pesanan
                </label>

                <textarea name="description" id="description" rows="3"
                          placeholder="Jelaskan detail jasa atau produk yang dipesan..."
                          class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-blue-500">{{ old('description', $booking?->description ?? $selectedItem?->description) }}</textarea>

                @error('description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid gap-5 md:grid-cols-2">
                <div>
                    <label for="event_date" class="mb-2 block text-sm font-semibold">
                        Tanggal Pelaksanaan
                    </label>

                    <input type="date" name="event_date" id="event_date"
                           value="{{ old('event_date', $booking?->event_date?->format('Y-m-d')) }}"
                           class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-blue-500">

                    @error('event_date')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="location" class="mb-2 block text-sm font-semibold">
                        Lokasi / Alamat
                    </label>

                    <input type="text" name="location" id="location"
                           value="{{ old('location', $booking?->location) }}"
                           placeholder="Lokasi kegiatan atau pengiriman"
                           class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-blue-500">

                    @error('location')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

        </div>
    </section>

    <section>
        <div class="mb-5 border-b border-slate-200 pb-3">
            <h3 class="font-bold text-slate-900">Rincian Harga</h3>
            <p class="mt-1 text-sm text-slate-500">
                Total pesanan dihitung dari jumlah dikalikan harga satuan.
            </p>
        </div>

        <div class="grid gap-5 md:grid-cols-2">

            <div>
                <label for="quantity" class="mb-2 block text-sm font-semibold">
                    Jumlah / Kuantitas <span class="text-red-500">*</span>
                </label>

                <input type="number" name="quantity" id="quantity" min="1" step="1" required
                       value="{{ $quantity }}"
                       class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-blue-500">

                @error('quantity')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="unit_price" class="mb-2 block text-sm font-semibold">
                    Harga Satuan (Rp) <span class="text-red-500">*</span>
                </label>

                <input type="text" name="unit_price" id="unit_price"
                       inputmode="numeric" autocomplete="off" required
                       @readonly((bool) $selectedItem && (float) $selectedItem->price > 0)
                       value="{{ old('unit_price', $unitPrice) }}"
                       class="rupiah-input w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-blue-500">

                @error('unit_price')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="rounded-xl border border-blue-100 bg-blue-50 p-5 md:col-span-2">
                <p class="text-sm font-medium text-blue-700">Estimasi Total Pesanan</p>
                <p id="totalPreview" class="mt-2 text-3xl font-bold text-blue-900">
                    Rp0
                </p>
                <p class="mt-2 text-xs text-blue-600">
                    Total = Jumlah × Harga Satuan. Nilai final dihitung ulang oleh server.
                </p>
            </div>

            <div class="md:col-span-2">
                <label for="amount_paid" class="mb-2 block text-sm font-semibold">
                    Pembayaran Diterima (Rp)
                </label>

                <input type="text" name="amount_paid" id="amount_paid"
                       inputmode="numeric" autocomplete="off"
                       value="{{ $amountPaid }}"
                       placeholder="Contoh: 200.000"
                       @readonly($booking !== null)
                       class="rupiah-input w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-blue-500">

                @error('amount_paid')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror

                @if(!$booking)
                    <label for="payment_method" class="mb-2 mt-4 block text-sm font-semibold">
                        Metode Pembayaran Awal
                    </label>
                    <select name="payment_method" id="payment_method"
                            class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-blue-500">
                        <option value="cash" @selected(old('payment_method', 'cash') === 'cash')>Cash</option>
                        <option value="transfer" @selected(old('payment_method') === 'transfer')>Transfer</option>
                    </select>
                @else
                    <p class="mt-2 text-xs text-slate-500">
                        Pembayaran pada pesanan yang sudah dibuat dikelola melalui menu Transaksi.
                    </p>
                @endif

                <p class="mt-2 text-xs text-slate-500">
                    Status pembayaran dihitung otomatis berdasarkan jumlah pembayaran yang tercatat.
                </p>
            </div>

        </div>
    </section>

    <section>
        <div class="mb-5 border-b border-slate-200 pb-3">
            <h3 class="font-bold text-slate-900">Status & Catatan</h3>
            <p class="mt-1 text-sm text-slate-500">
                Atur progres pengerjaan pesanan.
            </p>
        </div>

        <div class="space-y-5">

            <div>
                <label for="booking_status" class="mb-2 block text-sm font-semibold">
                    Status Pesanan <span class="text-red-500">*</span>
                </label>

                <select name="booking_status" id="booking_status" required
                        class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 focus:border-blue-500">
                    <option value="pending" @selected(old('booking_status', $booking?->booking_status ?? 'pending') === 'pending')>
                        Pending — Menunggu
                    </option>
                    <option value="confirmed" @selected(old('booking_status', $booking?->booking_status) === 'confirmed')>
                        Confirmed — Dikonfirmasi
                    </option>
                    <option value="in_progress" @selected(old('booking_status', $booking?->booking_status) === 'in_progress')>
                        In Progress — Sedang Dikerjakan
                    </option>
                    <option value="completed" @selected(old('booking_status', $booking?->booking_status) === 'completed')>
                        Completed — Selesai
                    </option>
                    <option value="cancelled" @selected(old('booking_status', $booking?->booking_status) === 'cancelled')>
                        Cancelled — Dibatalkan
                    </option>
                </select>

                @error('booking_status')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="notes" class="mb-2 block text-sm font-semibold">
                    Catatan Internal
                </label>

                <textarea name="notes" id="notes" rows="4"
                          placeholder="Catatan tambahan untuk tim SIGAPRODUCTION..."
                          class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-blue-500">{{ old('notes', $booking?->notes) }}</textarea>

                @error('notes')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

        </div>
    </section>

</div>

<div class="mt-8 flex flex-col-reverse gap-3 border-t border-slate-200 pt-6 sm:flex-row sm:justify-end">
    <a href="{{ route('bookings.index') }}"
       class="rounded-xl border border-slate-300 px-6 py-3 text-center font-semibold text-slate-600 hover:bg-slate-50">
        Batal
    </a>

    <button type="submit"
            @disabled($customers->isEmpty() || $businessUnits->isEmpty())
            class="rounded-xl bg-blue-600 px-6 py-3 font-semibold text-white hover:bg-blue-700 disabled:cursor-not-allowed disabled:opacity-50">
        {{ $submitLabel }}
    </button>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const quantityInput = document.getElementById('quantity');
    const priceInput = document.getElementById('unit_price');
    const paidInput = document.getElementById('amount_paid');
    const totalPreview = document.getElementById('totalPreview');

    function digitsOnly(value) {
        const digits = String(value ?? '').replace(/\D/g, '');
        return digits.replace(/^0+(?=\d)/, '');
    }

    function formatRupiahInput(input) {
        if (!input || input.readOnly) return;
        const digits = digitsOnly(input.value);
        input.value = digits.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    }

    function numberFromInput(input) {
        return Number(digitsOnly(input?.value)) || 0;
    }

    function updateTotal() {
        const quantity = Math.max(0, Number(quantityInput?.value) || 0);
        const price = numberFromInput(priceInput);
        const total = quantity * price;

        totalPreview.textContent = new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            maximumFractionDigits: 0
        }).format(total);
    }

    [priceInput, paidInput].forEach(function (input) {
        if (!input) return;
        input.value = digitsOnly(input.value).replace(/\B(?=(\d{3})+(?!\d))/g, '.');
        input.addEventListener('input', function () {
            formatRupiahInput(input);
            updateTotal();
        });
    });

    quantityInput?.addEventListener('input', updateTotal);
    updateTotal();
});
</script>
