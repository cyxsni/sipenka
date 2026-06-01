<?php

namespace Database\Seeders;

use App\Models\KodePetunjuk;
use Illuminate\Database\Seeder;

class KodePetunjukSeeder extends Seeder
{
    public function run(): void
    {
        $kodes = [
            ['kode' => '800.1.11.2', 'nama' => 'Surat Cuti Sakit', 'deskripsi' => 'Surat keterangan cuti sakit'],
            ['kode' => '800.1.11.3', 'nama' => 'Surat Cuti Melahirkan', 'deskripsi' => 'Surat keterangan cuti melahirkan'],
            ['kode' => '800.1.11.4', 'nama' => 'Surat Cuti Tahunan', 'deskripsi' => 'Surat keterangan cuti tahunan'],
            ['kode' => '800.1.11.5', 'nama' => 'Surat Cuti Alasan Penting', 'deskripsi' => 'Surat cuti karena alasan penting'],
            ['kode' => '005.1.2.3', 'nama' => 'Surat Tugas', 'deskripsi' => 'Surat perintah tugas'],
            ['kode' => '045.2.1.1', 'nama' => 'Surat Undangan', 'deskripsi' => 'Surat undangan resmi'],
            ['kode' => '061.3.4.2', 'nama' => 'Surat Keterangan', 'deskripsi' => 'Surat keterangan umum'],
            ['kode' => '421.2.1.1', 'nama' => 'Surat Rekomendasi', 'deskripsi' => 'Surat rekomendasi'],
        ];

        foreach ($kodes as $kode) {
            KodePetunjuk::create($kode);
        }
    }
}