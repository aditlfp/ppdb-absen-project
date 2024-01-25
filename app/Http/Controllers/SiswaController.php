<?php

namespace App\Http\Controllers;

use App\Http\Requests\SiswaRequest;
use App\Http\Resources\SiswaResource;
use App\Models\Jurusan;
use Illuminate\Http\Request;
use App\Models\Siswa;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use League\Csv\Writer;
use League\Csv\CannotInsertRecord;
use League\Csv\CannotRetrieveEmptyField;
use League\Csv\CannotRetrieveFieldValue;

class SiswaController extends Controller
{
    // Method untuk menampilkan semua data siswa
    public function index()
{
    try {
        $siswa = Siswa::paginate(50);
        return SiswaResource::collection($siswa);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
}

public function show($id)
{
    try {
        $siswa = Siswa::findOrFail($id);
        return new SiswaResource($siswa);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 404);
    }
}

public function store(SiswaRequest $request)
{
    try {
        $data = $request->validated();

        $siswa = Siswa::create($data);
        $this->exportToCsv($data);
        return new SiswaResource($siswa);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
}


// Excel File
private function exportToCsv($siswas)
{
    // Create a CSV writer instance
    $csv = Writer::createFromString('');

    $jurusan = Jurusan::findOrFail($siswas['jurusan_id'])->first();

    // Insert CSV header
    $csv->insertOne(['nama_lengkap',
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
                    'kelas']);

    // Insert user data
        // dd($siswas['nama_lengkap']);
        try {
            $csv->insertOne([$siswas['nama_lengkap'], $siswas['no_tlp'], $siswas['desa'], $siswas['rt'], $siswas['rw'], $siswas['kelurahan'], $siswas['kecamatan'], $siswas['kota'], $siswas['nama_ortu'], $siswas['no_tlp_ortu'], $jurusan->name, $siswas['abjat'], $siswas['kelas']]);
        } catch (CannotInsertRecord  $e) {
            // Handle exceptions if needed
            // For example, log the error
            Log::error('CSV export error: ' . $e->getMessage());
            return $e->getMessage();
        }
    
    $csvFilePath = storage_path('app/users.csv');
    file_put_contents($csvFilePath, $csv->getContent());
    // Save CSV to a file (you can customize the file path)
    // $csv->output(Storage::('images', 'siswa.csv'));

}
// End Excel File

public function update(SiswaRequest $request, $id)
{
    try {
        $siswa = Siswa::findOrFail($id);

        $data = $request->validated();

        $siswa->update($data);
        return new SiswaResource($siswa);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
}

    // Method untuk menghapus data siswa berdasarkan ID
    public function destroy($id)
    {
        try {
            $siswa = Siswa::findOrFail($id);
            $siswa->delete();
            return response()->json(['message' => 'Data berhasil dihapus']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
