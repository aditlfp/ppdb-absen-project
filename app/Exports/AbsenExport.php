<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Models\Absen;

class AbsenExport implements FromCollection, WithHeadings
{
	protected $absen;

    public function __construct($absen)
    {
        $this->absen = $absen;
    }
    /**
    * @return \Illuminate\Support\Collection
    */

    public function collection()
	{
	    $no = 1;

	    return $this->absen->map(function ($absen) use (&$no) {
	        $tidakMasukHtml = '';

	        if (is_string($absen->tidak_masuk)) {
	            try {
	                $tidakMasukArray = json_decode($absen->tidak_masuk, true);

	                if (is_array($tidakMasukArray)) {
	                    foreach ($tidakMasukArray as $data) {
	                        $tidakMasukHtml .= " Nama: {$data['nama']}, Keterangan: {$data['keterangan']} ";
	                    }
	                } else {
	                    $tidakMasukHtml = 'Invalid tidak_masuk data';
	                    \Log::error('Invalid tidak_masuk data format:', $tidakMasukArray);
	                }
	            } catch (\Exception $error) {
	                $tidakMasukHtml = 'Error parsing tidak_masuk JSON';
	                \Log::error('Error parsing tidak_masuk JSON:', ['data' => $absen->tidak_masuk, 'error' => $error->getMessage()]);
	            }
	        } else {
	            $tidakMasukHtml = 'Invalid tidak_masuk data';
	            \Log::error('Invalid tidak_masuk data format:', ['data' => $absen->tidak_masuk]);
	        }

	        return [
	            'No' => $no++,
	            'Kelas - Jurusan' => $absen->kelas . '-' . $absen->jurusan->name . '-' . $absen->abjat,
	            'Tidak Masuk' => $tidakMasukHtml
	        ];
	    });
	}


    public function headings(): array
    {
        return [
        	'No',
            'Kelas - Jurusan',
            'Tidak Masuk',
        ];
    }
}
