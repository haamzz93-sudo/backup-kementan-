<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class VarietasExport implements FromCollection, WithHeadings
{
    protected $data;

    public function __construct(Collection $data)
    {
        $this->data = $data;
    }
    public function headings(): array
    {
        return [
            'Kode',
            'No SK',
            'Kelompok Komoditas',
            'Komoditas',
            'Nama Varietas',
            'Nama Pemohon',
            'Tahun Daftar',
            'Upload Produk',
            'Upload Penciri',
            'Upload Deskripsi',
            'Wilayah Adaptasi',
            'Iklim',
            'Asal',
        ];
    }
    public function transformWilAdaptasi($wilAdaptasi)
    {
        // Check if $wilAdaptasi is an array
        if (is_array($wilAdaptasi)) {
            // Define a mapping of numbers to meanings
            $mapping = [
                1 => 'Dataran Rendah',
                2 => 'Dataran Menengah',
                3 => 'Dataran Tinggi',
            ];

            // Initialize an empty array to store the meanings
            $meanings = [];

            // Map each number to its meaning and store in the $meanings array
            foreach ($wilAdaptasi as $number) {
                if (isset($mapping[$number])) {
                    $meanings[] = $mapping[$number];
                }
            }

            // If there are no meanings, set a default value
            if (empty($meanings)) {
                return 'N/A';
            }

            // Return the meanings as a string
            return implode(', ', $meanings);
        }

        // If $wilAdaptasi is not an array, return 'N/A'
        return 'N/A';
    }
    public function transformiklim($iklim)
    {
        // Check if $wilAdaptasi is an array
        if (is_array($iklim)) {
            // Define a mapping of numbers to meanings
            $mapping = [
                1 => 'Musim Hujan',
                2 => 'Musim Kemarau',
            ];

            // Initialize an empty array to store the meanings
            $meanings = [];

            // Map each number to its meaning and store in the $meanings array
            foreach ($iklim as $number) {
                if (isset($mapping[$number])) {
                    $meanings[] = $mapping[$number];
                }
            }

            // If there are no meanings, set a default value
            if (empty($meanings)) {
                return 'N/A';
            }

            // Return the meanings as a string
            return implode(', ', $meanings);
        }

        // If $wilAdaptasi is not an array, return 'N/A'
        return 'N/A';
    }
    public function transformAsal($asal)
    {
        // Define a mapping of values to meanings
        $mapping = [
            1 => 'Introduksi',
            2 => 'Dalam Negeri',
        ];

        // Check if $asal is null
        if ($asal === null) {
            return 'N/A';
        }

        // Check if $asal is a valid key in the mapping
        if (isset($mapping[$asal])) {
            return $mapping[$asal];
        }

        // If $asal is not in the mapping, return 'N/A'
        return 'N/A';
    }
    public function collection()
    {
        return $this->data->map(function ($varietas) {
            return [
                $varietas->kode,
                $varietas->no_sk,
                $varietas->kelkomoditas ? $varietas->kelkomoditas->nama_kelompok : 'N/A',
                $varietas->komoditas ? $varietas->komoditas->nama : 'N/A',
                $varietas->nama_varietas,
                $varietas->pemohon ? $varietas->pemohon->nama_produsen : 'N/A',
                $varietas->tahun_daftar,
                $varietas->upload_produk,
                $varietas->upload_penciri,
                $varietas->upload_deskripsi,
                $this->transformWilAdaptasi($varietas->wil_adaptasi),
                $this->transformiklim($varietas->iklim),
                $this->transformAsal($varietas->asal),
            ];
        });
    }
}
