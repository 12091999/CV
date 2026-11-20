<?php

namespace Tests\Feature;

use App\Models\BusinessUnit;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TransactionHistoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_history_page_only_shows_transactions_for_the_selected_month(): void
    {
        $user = User::factory()->create();
        $businessUnit = BusinessUnit::create([
            'name' => 'Studio',
            'slug' => 'studio',
            'is_active' => true,
        ]);

        $this->createTransaction($businessUnit, $user, 'TRX-NOV-START', '2026-11-01');
        $this->createTransaction($businessUnit, $user, 'TRX-NOV-END', '2026-11-30');
        $this->createTransaction($businessUnit, $user, 'TRX-OCT', '2026-10-31');

        $response = $this->actingAs($user)
            ->get(route('transactions.history', ['month' => '2026-11']));

        $response->assertOk()
            ->assertSee('Riwayat Bulanan')
            ->assertSee('TRX-NOV-START')
            ->assertSee('TRX-NOV-END')
            ->assertDontSee('TRX-OCT')
            ->assertSee('Riwayat Transaksi')
            ->assertSee('value="2026-11"', false);
    }

    public function test_history_page_rejects_an_invalid_month(): void
    {
        $response = $this->actingAs(User::factory()->create())
            ->get(route('transactions.history', ['month' => '2026-13']));

        $response->assertSessionHasErrors('month');
    }

    private function createTransaction(
        BusinessUnit $businessUnit,
        User $user,
        string $code,
        string $date
    ): void {
        Transaction::create([
            'transaction_code' => $code,
            'business_unit_id' => $businessUnit->id,
            'type' => 'income',
            'category' => 'Pemasukan',
            'description' => $code,
            'amount' => 100000,
            'transaction_date' => $date,
            'status' => 'completed',
            'recorded_by' => $user->id,
        ]);
    }
}
