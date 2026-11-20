
@php
    $transaction = $transaction ?? null;
    $selectedBookingId = old('booking_id', $selectedBookingId ?? $transaction?->booking_id);
    $amountValue = old('amount', $transaction?->amount ?? '');
@endphp

@if($errors->any())
    <div class="mb-6 rounded-xl border border-red-200 bg-red-50 p-4 text-red-700">
        <p class="font-semibold">Periksa kembali data transaksi.</p>
        <ul class="mt-2 list-inside list-disc text-sm">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="grid grid-cols-1 gap-6 md:grid-cols-2">

    <div>
        <label class="mb-2 block text-sm font-semibold">
            Jenis Transaksi <span class="text-red-500">*</span>
        </label>
        <select name="type"
                id="transaction_type"
                required
                class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-indigo-500 focus:outline-none">
            <option value="income" @selected(old('type', $transaction?->type ?? 'income') === 'income')>
                Income / Pemasukan
            </option>
            <option value="expense" @selected(old('type', $transaction?->type ?? '') === 'expense')>
                Expense / Pengeluaran
            </option>
        </select>
    </div>

    <div>
        <label class="mb-2 block text-sm font-semibold">
            Kategori <span class="text-red-500">*</span>
        </label>
        <select name="category"
                id="transaction_category"
                required
                class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-indigo-500 focus:outline-none">
            <option value="">Pilih kategori</option>
            @foreach([
                'Booking Payment',
                'Service Revenue',
                'Event Revenue',
                'Merchandise Sales',
                'Studio Rental',
                'Equipment Rental',
                'Music Course',
                'Operational Cost',
                'Equipment Purchase',
                'Marketing',
                'Salary',
                'Transportation',
                'Maintenance',
                'Other',
            ] as $category)
                <option value="{{ $category }}"
                    @selected(old('category', $transaction?->category) === $category)>
                    {{ $category }}
                </option>
            @endforeach
        </select>
    </div>

    <div>
        <label class="mb-2 block text-sm font-semibold">
            Booking (Opsional)
        </label>
        <select name="booking_id"
                id="booking_id"
                class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-indigo-500 focus:outline-none">
            <option value="">Tidak terhubung dengan booking</option>
            @foreach($bookings as $booking)
                <option value="{{ $booking->id }}"
                        data-unit-id="{{ $booking->business_unit_id }}"
                        @selected((string) $selectedBookingId === (string) $booking->id)>
                    {{ $booking->booking_code }} — {{ $booking->customer->name }}
                    (Rp {{ number_format((float) $booking->total_amount, 0, ',', '.') }})
                </option>
            @endforeach
        </select>
        <p class="mt-1 text-xs text-slate-500">
            Pilih booking jika transaksi merupakan pembayaran pelanggan.
        </p>
    </div>

    <div>
        <label class="mb-2 block text-sm font-semibold">
            Unit Bisnis <span class="text-red-500">*</span>
        </label>
        <select name="business_unit_id"
                id="business_unit_id"
                required
                class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-indigo-500 focus:outline-none">
            <option value="">Pilih unit bisnis</option>
            @foreach($businessUnits as $unit)
                <option value="{{ $unit->id }}"
                    @selected((string) old('business_unit_id', $transaction?->business_unit_id) === (string) $unit->id)>
                    {{ $unit->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="md:col-span-2">
        <label class="mb-2 block text-sm font-semibold">
            Deskripsi Transaksi <span class="text-red-500">*</span>
        </label>
        <input type="text"
               name="description"
               value="{{ old('description', $transaction?->description) }}"
               required
               maxlength="255"
               placeholder="Contoh: Pembayaran sewa studio musik"
               class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-indigo-500 focus:outline-none">
    </div>

    <div>
        <label class="mb-2 block text-sm font-semibold">
            Nominal (Rp) <span class="text-red-500">*</span>
        </label>
        <input type="text"
               id="amount_display"
               inputmode="numeric"
               autocomplete="off"
               value="{{ $amountValue !== '' ? number_format((float) $amountValue, 0, ',', '.') : '' }}"
               required
               placeholder="1.500.000"
               class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-indigo-500 focus:outline-none">
        <input type="hidden" name="amount" id="amount" value="{{ $amountValue }}">
    </div>

    <div>
        <label class="mb-2 block text-sm font-semibold">
            Tanggal Transaksi <span class="text-red-500">*</span>
        </label>
        <input type="date"
               name="transaction_date"
               value="{{ old('transaction_date', $transaction?->transaction_date?->format('Y-m-d') ?? now()->format('Y-m-d')) }}"
               required
               class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-indigo-500 focus:outline-none">
    </div>

    <div>
        <label class="mb-2 block text-sm font-semibold">Metode Pembayaran</label>
        <select name="payment_method" id="payment_method"
                class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-indigo-500 focus:outline-none">
            <option value="">Tidak ditentukan</option>
            @foreach([
                'cash' => 'Cash',
                'transfer' => 'Bank Transfer',
                'credit_card' => 'Credit Card',
                'debit_card' => 'Debit Card',
                'e_wallet' => 'E-Wallet',
                'other' => 'Other',
            ] as $value => $label)
                <option value="{{ $value }}"
                    @selected(old('payment_method', $transaction?->payment_method) === $value)>
                    {{ $label }}
                </option>
            @endforeach
        </select>
    </div>

    <div>
        <label class="mb-2 block text-sm font-semibold">Nomor Referensi</label>
        <input type="text"
               name="reference_number"
               value="{{ old('reference_number', $transaction?->reference_number) }}"
               maxlength="255"
               placeholder="Nomor bukti transfer atau referensi"
               class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-indigo-500 focus:outline-none">
    </div>

    <div>
        <label class="mb-2 block text-sm font-semibold">Status Transaksi</label>
        <select name="status"
                class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-indigo-500 focus:outline-none">
            <option value="completed"
                @selected(old('status', $transaction?->status ?? 'completed') === 'completed')>
                Completed
            </option>
            <option value="voided"
                @selected(old('status', $transaction?->status) === 'voided')>
                Voided
            </option>
        </select>
        <p class="mt-1 text-xs text-slate-500">
            Transaksi voided tidak dihitung dalam laporan keuangan.
        </p>
    </div>

    <div class="md:col-span-2">
        <label class="mb-2 block text-sm font-semibold">Catatan Tambahan</label>
        <textarea name="notes"
                  rows="4"
                  class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-indigo-500 focus:outline-none"
                  placeholder="Catatan tambahan transaksi...">{{ old('notes', $transaction?->notes) }}</textarea>
    </div>

</div>

<div class="mt-8 flex flex-col-reverse gap-3 border-t border-slate-200 pt-6 sm:flex-row sm:justify-end">

    <a href="{{ route('transactions.index') }}"
       class="rounded-xl border border-slate-300 px-6 py-3 text-center font-semibold text-slate-600 hover:bg-slate-50">
        Batal
    </a>

    <button type="submit"
            class="rounded-xl bg-indigo-600 px-6 py-3 font-semibold text-white hover:bg-indigo-700">
        {{ $transaction ? 'Simpan Perubahan' : 'Simpan Transaksi' }}
    </button>

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const bookingSelect = document.getElementById('booking_id');
    const businessUnitSelect = document.getElementById('business_unit_id');
    const typeSelect = document.getElementById('transaction_type');
    const categorySelect = document.getElementById('transaction_category');
    const paymentMethodSelect = document.getElementById('payment_method');
    const amountDisplay = document.getElementById('amount_display');
    const amountInput = document.getElementById('amount');
    const rupiah = new Intl.NumberFormat('id-ID', { maximumFractionDigits: 0 });

    function formatAmount() {
        const raw = String(amountDisplay.value || '').replace(/[^0-9]/g, '');
        amountInput.value = raw;
        amountDisplay.value = raw ? rupiah.format(Number(raw)) : '';
    }

    function syncBooking() {
        const selected = bookingSelect.options[bookingSelect.selectedIndex];
        const isBookingPayment = Boolean(bookingSelect.value);

        if (isBookingPayment && selected.dataset.unitId) {
            businessUnitSelect.value = selected.dataset.unitId;
            typeSelect.value = 'income';
            categorySelect.value = 'Booking Payment';
            if (!['cash', 'transfer'].includes(paymentMethodSelect.value)) {
                paymentMethodSelect.value = 'cash';
            }
            Array.from(paymentMethodSelect.options).forEach(function (option) {
                if (option.value) option.disabled = !['cash', 'transfer'].includes(option.value);
            });
        } else {
            Array.from(paymentMethodSelect.options).forEach(function (option) {
                option.disabled = false;
            });
        }
    }

    amountDisplay.addEventListener('input', formatAmount);
    formatAmount();
    bookingSelect.addEventListener('change', syncBooking);
    syncBooking();
});
</script>
