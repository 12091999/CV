
<div class="space-y-6">

    <div>
        <label for="customer_type" class="mb-2 block text-sm font-semibold">
            Tipe Pelanggan <span class="text-red-500">*</span>
        </label>

        <select name="customer_type" id="customer_type" required
                class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-indigo-500">
            <option value="individual"
                @selected(old('customer_type', $customer?->customer_type ?? 'individual') === 'individual')>
                Individual / Perorangan
            </option>
            <option value="company"
                @selected(old('customer_type', $customer?->customer_type) === 'company')>
                Company / Perusahaan
            </option>
        </select>

        @error('customer_type')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="name" class="mb-2 block text-sm font-semibold">
            Nama Pelanggan / Penanggung Jawab <span class="text-red-500">*</span>
        </label>

        <input type="text" name="name" id="name" required maxlength="255"
               value="{{ old('name', $customer?->name) }}"
               placeholder="Masukkan nama pelanggan"
               class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-indigo-500">

        @error('name')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="company_name" class="mb-2 block text-sm font-semibold">
            Nama Perusahaan <span class="text-slate-400">(Opsional)</span>
        </label>

        <input type="text" name="company_name" id="company_name" maxlength="255"
               value="{{ old('company_name', $customer?->company_name) }}"
               placeholder="Nama perusahaan atau instansi"
               class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-indigo-500">

        @error('company_name')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div class="grid gap-6 md:grid-cols-2">
        <div>
            <label for="email" class="mb-2 block text-sm font-semibold">Email</label>

            <input type="email" name="email" id="email" maxlength="255"
                   value="{{ old('email', $customer?->email) }}"
                   placeholder="email@example.com"
                   class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-indigo-500">

            @error('email')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="phone" class="mb-2 block text-sm font-semibold">Nomor Telepon</label>

            <input type="text" name="phone" id="phone" maxlength="30"
                   value="{{ old('phone', $customer?->phone) }}"
                   placeholder="08xxxxxxxxxx"
                   class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-indigo-500">

            @error('phone')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <div>
        <label for="address" class="mb-2 block text-sm font-semibold">Alamat</label>

        <textarea name="address" id="address" rows="3"
                  placeholder="Alamat pelanggan atau perusahaan"
                  class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-indigo-500">{{ old('address', $customer?->address) }}</textarea>

        @error('address')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="notes" class="mb-2 block text-sm font-semibold">Catatan</label>

        <textarea name="notes" id="notes" rows="3"
                  placeholder="Catatan tambahan tentang pelanggan..."
                  class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-indigo-500">{{ old('notes', $customer?->notes) }}</textarea>

        @error('notes')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div class="rounded-xl border border-slate-200 bg-slate-50 p-4">
        <label class="flex cursor-pointer items-center gap-3">
            <input type="checkbox" name="is_active" value="1"
                   @checked(old('is_active', $customer?->is_active ?? true))
                   class="h-5 w-5 rounded border-slate-300 text-indigo-600">
            <span>
                <span class="block font-semibold">Pelanggan Aktif</span>
                <span class="text-sm text-slate-500">
                    Tandai pelanggan sebagai aktif.
                </span>
            </span>
        </label>
    </div>
</div>

<div class="mt-8 flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">
    <a href="{{ route('customers.index') }}"
       class="rounded-xl border border-slate-300 px-5 py-3 text-center font-semibold text-slate-600">
        Batal
    </a>

    <button type="submit"
            class="rounded-xl bg-indigo-600 px-6 py-3 font-semibold text-white hover:bg-indigo-700">
        {{ $submitLabel }}
    </button>
</div>
