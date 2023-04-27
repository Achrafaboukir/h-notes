<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;

use Illuminate\Http\Request;
use App\Models\Groupes;
use App\Models\Stagieres;



class StagieresController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $stagieres = Stagieres::all();
        return view('blades.stagieres.index' , ['stagieres'=>$stagieres]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $groupes = Groupes::all();
        return view('blades.stagieres.create' , compact('groupes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validatedData = $request->validate([
            'nom' => 'required',
            'prenom' => 'required',
            'idgroupe' => 'required|exists:groupes,id'
        ]);

        Stagieres::create($validatedData);

        return redirect()->route('stagieres.index')->with('success', 'Stagiere created successfully!');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $stagieres= Stagieres::findOrFail($id);
        return view('blades.stagieres.show' , ['stagieres'=>$stagieres]);

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $groupes = Groupes::all();
        $stagieres= Stagieres::findOrFail($id);
        return view('blades.stagieres.edit' , ['stagieres'=>$stagieres , 'groupes'=>$groupes]);
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
