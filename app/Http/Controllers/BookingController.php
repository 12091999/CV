<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\BusinessItem;
use App\Models\BusinessUnit;
use App\Models\Customer;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $status = $request->input('status', 'all');
        $paymentStatus = $request->input('payment_status', 'all');

        $query = Booking::with(['customer', 'businessUnit', 'businessItem']);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('booking_code', 'like', "%{$search}%")
                    ->orWhere('title', 'like', "%{$search}%")
                    ->orWhereHas('customer', function ($customerQuery) use ($search) {
                        $customerQuery->where('name', 'like', "%{$search}%")
                            ->orWhere('company_name', 'like', "%{$search}%");
                    })
                    ->orWhereHas('businessUnit', function ($unitQuery) use ($search) {
                        $unitQuery->where('name', 'like', "%{$search}%");
                    });
            });
        }

        if (in_array($status, [
            'pending',
            'confirmed',
            'in_progress',
            'completed',
            'cancelled',
        ], true)) {
            $query->where('booking_status', $status);
        }

        if (in_array($paymentStatus, [
            'unpaid',
            'partial',
            'paid',
        ], true)) {
            $query->where('payment_status', $paymentStatus);
        }

        $bookings = $query->latest()->paginate(10)->withQueryString();

        $totalBookings = Booking::count();
        $pendingBookings = Booking::where('booking_status', 'pending')->count();
        $completedBookings = Booking::where('booking_status', 'completed')->count();
        $totalRevenue = Booking::sum('amount_paid');

        return view('bookings.index', compact(
            'bookings',
            'search',
            'status',
            'paymentStatus',
            'totalBookings',
            'pendingBookings',
            'completedBookings',
            'totalRevenue'
        ));
    }

    public function create(Request $request)
    {
        $customers = Customer::where('is_active', true)->orderBy('name')->get();
        $businessUnits = BusinessUnit::where('is_active', true)->orderBy('name')->get();
        $selectedUnit = $request->integer('business_unit_id') ?: null;
        $selectedItem = null;

        if ($request->filled('business_item_id')) {
            $selectedItem = BusinessItem::where('is_active', true)
                ->with('businessUnit')
                ->findOrFail($request->integer('business_item_id'));
            $selectedUnit = $selectedItem->business_unit_id;
        }

        return view('bookings.create', compact('customers', 'businessUnits', 'selectedUnit', 'selectedItem'));
    }

    public function store(Request $request)
    {
        $validated = $this->validateBooking($request);

        if (!empty($validated['business_item_id'])) {
            $item = BusinessItem::where('is_active', true)->findOrFail($validated['business_item_id']);
            if ((int) $item->business_unit_id !== (int) $validated['business_unit_id']) {
                throw ValidationException::withMessages(['business_item_id' => 'Item tidak sesuai dengan unit bisnis yang dipilih.']);
            }
            // Harga dan nama item diambil dari database, bukan dari input browser.
            $validated['title'] = $item->name;
            $validated['description'] = $item->description;
            if ((float) $item->price > 0) {
                $validated['unit_price'] = $item->price;
            }
        }

        $validated['booking_code'] = $this->generateBookingCode();
        $validated['total_amount'] = $validated['quantity'] * $validated['unit_price'];
        $validated['amount_paid'] = $validated['amount_paid'] ?? 0;
        $this->validatePaymentAmount($validated['amount_paid'], $validated['total_amount']);
        $validated['payment_status'] = $this->determinePaymentStatus($validated['amount_paid'], $validated['total_amount']);

        Booking::create($validated);

        return redirect()->route('bookings.index')->with('success', 'Pesanan berhasil dibuat dan masuk ke Daftar Pesanan.');
    }

    public function show(Booking $booking)
    {
        $booking->load(['customer', 'businessUnit', 'businessItem']);

        return view('bookings.show', compact('booking'));
    }

    public function edit(Booking $booking)
    {
        $customers = Customer::where('is_active', true)
            ->orWhere('id', $booking->customer_id)
            ->orderBy('name')
            ->get();

        $businessUnits = BusinessUnit::where('is_active', true)
            ->orWhere('id', $booking->business_unit_id)
            ->orderBy('name')
            ->get();

        return view('bookings.edit', compact(
            'booking',
            'customers',
            'businessUnits'
        ));
    }

    public function update(Request $request, Booking $booking)
{
    $validated = $this->validateBooking($request);

    DB::transaction(function () use ($validated, $booking) {
        $currentBooking = Booking::whereKey($booking->id)
            ->lockForUpdate()
            ->firstOrFail();

        $totalAmount =
            $validated['quantity'] * $validated['unit_price'];

        // Periksa apakah unit bisnis berubah sementara
        // masih ada transaksi yang terhubung.
        $hasTransactions = Transaction::where(
            'booking_id',
            $currentBooking->id
        )->exists();

            if (
                $hasTransactions &&
                (int) $validated['business_unit_id'] !==
                (int) $currentBooking->business_unit_id
            ) {
                throw ValidationException::withMessages([
                    'business_unit_id' =>
                        'Unit bisnis tidak dapat diubah karena Booking sudah memiliki riwayat transaksi.',
                ]);
            }

            // Hitung pembayaran berdasarkan transaksi completed.
            $totalPaid = Transaction::where(
                'booking_id',
                $currentBooking->id
            )
                ->where('type', 'income')
                ->where('status', 'completed')
                ->sum('amount');

            if ((float) $totalPaid > (float) $totalAmount) {
                throw ValidationException::withMessages([
                    'unit_price' =>
                        'Total pesanan tidak boleh lebih kecil daripada jumlah pembayaran yang sudah tercatat.',
                ]);
            }

            $validated['total_amount'] = $totalAmount;
            $validated['amount_paid'] = $totalPaid;
            $validated['payment_status'] = $this->determinePaymentStatus(
                $totalPaid,
                $totalAmount
            );

            $currentBooking->update($validated);
        });

        return redirect()
            ->route('bookings.index')
            ->with('success', 'Pesanan berhasil diperbarui.');
    }

    public function destroy(Booking $booking)
    {
        $booking->delete();

        return redirect()
            ->route('bookings.index')
            ->with('success', 'Pesanan berhasil dihapus.');
    }

    private function validateBooking(Request $request): array
    {
        return $request->validate([
            'customer_id' => [
                'required',
                'integer',
                'exists:customers,id',
            ],
            'business_unit_id' => [
                'required',
                'integer',
                'exists:business_units,id',
            ],
            'business_item_id' => ['nullable', 'integer', 'exists:business_items,id'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'event_date' => ['nullable', 'date'],
            'location' => ['nullable', 'string'],
            'quantity' => ['required', 'integer', 'min:1'],
            'unit_price' => ['required', 'numeric', 'min:0'],
            'booking_status' => [
                'required',
                'in:pending,confirmed,in_progress,completed,cancelled',
            ],
            'notes' => ['nullable', 'string'],
        ]);
    }

    private function validatePaymentAmount(
        float|int|string $amountPaid,
        float|int|string $totalAmount
    ): void {
        if ((float) $amountPaid > (float) $totalAmount) {
            throw ValidationException::withMessages([
                'amount_paid' => 'Jumlah pembayaran tidak boleh melebihi total pesanan.',
            ]);
        }
    }

    private function determinePaymentStatus(
        float|int|string $amountPaid,
        float|int|string $totalAmount
    ): string {
        if ((float) $amountPaid <= 0) {
            return 'unpaid';
        }

        if ((float) $amountPaid >= (float) $totalAmount) {
            return 'paid';
        }

        return 'partial';
    }

    private function generateBookingCode(): string
    {
        do {
            $code = 'SIGA-' . now()->format('Ymd') . '-'
                . Str::upper(Str::random(6));
        } while (Booking::where('booking_code', $code)->exists());

        return $code;
    }
}
