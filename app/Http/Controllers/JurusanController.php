<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jurusan;
use App\Http\Resources\JurusanResource;
use App\Http\Requests\JurusanRequest;

class JurusanController extends Controller
{
    public function index()
    {
        try {
            $jurusans = Jurusan::paginate(50);
            return JurusanResource::collection($jurusans);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        try {
            $jurusan = Jurusan::findOrFail($id);
            return new JurusanResource($jurusan);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 404);
        }
    }

    public function store(JurusanRequest $request)
    {
        try {
            $data = $request->validated();
            $jurusan = Jurusan::create($data);
            return new JurusanResource($jurusan);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function update(JurusanRequest $request, $id)
    {
        try {
            $jurusan = Jurusan::findOrFail($id);
            $data = $request->validated();
            $jurusan->update($data);
            return new JurusanResource($jurusan);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $jurusan = Jurusan::findOrFail($id);
            $jurusan->delete();
            return response()->json(['message' => 'Data berhasil dihapus']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
