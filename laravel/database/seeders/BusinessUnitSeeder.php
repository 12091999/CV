<?php

namespace Database\Seeders;

use App\Models\BusinessUnit;
use Illuminate\Database\Seeder;

class BusinessUnitSeeder extends Seeder
{
    public function run(): void
    {
        // Pertahankan ID Music Services lama agar relasi booking/transaksi tetap aman.
        BusinessUnit::where('slug', 'music-services')->update([
            'name' => 'Music Equipment',
            'slug' => 'music-equipment',
            'description' => 'Penyediaan kebutuhan alat musik dan perlengkapan musik untuk pertunjukan maupun produksi.',
            'is_active' => true,
        ]);

        $businessUnits = [
            ['name' => 'Music Equipment', 'slug' => 'music-equipment', 'description' => 'Penyediaan kebutuhan alat musik dan perlengkapan musik untuk pertunjukan maupun produksi.', 'is_active' => true],
            ['name' => 'Event Organizer', 'slug' => 'event-organizer', 'description' => 'Layanan perencanaan, pengelolaan, dan pelaksanaan berbagai acara.', 'is_active' => true],
            ['name' => 'SIGA Merch', 'slug' => 'siga-merch', 'description' => 'Unit bisnis merchandise dan produk resmi SIGAPRODUCTION.', 'is_active' => true],
            ['name' => 'Event Properties', 'slug' => 'event-properties', 'description' => 'Penyediaan dan pengelolaan properti serta perlengkapan kebutuhan acara.', 'is_active' => true],
            ['name' => 'Studio Rental', 'slug' => 'studio-rental', 'description' => 'Layanan penyewaan studio musik untuk latihan, rekaman, dan kegiatan musik.', 'is_active' => true],
            ['name' => 'Equipment Rental', 'slug' => 'equipment-rental', 'description' => 'Penyewaan alat musik dan perlengkapan audio untuk berbagai kebutuhan.', 'is_active' => true],
            ['name' => 'Music Courses', 'slug' => 'music-courses', 'description' => 'Program kursus dan pembelajaran musik untuk berbagai tingkat kemampuan.', 'is_active' => true],
        ];

        foreach ($businessUnits as $unit) {
            BusinessUnit::updateOrCreate(['slug' => $unit['slug']], $unit);
        }
    }
}
