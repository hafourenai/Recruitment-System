<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PendaftarDetails extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'npm',
        'nama',
        'email',
        'nomor_hp',
        'program_studi',
        'ipk',
        'posisi',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function berkas()
    {
        return $this->hasMany(Berkas::class, 'pendaftar_id');
    }
}
