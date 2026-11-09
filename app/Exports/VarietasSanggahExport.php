<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class VarietasSanggahExport implements FromCollection, WithHeadings
{
    protected $data;

    public function __construct(Collection $data)
    {
        $this->data = $data;
    }
    public function headings(): array
    {
        return [
            'Tanggal Upload',
            'Kelompok Komoditas',
            'Komoditas',
            'Nama Varietas',
            'Nama Pemohon',
            'Pemulia',
            'Peneliti',
            'Upload Deskripsi',
        ];
    }
    public function collection()
    {
        return $this->data->map(function ($varietas) {
            return [
                $varietas->tanggal_entri,
                $varietas->kelkomoditas ? $varietas->kelkomoditas->nama_kelompok : 'N/A',
                $varietas->komoditas ? $varietas->komoditas->nama : 'N/A',
                $varietas->nama_varietas,
                $varietas->pemohon ? $varietas->pemohon->nama_produsen : 'N/A',
                $varietas->pemulia ? $varietas->pemulia : 'N/A',
                $varietas->peneliti,
                $varietas->upload_deskripsi,
            ];
        });
    }
}
