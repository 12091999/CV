<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CustomerController extends Controller
{
    /**
     * Menampilkan daftar pelanggan, pencarian, dan filter status.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $status = $request->input('status', 'all');

        $query = Customer::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('company_name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        if ($status === 'active') {
            $query->where('is_active', true);
        } elseif ($status === 'inactive') {
            $query->where('is_active', false);
        }

        $customers = $query->latest()->paginate(10)->withQueryString();

        $totalCustomers = Customer::count();
        $activeCustomers = Customer::where('is_active', true)->count();
        $inactiveCustomers = Customer::where('is_active', false)->count();

        return view('customers.index', compact(
            'customers',
            'search',
            'status',
            'totalCustomers',
            'activeCustomers',
            'inactiveCustomers'
        ));
    }

    /**
     * Menampilkan form tambah pelanggan.
     */
    public function create()
    {
        return view('customers.create');
    }

    /**
     * Menyimpan pelanggan baru.
     */
    public function store(Request $request)
    {
        $validated = $this->validateCustomer($request);

        $validated['is_active'] = $request->boolean('is_active');

        Customer::create($validated);

        return redirect()
            ->route('customers.index')
            ->with('success', 'Pelanggan berhasil ditambahkan.');
    }

    /**
     * Menampilkan detail pelanggan.
     */
    public function show(Customer $customer)
    {
        return view('customers.show', compact('customer'));
    }

    /**
     * Menampilkan form edit pelanggan.
     */
    public function edit(Customer $customer)
    {
        return view('customers.edit', compact('customer'));
    }

    /**
     * Memperbarui data pelanggan.
     */
    public function update(Request $request, Customer $customer)
    {
        $validated = $this->validateCustomer($request);

        $validated['is_active'] = $request->boolean('is_active');

        $customer->update($validated);

        return redirect()
            ->route('customers.index')
            ->with('success', 'Data pelanggan berhasil diperbarui.');
    }

    /**
     * Menghapus pelanggan.
     */
    public function destroy(Customer $customer)
        {
            try {
                $customer->delete();

                return redirect()
                    ->route('customers.index')
                    ->with('success', 'Data pelanggan berhasil dihapus.');

            } catch (\Illuminate\Database\QueryException $e) {

                return redirect()
                    ->route('customers.index')
                    ->with('error', 'Pelanggan tidak dapat dihapus karena masih memiliki data booking atau transaksi terkait.');
            }
        }

    /**
     * Validasi data pelanggan.
     */
    private function validateCustomer(Request $request): array
    {
        return $request->validate([
            'customer_type' => [
                'required',
                Rule::in(['individual', 'company']),
            ],
            'name' => ['required', 'string', 'max:255'],
            'company_name' => ['nullable', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:30'],
            'address' => ['nullable', 'string'],
            'notes' => ['nullable', 'string'],
            'is_active' => ['nullable', 'boolean'],
        ]);
    }
}
