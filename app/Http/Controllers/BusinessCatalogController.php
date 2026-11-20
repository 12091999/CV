<?php

namespace App\Http\Controllers;

use App\Models\BusinessItem;
use App\Models\BusinessUnit;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class BusinessCatalogController extends Controller
{
    public function show(string $slug)
    {
        $businessUnit = BusinessUnit::where('slug', $slug)
            ->where('is_active', true)
            ->with(['items' => fn ($query) => $query->orderBy('name')])
            ->firstOrFail();

        return view('business-catalog.show', compact('businessUnit'));
    }

    public function create(Request $request)
    {
        $businessUnits = BusinessUnit::where('is_active', true)->orderBy('name')->get();
        abort_if($businessUnits->isEmpty(), 404, 'Belum ada unit bisnis aktif.');

        $selectedBusinessUnitId = $request->integer('business_unit_id');

        return view('business-catalog.create', compact('businessUnits', 'selectedBusinessUnitId'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'business_unit_id' => ['required', 'integer', Rule::exists('business_units', 'id')->where('is_active', true)],
            'name' => ['required', 'string', 'max:255'],
            'category' => ['nullable', 'string', 'max:100'],
            'description' => ['nullable', 'string'],
            'price' => ['nullable', 'numeric', 'min:0', 'max:9999999999999.99'],
            'unit_label' => ['required', 'string', 'max:50'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $businessUnit = BusinessUnit::findOrFail($validated['business_unit_id']);
        $baseSlug = Str::slug($validated['name']) ?: 'item';
        $slug = $baseSlug;
        $counter = 1;

        while (BusinessItem::where('business_unit_id', $businessUnit->id)->where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $counter++;
        }

        $item = $businessUnit->items()->create([
            'name' => $validated['name'],
            'slug' => $slug,
            'category' => $validated['category'] ?? null,
            'description' => $validated['description'] ?? null,
            'price' => $validated['price'] ?? 0,
            'unit_label' => $validated['unit_label'],
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()->route('business-catalog.show', $businessUnit->slug)
            ->with('success', 'Katalog "' . $item->name . '" berhasil ditambahkan ke ' . $businessUnit->name . '.');
    }

    public function edit(BusinessItem $businessItem)
    {
        $businessItem->load('businessUnit');

        return view('business-catalog.edit', compact('businessItem'));
    }

    public function update(Request $request, BusinessItem $businessItem)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'category' => ['nullable', 'string', 'max:100'],
            'description' => ['nullable', 'string'],
            'price' => ['nullable', 'numeric', 'min:0', 'max:9999999999999.99'],
            'unit_label' => ['required', 'string', 'max:50'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $baseSlug = Str::slug($validated['name']) ?: 'item';
        $slug = $baseSlug;
        $counter = 1;

        while (
            BusinessItem::where('business_unit_id', $businessItem->business_unit_id)
                ->where('slug', $slug)
                ->where('id', '!=', $businessItem->id)
                ->exists()
        ) {
            $slug = $baseSlug . '-' . $counter++;
        }

        $businessItem->update([
            'name' => $validated['name'],
            'slug' => $slug,
            'category' => $validated['category'] ?? null,
            'description' => $validated['description'] ?? null,
            'price' => $validated['price'] ?? 0,
            'unit_label' => $validated['unit_label'],
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()->route('business-catalog.show', $businessItem->businessUnit->slug)
            ->with('success', 'Katalog berhasil diperbarui.');
    }

    public function destroy(BusinessItem $businessItem)
    {
        $businessUnit = $businessItem->businessUnit;
        $businessItem->delete();

        return redirect()->route('business-catalog.show', $businessUnit->slug)
            ->with('success', 'Katalog berhasil dihapus.');
    }
}
