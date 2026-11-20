<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\BusinessUnit;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;

class TransactionController extends Controller
{
    /**
     * Menampilkan daftar transaksi.
     */
    public function index(Request $request)
    {
        $query = Transaction::with([
            'booking.customer',
            'businessUnit',
            'recorder',
        ]);

        // Pencarian transaksi
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('transaction_code', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('reference_number', 'like', "%{$search}%")
                    ->orWhereHas('booking', function ($booking) use ($search) {
                        $booking->where('booking_code', 'like', "%{$search}%");
                    });
            });
        }

        // Filter jenis transaksi
        if (in_array($request->type, ['income', 'expense'], true)) {
            $query->where('type', $request->type);
        }

        // Filter status
        if (in_array($request->status, ['completed', 'voided'], true)) {
            $query->where('status', $request->status);
        }

        // Filter unit bisnis
        if ($request->filled('business_unit_id')) {
            $query->where(
                'business_unit_id',
                $request->business_unit_id
            );
        }

        // Filter periode
        if ($request->filled('start_date')) {
            $query->whereDate(
                'transaction_date',
                '>=',
                $request->start_date
            );
        }

        if ($request->filled('end_date')) {
            $query->whereDate(
                'transaction_date',
                '<=',
                $request->end_date
            );
        }

        $transactions = $query
            ->latest('transaction_date')
            ->latest('id')
            ->paginate(15)
            ->withQueryString();

        $baseQuery = Transaction::where('status', 'completed');

        $totalIncome = (clone $baseQuery)
            ->where('type', 'income')
            ->sum('amount');

        $totalExpense = (clone $baseQuery)
            ->where('type', 'expense')
            ->sum('amount');

        $netIncome = $totalIncome - $totalExpense;

        $businessUnits = BusinessUnit::orderBy('name')->get();

        return view('transactions.index', compact(
            'transactions',
            'totalIncome',
            'totalExpense',
            'netIncome',
            'businessUnits'
        ));
    }

    /**
     * Menampilkan riwayat transaksi untuk satu bulan.
     */
    public function history(Request $request)
    {
        $validated = $request->validate([
            'month' => ['nullable', 'date_format:Y-m'],
        ]);

        $month = $validated['month'] ?? now()->format('Y-m');
        $monthDate = Carbon::createFromFormat('!Y-m', $month);
        $startOfMonth = $monthDate->copy()->startOfMonth()->toDateString();
        $startOfNextMonth = $monthDate->copy()->addMonth()->startOfMonth()->toDateString();

        $transactions = Transaction::with([
            'booking.customer',
            'businessUnit',
            'recorder',
        ])
            ->where('transaction_date', '>=', $startOfMonth)
            ->where('transaction_date', '<', $startOfNextMonth)
            ->latest('transaction_date')
            ->latest('id')
            ->paginate(15)
            ->withQueryString();

        $completedTransactions = Transaction::where('status', 'completed')
            ->where('transaction_date', '>=', $startOfMonth)
            ->where('transaction_date', '<', $startOfNextMonth);

        $totalIncome = (clone $completedTransactions)
            ->where('type', 'income')
            ->sum('amount');

        $totalExpense = (clone $completedTransactions)
            ->where('type', 'expense')
            ->sum('amount');

        $netIncome = $totalIncome - $totalExpense;

        return view('transactions.history', [
            'transactions' => $transactions,
            'month' => $month,
            'monthLabel' => $monthDate->locale('id')->translatedFormat('F Y'),
            'totalIncome' => $totalIncome,
            'totalExpense' => $totalExpense,
            'netIncome' => $netIncome,
        ]);
    }

    /**
     * Form tambah transaksi.
     */
    public function create()
    {
        $businessUnits = BusinessUnit::where('is_active', true)
            ->orderBy('name')
            ->get();

        $bookings = Booking::with('customer', 'businessUnit')
            ->whereIn('booking_status', [
                'pending',
                'confirmed',
                'in_progress',
            ])
            ->orderByDesc('created_at')
            ->get();

        return view('transactions.create', compact(
            'businessUnits',
            'bookings'
        ));
    }


    /**
     * Menyimpan transaksi baru.
     */
    public function store(Request $request)
    {
        $data = $this->validateTransaction($request);

        DB::transaction(function () use ($data, $request) {

            $booking = null;

            if (!empty($data['booking_id'])) {
                $booking = Booking::whereKey($data['booking_id'])
                    ->lockForUpdate()
                    ->firstOrFail();

                $this->validateBookingTransaction($data, $booking);
            }

            $transaction = Transaction::create([
                ...$data,
                'status' => 'completed',
                'transaction_code' => $this->generateTransactionCode(),
                'recorded_by' => $request->user()->id,
            ]);

            if ($booking) {
                $this->syncBookingPayment($booking);
            }
        });

        return redirect()
            ->route('transactions.index')
            ->with('success', 'Transaksi berhasil ditambahkan.');
    }


    /**
     * Menampilkan detail transaksi.
     */
    public function show(Transaction $transaction)
    {
        $transaction->load([
            'booking.customer',
            'booking.businessUnit',
            'businessUnit',
            'recorder',
        ]);

        return view('transactions.show', compact('transaction'));
    }

    
        /**
         * Form edit transaksi.
         */
        public function edit(Transaction $transaction)
        {
            if ($transaction->status === 'voided') {
                return redirect()
                    ->route('transactions.index')
                    ->withErrors([
                        'transaction' => 'Transaksi yang sudah dibatalkan tidak dapat diedit.',
                    ]);
            }

            $businessUnits = BusinessUnit::orderBy('name')->get();

            $bookings = Booking::with('customer', 'businessUnit')
                ->orderByDesc('created_at')
                ->get();

            return view('transactions.edit', compact(
                'transaction',
                'businessUnits',
                'bookings'
            ));
        }

    /**
     * Memperbarui transaksi.
     */
    public function update(
        Request $request,
        Transaction $transaction
    ) {
        $data = $this->validateTransaction($request);

        DB::transaction(function () use ($data, $transaction) {

            
            $currentTransaction = Transaction::whereKey($transaction->id)
                ->lockForUpdate()
                ->firstOrFail();

            if ($currentTransaction->status === 'voided') {
                throw ValidationException::withMessages([
                    'transaction' => 'Transaksi yang sudah dibatalkan tidak dapat diubah.',
                ]);
            }

            $oldBookingId = $currentTransaction->booking_id;


            $bookingIds = array_filter([
                $oldBookingId,
                $data['booking_id'] ?? null,
            ]);

            $bookings = Booking::whereIn('id', $bookingIds)
                ->orderBy('id')
                ->lockForUpdate()
                ->get()
                ->keyBy('id');

            $newBooking = null;

            if (!empty($data['booking_id'])) {
                $newBooking = $bookings->get($data['booking_id']);

                if (!$newBooking) {
                    throw ValidationException::withMessages([
                        'booking_id' => 'Booking tidak ditemukan.',
                    ]);
                }

                $this->validateBookingTransaction(
                    $data,
                    $newBooking,
                    $currentTransaction->id
                );
            }

            $currentTransaction->update($data);

            // Perbarui booking lama jika relasinya berubah
            if ($oldBookingId) {
                $oldBooking = $bookings->get($oldBookingId);

                if ($oldBooking) {
                    $this->syncBookingPayment($oldBooking);
                }
            }

            // Perbarui booking baru
            if ($newBooking) {
                $this->syncBookingPayment($newBooking);
            }
        });

        return redirect()
            ->route('transactions.index')
            ->with('success', 'Transaksi berhasil diperbarui.');
    }

    /**
     * Membatalkan transaksi tanpa menghapus riwayat.
     */
    public function destroy(Transaction $transaction)
    {
        DB::transaction(function () use ($transaction) {

            $currentTransaction = Transaction::whereKey($transaction->id)
                ->lockForUpdate()
                ->firstOrFail();

            if ($currentTransaction->status === 'voided') {
                throw ValidationException::withMessages([
                    'transaction' => 'Transaksi ini sudah dibatalkan.',
                ]);
            }

            $booking = null;

            if ($currentTransaction->booking_id) {
                $booking = Booking::whereKey(
                    $currentTransaction->booking_id
                )->lockForUpdate()->firstOrFail();
            }

            $currentTransaction->update([
                'status' => 'voided',
            ]);

            if ($booking) {
                $this->syncBookingPayment($booking);
            }
        });

        return redirect()
            ->route('transactions.index')
            ->with('success', 'Transaksi berhasil dibatalkan.');
    }

    /**
     * Validasi input transaksi.
     */
    private function validateTransaction(Request $request): array
    {
        $amount = $request->input('amount');

        if ($amount !== null && $amount !== '') {
            $request->merge([
                'amount' => preg_replace('/\D/', '', (string) $amount),
            ]);
        }

        $data = $request->validate([
            'booking_id' => [
                'nullable',
                'integer',
                'exists:bookings,id',
            ],

            'business_unit_id' => [
                'required',
                'integer',
                'exists:business_units,id',
            ],

            'type' => [
                'required',
                'in:income,expense',
            ],

            'category' => [
                'required',
                'string',
                'max:100',
            ],

            'description' => [
                'required',
                'string',
                'max:255',
            ],

            'amount' => [
                'required',
                'integer',
                'gt:0',
                'max:900000000000',
            ],

            'transaction_date' => [
                'required',
                'date',
            ],

            'payment_method' => [
                'nullable',
                'in:cash,transfer,credit_card,debit_card,e_wallet,other',
            ],

            'reference_number' => [
                'nullable',
                'string',
                'max:255',
            ],


            'notes' => [
                'nullable',
                'string',
            ],
        ]);

        // Pembayaran booking wajib berupa income
        if (
            !empty($data['booking_id']) &&
            $data['type'] !== 'income'
        ) {
            throw ValidationException::withMessages([
                'type' => 'Transaksi yang terhubung dengan booking harus berupa pemasukan.',
            ]);
        }

        return $data;
    }

    /**
     * Memastikan transaksi booking valid.
     */
    private function validateBookingTransaction(
        array $data,
        Booking $booking,
        ?int $ignoreTransactionId = null
    ): void {
        if (
            (int) $data['business_unit_id'] !==
            (int) $booking->business_unit_id
        ) {
            throw ValidationException::withMessages([
                'business_unit_id' => 'Unit bisnis harus sama dengan unit bisnis booking.',
            ]);
        }

        if ($data['type'] !== 'income') {
            throw ValidationException::withMessages([
                'type' => 'Booking hanya dapat dihubungkan dengan transaksi pemasukan.',
            ]);
        }

        // Hitung pembayaran completed lainnya
        $existingPayments = Transaction::where(
            'booking_id',
            $booking->id
        )
            ->where('type', 'income')
            ->where('status', 'completed')
            ->when(
                $ignoreTransactionId,
                fn ($query) => $query->where(
                    'id',
                    '!=',
                    $ignoreTransactionId
                )
            )
            ->sum('amount');

        $newPayment = (int) $data['amount'];
        $totalPaid = (int) round((float) $existingPayments) + $newPayment;

        if ($totalPaid > (int) round((float) $booking->total_amount)) {
            throw ValidationException::withMessages([
                'amount' => 'Total pembayaran melebihi sisa tagihan booking.',
            ]);
        }
    }

    /**
     * Sinkronisasi pembayaran ke tabel bookings.
     */
    private function syncBookingPayment(Booking $booking): void
    {
        $totalPaid = (int) round((float) Transaction::where('booking_id', $booking->id)
            ->where('type', 'income')
            ->where('status', 'completed')
            ->sum('amount'));

        $totalAmount = (int) round((float) $booking->total_amount);

        if ($totalPaid > $totalAmount) {
            throw ValidationException::withMessages([
                'amount' => 'Total pembayaran booking melebihi total tagihan.',
            ]);
        }

        if ($totalPaid <= 0) {
            $paymentStatus = 'unpaid';
        } elseif ($totalPaid < $totalAmount) {
            $paymentStatus = 'partial';
        } else {
            $paymentStatus = 'paid';
        }

        $booking->update([
            'amount_paid' => $totalPaid,
            'payment_status' => $paymentStatus,
        ]);
    }

    /**
     * Membuat kode transaksi unik.
     */
    private function generateTransactionCode(): string
    {
        do {
            $code = 'TRX-' . now()->format('Ymd') . '-' .
                strtoupper(Str::random(6));
        } while (
            Transaction::where('transaction_code', $code)->exists()
        );

        return $code;
    }
}
