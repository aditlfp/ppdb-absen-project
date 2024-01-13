<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Resources\UserResource;
use App\Http\Requests\UserRequest;

class UserController extends Controller
{
    public function index()
    {
        try {
            $users = User::paginate(50);
            return UserResource::collection($users);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        try {
            $user = User::findOrFail($id);
            return new UserResource($user);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 404);
        }
    }

    public function store(UserRequest $request)
    {
        try {
            $data = $request->validated();
            $user = User::create($data);
            return new UserResource($user);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function update(UserRequest $request, $id)
    {
        try {
            $user = User::findOrFail($id);
            $data = $request->validated();
            $user->update($data);
            return new UserResource($user);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);
            $user->delete();
            return response()->json(['message' => 'Data berhasil dihapus']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
