<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratKeluar extends Model
{
    use HasFactory;

    protected $table = 'surat_keluar';

    protected $fillable = [
        'user_id',
        'jenis_surat',
        'tujuan',
        'tanggal_surat',
        'nomor_surat',
        'perihal',
        'kode_petunjuk',
        'keterangan',
        'status',
    ];

    protected $casts = [
        'tanggal_surat' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}