
<div class="space-y-6">

    <div>
        <label for="name" class="mb-2 block text-sm font-semibold text-slate-700">
            Nama Unit Bisnis <span class="text-red-500">*</span>
        </label>

        <input
            type="text"
            name="name"
            id="name"
            value="{{ old('name', $businessUnit?->name) }}"
            required
            maxlength="255"
            placeholder="Contoh: Music Services"
            class="w-full rounded-xl border border-slate-300 px-4 py-3 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
        >

        @error('name')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="description" class="mb-2 block text-sm font-semibold text-slate-700">
            Deskripsi Unit Bisnis
        </label>

        <textarea
            name="description"
            id="description"
            rows="4"
            placeholder="Jelaskan layanan atau aktivitas unit bisnis..."
            class="w-full rounded-xl border border-slate-300 px-4 py-3 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
        >{{ old('description', $businessUnit?->description) }}</textarea>

        @error('description')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div class="rounded-xl border border-slate-200 bg-slate-50 p-4">
        <label class="flex cursor-pointer items-center gap-3">
            <input
                type="checkbox"
                name="is_active"
                value="1"
                @checked(old('is_active', $businessUnit?->is_active ?? true))
                class="h-5 w-5 rounded border-slate-300 text-blue-600 focus:ring-blue-500"
            >

            <span>
                <span class="block font-semibold text-slate-800">
                    Aktifkan unit bisnis
                </span>
                <span class="mt-1 block text-sm text-slate-500">
                    Unit bisnis yang aktif dapat ditampilkan dalam operasional perusahaan.
                </span>
            </span>
        </label>

        @error('is_active')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

</div>

<div class="mt-8 flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">
    <a href="{{ route('business-units.index') }}"
       class="rounded-xl border border-slate-300 px-5 py-3 text-center font-semibold text-slate-600 hover:bg-slate-50">
        Batal
    </a>

    <button type="submit"
            class="rounded-xl bg-blue-600 px-6 py-3 font-semibold text-white hover:bg-blue-700">
        {{ $submitLabel }}
    </button>
</div>
