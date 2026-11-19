<?php

namespace App\Http\Controllers;

use App\Models\BusinessUnit;
use Illuminate\Http\Request;

class BusinessCatalogController extends Controller
{
    public function show(string $slug)
    {
        $businessUnit = BusinessUnit::where('slug', $slug)
            ->where('is_active', true)
            ->with(['items' => fn ($query) => $query->where('is_active', true)->orderBy('name')])
            ->firstOrFail();

        return view('business-catalog.show', compact('businessUnit'));
    }
}
