<?php

namespace App\Http\Controllers\View;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class JurusanController extends Controller
{
    public function index()
    {
         
        return view('Admin.Jurusan.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Admin.Jurusan.create');
    }

    public function edit()
    {
        return view('Admin.Jurusan.edit');
    }
}
