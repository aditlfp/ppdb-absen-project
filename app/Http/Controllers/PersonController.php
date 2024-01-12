<?php

namespace App\Http\Controllers;

use App\Http\Resources\PersonResource;
use App\Models\Person;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use League\Csv\Writer;
use League\Csv\Reader;

class PersonController extends Controller
{
    // $barang = DB::table('barangs')->when($request->search, function ($query, $search){
    //     $query->where('nama_barang', 'LIKE', '%' . $search . '%');
    // })->paginate(50);
    // return BarangResource::collection($barang);
    public function index(Request $request)
    {
        $people = DB::table('people')->when($request->search, function ($query, $search){
                $query->where('name', 'LIKE', '%' . $search . '%');
            })->paginate(50);
        return PersonResource::collection($people);
    }

    public function store(Request $request)
    {
        $person = new Person([
            'name' => $request->input('name'),
            'age' => $request->input('age'),
        ]);
        $person->save();

        $this->saveDataToCSV();

        return response()->json(['data' => $person, 'message' => 'Data Has Been Saved !'], 200);
    }

    public function edit($id)
    {
        $person = Person::findOrFail($id);
        return new PersonResource($person);
    }

    public function update(Request $request, $id)
    {
        $person = Person::findOrFail($id);
        $person->name = $request->input('name');
        $person->age = $request->input('age');
        $person->save();

        $this->saveDataToCSV();

        return response()->json(['data' => $person, 'message' => 'Data Has Been Updated !'], 200);
    }

    public function destroy($id)
    {
        $person = Person::destroy($id);

        $this->saveDataToCSV();

        return response()->json(['data' => $person, 'message' => 'Data Has Been Deleted !'], 200);
    }

    private function saveDataToCSV()
    {
        $people = Person::all(['id', 'name', 'age']);

        $csv = Writer::createFromPath(storage_path('app/people.csv'), 'w+');
        $csv->insertOne(['id', 'name', 'age']);

        foreach ($people as $person) {
            $csv->insertOne([$person->id,      $person->name,     $person->age]);
        }
    }
}
