<?php

namespace App\Http\Controllers;

use App\Models\Module;
use Illuminate\Http\Request;
use App\Models\Filiere;
use App\Models\Element_Module;
class ModuleController extends Controller
{
    public function index()
    {
        $modules = Module::all();

        return view('modules.index', compact('modules'));
    }

    public function create()
    {
        $filieres = Filiere::all();
        return view('modules.create')->with('filieres', $filieres);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'Code' => 'required|unique:modules',
            'Nom' => 'required',
            'filiere_id' => 'required|exists:filieres,id',
            'semestre'=>'required',
            
        ]);

        Module::create($validatedData);

        return redirect()->route('modules.index')->with('success', 'Module créé avec succès');
    }

    public function show(Module $module)
    {
        return view('modules.show', compact('module'));
    }
    public function edit(Module $module)
    {
        $filieres = Filiere::all();
        return view('modules.edit', compact('module', 'filieres'));
    }
    

    public function update(Request $request, Module $module)
{
    $validatedData = $request->validate([
        'Code' => 'required|string|max:255|unique:modules,Code,' . $module->id,
        'Nom' => 'required|string|max:255',
        'filiere_id' => 'required|integer|exists:filieres,id',
        // Ajoutez les règles de validation pour d'autres colonnes si nécessaire
        'semestre' => 'required',

    ]);

    $module->update($validatedData);

    return redirect()->route('modules.show', ['module' => $module]);
}


    

    public function destroy(Module $module)
    {
        $module->delete();

        return redirect()->route('modules.index')->with('success', 'Module supprimé avec succès');
    }
    public function getElementModuleByModule($id)
{
    $module = Module::find($id);
    $element_modules = $module->element_modules;

    return view('modules.E-module', compact('module', 'element_modules'));
}

}