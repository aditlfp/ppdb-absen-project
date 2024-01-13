<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Absen;
use App\Http\Resources\AbsenResource;
use App\Http\Requests\AbsenRequest;

class AbsenController extends Controller
{
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
