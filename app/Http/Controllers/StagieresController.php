<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;

use Illuminate\Http\Request;
use App\Models\Groupes;
use App\Models\Notes;
use App\Models\Seance;
use App\Models\User;
use App\Models\Stagieres;
use Illuminate\Support\Facades\DB;
use NunoMaduro\Collision\Adapters\Phpunit\State;

class StagieresController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        //
        $stagieres = Stagieres::paginate(10);
        return view('stagieres.index' , ['stagieres'=>$stagieres]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $groupes = Groupes::all();
        return view('stagieres.create' , compact('groupes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //

        $validation = Validator::make(
            $request->all(),
            [
                'nom' => 'required',
                'prenom' => 'required',
                'idgroupe' => 'required|exists:groupes,id',
                'pp_path' => 'image|mimes:jpeg,png,jpg,gif,svg',
                'email' => 'required|email|unique:users',
                'password' => 'required|min:8'
            ]
        );
        if ($validation->fails()){
            return back()->withErrors($validation->errors())->withInput();
        }
        $image = $request->file('pp_path');
        $imagePath = uniqid() . "" .  $image->getClientOriginalName();
        $image->move(public_path('profile_pictures'), $imagePath);

        $data = $request->all();
        $data['pp_path'] = $imagePath;


        $userData = ['name'=> $validatedData['nom'], 'email'=> $validatedData['email'], 'password' => Hash::make($validatedData['password'])];
        $user = User::create($userData);
        $user->assignRole('stagiaire');
        Stagieres::create($data);

        return redirect()->route('stagieres.index')->with('success', 'Stagiere created successfully!');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $notes = Notes::where('idstagiere', $id)->get();
        $stagieres= Stagieres::findOrFail($id);
        $modules = DB::table('modules')
        ->join('fillieres', 'modules.idFilliere', '=', 'fillieres.id')
        ->join('groupes' , 'groupes.idFilliere' , '=' , 'fillieres.id')
        ->join('stagieres', 'stagieres.idgroupe', '=', 'groupes.id')
        ->where('stagieres.id', $id)
        ->select('modules.*')
        ->get();
        $seances = Seance::join('groupes', 'groupes.id', '=', 'seances.idGroupe')
                     ->join('stagieres', 'stagieres.idgroupe', '=', 'groupes.id')
                     ->where('stagieres.id', '=', $id)
                     ->get(['seances.*']);
                     $section = '';
        return view('stagieres.show' , ['stagieres'=>$stagieres, 'modules'=>$modules , 'notes'=>$notes ,'seances'=>$seances , 'section'=>$section]);

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $groupes = Groupes::all();
        $stagieres= Stagieres::findOrFail($id);
        return view('stagieres.edit' , ['stagieres'=>$stagieres , 'groupes'=>$groupes]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $stagiere= Stagieres::findOrFail($id);

        $validatedData = $request->validate([
            'nom' => 'required',
            'prenom' => 'required',
            'idgroupe' => 'required|exists:groupes,id'
        ]);

        $stagiere->update($validatedData);

        return redirect()->route('stagieres.index')->with('success', 'Stagiere updated successfully!');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $stagiere= Stagieres::findOrFail($id);

        $stagiere->delete();

        return redirect()->route('stagieres.index')->with('success', 'Stagiere deleted successfully!');

    }
}
