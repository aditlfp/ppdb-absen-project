<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_lengkap',
        'no_tlp',
        'desa',
        'rt',
        'rw',
        'kelurahan',
        'kecamatan',
        'kota',
        'nama_ortu',
        'no_tlp_ortu',
        'jurusan_id',
        'abjat',
        'kelas'
    ];

    public function Jurusan()
    {
        return $this->belongsTo(Jurusan::class);
    }
}
