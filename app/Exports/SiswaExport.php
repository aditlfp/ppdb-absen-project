<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Models\Siswa;

class SiswaExport implements FromCollection, WithHeadings
{
	protected $siswa;

    public function __construct($siswa)
    {
        $this->siswa = $siswa;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
    	$no = 1;
    	
        return $this->siswa->map(function ($siswa)  use (&$no) {
        	// Kel.${siswa.kelurahan}, Kec.${siswa.kecamatan}, Kota.${siswa.kota}</td>
            return [
            	'No' => $no++,
                'Nama_Lengkap' => $siswa->nama_lengkap,
                'Kelas - Jurusan' => $siswa->kelas . '-' . $siswa->jurusan->name . '-' . $siswa->abjat,
                'Tlp' => $siswa->no_tlp,
                'Alamat_Lengkap' => 'Des. ' . $siswa->desa . ' / ' . 'RT' . $siswa->rt . ' / ' . 'RW' . $siswa->rw .', ' . 'Kel. ' . $siswa->kelurahan . ', ' . 'Kec. ' . $siswa->kecamatan . ', ' . 'Kota.' . $siswa->kota,
                'Orang Tua / Wali' => $siswa->nama_ortu,
                'No Tlp Ortu / Wali' => $siswa->no_tlp_ortu,
            ];
        });
    }

    public function headings(): array
    {
        return [
        	'No',
            'Nama_Lengkap',
            'Kelas - Jurusan',
            'Tlp',
            'Alamat_Lengkap',
            'Orang Tua / Wali',
            'No Tlp Ortu / Wali',
        ];
    }
}
