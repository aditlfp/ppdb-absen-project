<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AbsenResource extends JsonResource
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
            'jurusan_id' => $this->jurusan_id,
            'jurusan' => $this->jurusan,
            'kelas' => $this->kelas,
            'abjat' => $this->abjat,
            'tidak_masuk' => $this->tidak_masuk,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
