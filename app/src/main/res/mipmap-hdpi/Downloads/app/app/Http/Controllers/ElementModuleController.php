<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Element_Module;
use App\Models\Module;
use App\Models\User;

class ElementModuleController extends Controller
{
    public function create()
    {
        $modules = Module::all();
        $professeurs = User::where('role', 'prof')->get();

        return view('element_modules.create', compact('modules', 'professeurs'));
    }

    public function store(Request $request)
{
    $element_module = new Element_Module;
    $element_module->Code = $request->input('Code');
    $element_module->Nom = $request->input('Nom');
    $element_module->coifficent = $request->input('coifficent');
    $element_module->module_id = $request->input('module');
    $element_module->user_id = $request->input('user_id');
    $element_module->save();

    return redirect()->route('element_modules.index')->with('success', 'L\'élément de module a été ajouté avec succès');
}


    public function index()
    {
        $element_modules = Element_Module::all();

        return view('element_modules.index', compact('element_modules'));
    }

    public function show(Element_Module $element_module)
    {
        return view('element_modules.show', compact('element_module'));
    }

    public function edit(Element_Module $element_module)
    {
        $modules = Module::all();
        $professeurs = User::where('role', 'prof')->get();

        return view('element_modules.edit', compact('element_module', 'modules', 'professeurs'));
    }

    public function update(Request $request, $id)
{
    // Récupérer l'élément à mettre à jour
    $element_module = Element_Module::findOrFail($id);
    
    // Mettre à jour les données de l'élément
    $element_module->update($request->all());
    
    // Rediriger vers la page de détails de l'élément
    return redirect()->route('element_modules.show', ['element_module' => $element_module]);
}


    public function destroy(Element_Module $element_module)
    {
        $element_module->delete();

        return redirect()->route('element_modules.index')
            ->with('success', 'Element de module supprimé avec succès.');
    }
}
