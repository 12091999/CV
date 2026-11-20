<?php

namespace App\Http\Controllers;

use App\Models\BusinessUnit;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class BusinessUnitController extends Controller
{
    /**
     * Menampilkan seluruh unit bisnis.
     */
    public function index()
    {
        $businessUnits = BusinessUnit::latest()->paginate(10);

        return view('business-units.index', compact('businessUnits'));
    }

    /**
     * Menampilkan form tambah unit bisnis.
     */
    public function create()
    {
        return view('business-units.create');
    }

    /**
     * Menyimpan unit bisnis baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $validated['slug'] = $this->generateUniqueSlug($validated['name']);
        $validated['is_active'] = $request->boolean('is_active');

        BusinessUnit::create($validated);

        return redirect()
            ->route('business-units.index')
            ->with('success', 'Unit bisnis berhasil ditambahkan.');
    }

    /**
     * Menampilkan form edit unit bisnis.
     */
    public function edit(BusinessUnit $businessUnit)
    {
        return view('business-units.edit', compact('businessUnit'));
    }

    /**
     * Memperbarui unit bisnis.
     */
    public function update(Request $request, BusinessUnit $businessUnit)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $validated['slug'] = $this->generateUniqueSlug(
            $validated['name'],
            $businessUnit->id
        );

        $validated['is_active'] = $request->boolean('is_active');

        $businessUnit->update($validated);

        return redirect()
            ->route('business-units.index')
            ->with('success', 'Unit bisnis berhasil diperbarui.');
    }

    /**
     * Menghapus unit bisnis.
     */
    public function destroy(BusinessUnit $businessUnit)
    {
        $businessUnit->delete();

        return redirect()
            ->route('business-units.index')
            ->with('success', 'Unit bisnis berhasil dihapus.');
    }

    /**
     * Membuat slug unik berdasarkan nama unit bisnis.
     */
    private function generateUniqueSlug(string $name, ?int $ignoreId = null): string
    {
        $baseSlug = Str::slug($name);
        $slug = $baseSlug;
        $counter = 1;

        while (
            BusinessUnit::where('slug', $slug)
                ->when($ignoreId, fn ($query) => $query->where('id', '!=', $ignoreId))
                ->exists()
        ) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }
}
