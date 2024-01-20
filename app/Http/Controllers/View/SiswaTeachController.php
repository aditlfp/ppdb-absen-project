<?php

namespace App\Http\Controllers\View;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SiswaTeachController extends Controller
{
    public function index()
    {
        return view('Teach.Siswa.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Teach.Siswa.create');
    }

    public function edit()
    {
        return view('Teach.Siswa.edit');
    }
}
