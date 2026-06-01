<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KodePetunjuk extends Model
{
    use HasFactory;

    protected $table = 'kode_petunjuk';
    
    protected $fillable = ['kode', 'nama', 'deskripsi'];
}
