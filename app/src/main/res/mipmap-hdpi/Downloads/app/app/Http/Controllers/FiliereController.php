<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Filiere;
use App\Models\User;

class FiliereController extends Controller
{
    public function index()
    {
        $filieres = Filiere::all();
        return view('filieres.index', ['filieres' => $filieres]);
    }

    public function create()
    {
        return view('filieres.create');
    }

    public function store(Request $request)
    {
        
        $request->validate([
            'Nom' => 'required',
            'abriviation' => 'required',
            'Niveau' => 'required|min:1',
        ]);
        

        $filieres = new Filiere();
        $filieres->Nom = $request->input('Nom');
        $filieres->abriviation= $request->input('abriviation');
 
        $filieres->Niveau = $request->input('Niveau');

        
        $filieres->save();
        return redirect()->route('filiere.index');
    }

    public function show(Filiere $filiere)
    {
        return view('filieres.show', ['filiere' => $filiere]);
    }

    public function edit(Filiere $filiere)
    {
        return view('filieres.edit', ['filiere' => $filiere]);
    }

    public function update(Request $request, Filiere $filiere)
    {
        // Récupérer les données de la filière à partir de l'objet $filiere passé en paramètre
        $filieres= $filiere;
        
        // Mettre à jour les données de l'élément
        $filieres->update($request->all());
        
        // Rediriger vers la page de détails de l'élément
        return redirect()->route('filiere.show', ['filiere' => $filiere]);
    }
    
    

    public function destroy(Filiere $filiere)
    {
        $filiere->delete();
        return redirect()->route('filiere.index');
    }
    public function etudiants($id)
    {
        $filiere = Filiere::findOrFail($id);
        $etudiants = $filiere->etudiants()->where('role', 'Etudiant')->get();
    
        return view('filieres.etudiants', compact('filiere', 'etudiants'));
    }
    public function modules($id)
{
    $filiere = Filiere::find($id);
    $modules = $filiere->modules;
    return view('filieres.modules', compact('filiere', 'modules'));
}



}