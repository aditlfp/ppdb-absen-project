<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Absen;
use App\Http\Resources\AbsenResource;
use App\Http\Requests\AbsenRequest;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\AbsenExport;


class AbsenController extends Controller
{

    public function exportToExcel(Request $request)
    {
        $jurusan_id = $request->jurusan_id;
        $kelas = $request->kelas;
        $abjat = $request->abjat;

        $siswa = Absen::where('jurusan_id', $jurusan_id)
            ->where('kelas', $kelas)
            ->where('abjat', $abjat)
            ->get();

        return Excel::download(new AbsenExport($siswa), 'absen.xlsx');
    }

    public function expdfAbsen(Request $request)
    {   

            $jurusan_id = $request->jurusan_id;
            $kelas = $request->kelas;
            $abjat = $request->abjat;

            $absen = Absen::where('jurusan_id', $jurusan_id)
                ->where('kelas', $kelas)
                ->where('abjat', $abjat)
                ->get();

            $options = new Options();
            $options->setIsHtml5ParserEnabled(true);
            $options->set('isRemoteEnabled', true);
            $options->set('defaultFont', 'Arial');

            $pdf = new Dompdf($options);
            $html = view('Admin.Absen.pdf', compact('absen'))->render();
            $pdf->loadHtml($html);

            $pdf->setPaper('A4', 'landscape');
            $pdf->render();

            $output = $pdf->output();
            $filename = 'absen.pdf';

            if ($request->input('action') == 'download') {
                return response()->download($output, $filename);
            }

            return response($output, 200)
                ->header('Content-Type', 'application/pdf')
                ->header('Content-Disposition', 'inline; filename="'.$filename.'"');

    }


    public function index()
    {
        try {
            $absens = Absen::paginate(50);
            return AbsenResource::collection($absens);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        try {
            $absen = Absen::findOrFail($id);
            return new AbsenResource($absen);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 404);
        }
    }

    public function store(AbsenRequest $request)
    {
        try {
            $data = $request->validated();
            $absen = Absen::create($data);
            return new AbsenResource($absen);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function update(AbsenRequest $request, $id)
    {
        try {
            $absen = Absen::findOrFail($id);
            $data = $request->validated();
            $absen->update($data);
            return new AbsenResource($absen);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $absen = Absen::findOrFail($id);
            $absen->delete();
            return response()->json(['message' => 'Data berhasil dihapus']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
