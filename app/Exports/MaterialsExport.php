<?php

namespace App\Exports;

use App\Models\Material;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class MaterialsExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Material::all();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Nama Material',
            'Satuan',
            'Stok',
            'Created At',
            'Updated At',
            'Spesifikasi Foto',
            'Jenis Kebutuhan',
            'Lokasi',
            'Tempat',
        ];
    }
}
