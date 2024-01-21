<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SiswaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'nama_lengkap' => $this->nama_lengkap,
            'no_tlp' => $this->no_tlp,
            'desa' => $this->desa,
            'rt' => $this->rt,
            'rw' => $this->rw,
            'kelurahan' => $this->kelurahan,
            'kecamatan' => $this->kecamatan,
            'kota' => $this->kota,
            'nama_ortu' => $this->nama_ortu,
            'no_tlp_ortu' => $this->no_tlp_ortu,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'jurusan_id' => $this->jurusan_id,
            'jurusan' => $this->jurusan,
            'abjat' => $this->abjat,
            'kelas' => $this->kelas
        ];
    }
}
