<?php

namespace App\Http\Controllers\View;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AbsensiController extends Controller
{
    public function index()
    {
        return view('Admin.Absen.index');
    }

    public function indexSiswa()
    {
    	return view('Siswa.DataAbsen.index');
    }
}
