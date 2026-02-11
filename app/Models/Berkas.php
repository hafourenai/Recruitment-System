<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Berkas extends Model
{
    use HasFactory;

    protected $fillable = [
        'pendaftar_id',
        'jenis_berkas',
        'path',
        'original_name',
    ];

    public function pendaftar()
    {
        return $this->belongsTo(PendaftarDetails::class, 'pendaftar_id');
    }
}
