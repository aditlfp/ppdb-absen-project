<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SiswaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nama_lengkap' => 'required|string|max:255',
            'no_tlp' => 'nullable|max:20',
            'desa' => 'nullable|max:255',
            'rt' => 'nullable|max:10',
            'rw' => 'nullable|max:10',
            'kelurahan' => 'nullable|max:255',
            'kecamatan' => 'nullable|max:255',
            'kota' => 'nullable|max:255',
            'nama_ortu' => 'nullable|max:255',
            'no_tlp_ortu' => 'nullable|max:20',
        ];
    }
}
