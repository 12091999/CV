<div class="space-y-5">
    @if(isset($businessUnits))
        <div>
            <label for="business_unit_id" class="mb-2 block text-sm font-semibold text-slate-200">Nama Unit Bisnis <span class="text-red-400">*</span></label>
            <select name="business_unit_id" id="business_unit_id" required class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-white outline-none transition focus:border-red-500 focus:ring-2 focus:ring-red-500/20">
                <option value="">Pilih unit bisnis</option>
                @foreach($businessUnits as $unit)
                    <option value="{{ $unit->id }}" @selected((string) old('business_unit_id', $selectedBusinessUnitId ?? '') === (string) $unit->id)>{{ $unit->name }}</option>
                @endforeach
            </select>
            @error('business_unit_id')<p class="mt-1 text-sm text-red-400">{{ $message }}</p>@enderror
        </div>
    @else
        <div class="rounded-xl border border-blue-500/30 bg-blue-500/10 p-4">
            <p class="text-xs uppercase tracking-wider text-blue-300">Unit Bisnis</p>
            <p class="mt-1 font-semibold text-white">{{ $businessItem->businessUnit->name }}</p>
            <p class="mt-1 text-xs text-slate-400">Katalog ini tetap terhubung dengan unit bisnis tersebut.</p>
        </div>
    @endif

    <div>
        <label for="name" class="mb-2 block text-sm font-semibold text-slate-200">Nama Katalog <span class="text-red-400">*</span></label>
        <input id="name" name="name" value="{{ old('name', $businessItem->name ?? '') }}" required maxlength="255" placeholder="Contoh: Sewa Sound System" class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-white placeholder:text-slate-500 outline-none transition focus:border-red-500 focus:ring-2 focus:ring-red-500/20">
        @error('name')<p class="mt-1 text-sm text-red-400">{{ $message }}</p>@enderror
    </div>

    <div>
        <label for="category" class="mb-2 block text-sm font-semibold text-slate-200">Kategori</label>
        <input id="category" name="category" value="{{ old('category', $businessItem->category ?? '') }}" maxlength="100" placeholder="Contoh: Penyewaan, Jasa, Merchandise" class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-white placeholder:text-slate-500 outline-none transition focus:border-red-500 focus:ring-2 focus:ring-red-500/20">
        @error('category')<p class="mt-1 text-sm text-red-400">{{ $message }}</p>@enderror
    </div>

    <div>
        <label for="description" class="mb-2 block text-sm font-semibold text-slate-200">Deskripsi</label>
        <textarea id="description" name="description" rows="4" placeholder="Jelaskan detail layanan atau produk..." class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-white placeholder:text-slate-500 outline-none transition focus:border-red-500 focus:ring-2 focus:ring-red-500/20">{{ old('description', $businessItem->description ?? '') }}</textarea>
        @error('description')<p class="mt-1 text-sm text-red-400">{{ $message }}</p>@enderror
    </div>

    <div class="grid gap-5 sm:grid-cols-2">
        <div>
            <label for="price" class="mb-2 block text-sm font-semibold text-slate-200">Harga (Rp)</label>
            <input id="price" name="price" type="number" min="0" step="0.01" value="{{ old('price', $businessItem->price ?? 0) }}" class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-white outline-none transition focus:border-red-500 focus:ring-2 focus:ring-red-500/20">
            @error('price')<p class="mt-1 text-sm text-red-400">{{ $message }}</p>@enderror
        </div>
        <div>
            <label for="unit_label" class="mb-2 block text-sm font-semibold text-slate-200">Satuan Harga <span class="text-red-400">*</span></label>
            <input id="unit_label" name="unit_label" value="{{ old('unit_label', $businessItem->unit_label ?? 'unit') }}" required maxlength="50" placeholder="unit / hari / jam / paket" class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-white outline-none transition focus:border-red-500 focus:ring-2 focus:ring-red-500/20">
            @error('unit_label')<p class="mt-1 text-sm text-red-400">{{ $message }}</p>@enderror
        </div>
    </div>

    <label class="flex items-center gap-3 rounded-xl border border-slate-700 bg-slate-950/70 p-4">
        <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $businessItem->is_active ?? true)) class="h-4 w-4 rounded border-slate-600 bg-slate-900 text-red-500 focus:ring-red-500">
        <span><span class="block font-semibold text-white">Aktifkan katalog</span><span class="text-sm text-slate-400">Katalog aktif akan ditampilkan pada halaman unit bisnis.</span></span>
    </label>
    @error('is_active')<p class="text-sm text-red-400">{{ $message }}</p>@enderror
</div>

<div class="mt-8 flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">
    @if(isset($businessItem))
        <a href="{{ route('business-catalog.show', $businessItem->businessUnit->slug) }}" class="popup-danger-hover rounded-xl border border-slate-700 px-5 py-3 text-center font-semibold text-slate-300 transition hover:border-red-500">Batal</a>
    @else
        <a href="{{ route('business-units.index') }}" class="popup-danger-hover rounded-xl border border-slate-700 px-5 py-3 text-center font-semibold text-slate-300 transition hover:border-red-500">Batal</a>
    @endif
    <button type="submit" class="rounded-xl bg-red-600 px-6 py-3 font-semibold text-white transition hover:bg-red-500 focus:outline-none focus:ring-2 focus:ring-red-400 focus:ring-offset-2 focus:ring-offset-slate-950">{{ $submitLabel }}</button>
</div>
