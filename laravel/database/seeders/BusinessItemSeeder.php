<?php

namespace Database\Seeders;

use App\Models\BusinessItem;
use App\Models\BusinessUnit;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BusinessItemSeeder extends Seeder
{
    public function run(): void
    {
        $catalog = [
            'music-equipment' => [
                ['name' => 'Paket Gitar & Amplifier', 'description' => 'Paket kebutuhan gitar elektrik dan amplifier untuk latihan atau pertunjukan.', 'unit' => 'paket'],
                ['name' => 'Drum Set', 'description' => 'Perangkat drum untuk kebutuhan latihan dan penampilan musik.', 'unit' => 'set'],
                ['name' => 'Keyboard / Digital Piano', 'description' => 'Keyboard untuk latihan, panggung, dan kebutuhan produksi musik.', 'unit' => 'unit'],
                ['name' => 'Paket Instrumen Band', 'description' => 'Paket instrumen dasar untuk kebutuhan band.', 'unit' => 'paket'],
            ],
            'event-organizer' => [
                ['name' => 'Wedding Organizer', 'description' => 'Perencanaan dan koordinasi acara pernikahan.', 'unit' => 'acara'],
                ['name' => 'Corporate Event', 'description' => 'Pengelolaan gathering, seminar, launching, dan acara perusahaan.', 'unit' => 'acara'],
                ['name' => 'Music Concert', 'description' => 'Perencanaan dan pelaksanaan konser atau pertunjukan musik.', 'unit' => 'acara'],
                ['name' => 'Private Event', 'description' => 'Pengelolaan ulang tahun dan acara privat lainnya.', 'unit' => 'acara'],
            ],
            'siga-merch' => [
                ['name' => 'Kaos SIGA', 'description' => 'Kaos merchandise resmi SIGAPRODUCTION.', 'unit' => 'pcs'],
                ['name' => 'Hoodie SIGA', 'description' => 'Hoodie merchandise resmi SIGAPRODUCTION.', 'unit' => 'pcs'],
                ['name' => 'Totebag SIGA', 'description' => 'Totebag merchandise dengan identitas SIGAPRODUCTION.', 'unit' => 'pcs'],
                ['name' => 'Stiker Pack SIGA', 'description' => 'Paket stiker merchandise SIGAPRODUCTION.', 'unit' => 'paket'],
            ],
            'event-properties' => [
                ['name' => 'Panggung & Riser', 'description' => 'Properti panggung dan riser untuk kebutuhan acara.', 'unit' => 'paket'],
                ['name' => 'Lighting Event', 'description' => 'Perlengkapan tata cahaya untuk acara dan pertunjukan.', 'unit' => 'paket'],
                ['name' => 'Backdrop & Dekorasi', 'description' => 'Backdrop dan dekorasi sesuai konsep acara.', 'unit' => 'paket'],
                ['name' => ' meja & Kursi Event', 'description' => 'Penyediaan meja dan kursi untuk kebutuhan acara.', 'unit' => 'paket'],
            ],
            'studio-rental' => [
                ['name' => 'Studio Musik Reguler', 'description' => 'Sewa ruang latihan musik dengan perlengkapan standar.', 'unit' => 'jam'],
                ['name' => 'Studio Musik Premium', 'description' => 'Ruang latihan dengan fasilitas dan perlengkapan lebih lengkap.', 'unit' => 'jam'],
                ['name' => 'Studio Recording', 'description' => 'Sewa ruang dan fasilitas untuk kebutuhan rekaman.', 'unit' => 'jam'],
            ],
            'equipment-rental' => [
                ['name' => 'Sound System', 'description' => 'Paket tata suara untuk acara indoor maupun outdoor.', 'unit' => 'paket'],
                ['name' => 'Microphone Set', 'description' => 'Paket mikrofon kabel atau wireless untuk acara.', 'unit' => 'paket'],
                ['name' => 'Guitar & Bass Amplifier', 'description' => 'Sewa amplifier gitar atau bass.', 'unit' => 'unit'],
                ['name' => 'Lighting Set', 'description' => 'Paket lampu panggung dan perlengkapan pendukung.', 'unit' => 'paket'],
            ],
            'music-courses' => [
                ['name' => 'Kursus Gitar', 'description' => 'Kelas gitar untuk pemula hingga tingkat lanjutan.', 'unit' => 'sesi'],
                ['name' => 'Kursus Piano / Keyboard', 'description' => 'Kelas piano dan keyboard sesuai tingkat kemampuan.', 'unit' => 'sesi'],
                ['name' => 'Kursus Drum', 'description' => 'Kelas drum untuk teknik dasar hingga pengembangan permainan.', 'unit' => 'sesi'],
                ['name' => 'Kursus Vokal', 'description' => 'Kelas vokal, teknik pernapasan, dan pengembangan suara.', 'unit' => 'sesi'],
            ],
        ];

        foreach ($catalog as $unitSlug => $items) {
            $unit = BusinessUnit::where('slug', $unitSlug)->first();
            if (!$unit) continue;

            foreach ($items as $item) {
                BusinessItem::updateOrCreate(
                    ['business_unit_id' => $unit->id, 'slug' => Str::slug($item['name'])],
                    [
                        'name' => $item['name'],
                        'description' => $item['description'],
                        'price' => 0,
                        'unit_label' => $item['unit'],
                        'is_active' => true,
                    ]
                );
            }
        }
    }
}
