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
        // Step 1: Mendapatkan kunci dari endpoint login
        $loginResponse = Http::get('https://kalenderindonesia.com/api/login');

        // Cek apakah request ke endpoint login sukses
        if ($loginResponse->successful()) {
            // Mengambil kunci dari respons
            $key = $loginResponse->json('key');
            $now = Carbon::now()->month;

            // Step 2: Menggunakan kunci untuk mendapatkan data kalender
            $kalenderResponse = Http::get("https://kalenderindonesia.com/api/{$key}/kalender/masehi/2024/{$now}");

            // Cek apakah request ke endpoint kalender sukses
            if ($kalenderResponse->successful()) {
                // Mengambil data kalender dari respons
                $kalenderData = $kalenderResponse->json();

                // Menampilkan data kalender menggunakan view Blade
                    foreach ($kalenderData['data']['monthly']['daily'] as $daily) {

                            $nameDay3 = $daily['holiday'];
                            $nameDay2 = $daily['text']['W'];
                            if($nameDay2 == 'Ahad' || $nameDay2 == 'Sabtu' || $nameDay3 != null)
                            {
                                if ($daily['type'] == 'current') {
                                    echo '  '.$daily['text']['M']. '  '; // Change this to edit data 
                                }
                            }
                    }
                }
                // return view('kalender', ['kalenderData' => $kalenderData]);
            } else {
                // Handle jika request ke endpoint kalender tidak berhasil
                return response()->json(['error' => 'Gagal mengambil data kalender'], 500);
            }
       
         
        // return view('Admin.Jurusan.index');
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
