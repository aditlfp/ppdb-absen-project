<?php

namespace App\Http\Controllers;

use App\Http\Requests\SiswaRequest;
use App\Http\Resources\SiswaResource;
use Illuminate\Http\Request;
use App\Models\Siswa;
use Illuminate\Http\JsonResponse;

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
        return new SiswaResource($siswa);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
}

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
