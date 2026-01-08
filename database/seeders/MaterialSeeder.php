<?php

namespace Database\Seeders;

use App\Models\Material;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MaterialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Material::create([
            'nama_material' => 'Kabel NYY 4x16mm',
            'satuan' => 'Meter',
            'stok' => 1500,
        ]);

        Material::create([
            'nama_material' => 'Trafo 250 kVA',
            'satuan' => 'Unit',
            'stok' => 8,
        ]);
    }
}
