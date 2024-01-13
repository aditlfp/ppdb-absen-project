<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absen extends Model
{
    use HasFactory;

    protected $fillable = [
        'jurusan_id',
        'kelas',
        'abjat',
        'tidak_masuk'
    ];

    public function Jurusan()
    {
        return $this->belongsTo(Jurusan::class);
    }
}
