<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Filiere;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\Element_Module;
class UserController extends Controller
{
    // Afficher la liste des étudiants inscrits dans une filière spécifique
    public function indexEtudiant()
    {
        $etudiants = User::where('role', 'Etudiant')->get();
        return view('etudiants.index', ['etudiants' => $etudiants]);
    }


    // Afficher le formulaire de création d'un nouvel étudiant
    public function createEtudiant()
    {
        $filieres = Filiere::all();
        return view('etudiants.create', ['filieres' => $filieres]);

    }

    // Enregistrer un nouvel étudiant dans la base de données
    public function storeEtudiant(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'CNE' => 'required|unique:users',
            'date_de_naissance' => 'required',
            'filiere_id' => 'required',
            'photo' => 'required|image|mimes:jpg,png,gif'
        ]);

        $etudiant = new User();
        $etudiant->name = $request->input('name');
        $etudiant->email = $request->input('email');
        $etudiant->password = Hash::make($request->input('password'));
        $etudiant->role = 'Etudiant';
        $etudiant->CNE = $request->input('CNE');
        $etudiant->date_de_naissance = $request->input('date_de_naissance');
        $etudiant->filiere_id = $request->input('filiere_id');

        // enregistrement de la photo
        $image = $request->file('photo');
        $destinationPath = './img';
        $profilImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
        $image->move($destinationPath, $profilImage);
        $etudiant->photo = $profilImage;

        $etudiant->save();
        return redirect()->route('etudiants.index');
    }

    // Afficher les détails d'un étudiant spécifique
    public function showEtudiant($id)
    {
        $etudiant = User::where('role', 'Etudiant')->find($id);
        return view('etudiants.show', ['etudiant' => $etudiant]);
    }

    // Afficher le formulaire de modification d'un étudiant spécifique
    public function editEtudiant($id)
    {
        $etudiant = User::where('role', 'Etudiant')->find($id);
        $filieres = Filiere::all();
        return view('etudiants.edit', ['etudiant' => $etudiant, 'filieres' => $filieres]);
    }

    // Mettre à jour les informations d'un étudiant spécifique dans la base de données
    public function updateEtudiant(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'required|min:8',
            'CNE' => 'required|unique:users,CNE,' . $id,
            'date_de_naissance' => 'required',
            'filiere_id' => 'required',
            'photo' => 'nullable|image|mimes:jpg,png,gif'
        ]);

        $etudiant = User::find($id);
        $etudiant->name = $request->input('name');
        $etudiant->email = $request->input('email');
        $etudiant->password = Hash::make($request->input('password'));
        $etudiant->role = 'Etudiant';
        $etudiant->CNE = $request->input('CNE');
        $etudiant->date_de_naissance = $request->input('date_de_naissance');
        $etudiant->filiere_id = $request->input('filiere_id');

        // enregistrement de la photo
        if ($request->hasFile('photo')) {
            $image = $request->file('photo');
            $destinationPath = './img';
            $profilImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $profilImage);
            $etudiant->photo = $profilImage;
        }

        $etudiant->save();
        return redirect()->route('etudiants.show', ['id' => $id]);
    }
    public function destroyEtudiant($id)
    {
        $etudiant = User::find($id);
        Storage::delete($etudiant->photo);
        $etudiant->delete();
        return redirect()->route('etudiants.index');
    }
    public function indexAdministrateur()
    {
        $administrateurs = User::where('role', 'Admin')->get();
        return view('administrateurs.index', ['administrateurs' => $administrateurs]);
    }

    // Afficher le formulaire de création d'un nouvel administrateur
    public function createAdministrateur()
    {
        return view('administrateurs.create');
    }

    // Enregistrer un nouvel administrateur dans la base de données
    public function storeAdministrateur(Request $request)
    {

        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'photo' => 'required|image|mimes:jpg,png,gif'
        ]);

        $administrateur = new User();
        $administrateur->name = $request->input('name');
        $administrateur->email = $request->input('email');
        $administrateur->password = Hash::make($request->input('password'));
        $administrateur->role = 'Admin';

        // enregistrement de la photo
        $image = $request->file('photo');
        $destinationPath = './img';
        $profilImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
        $image->move($destinationPath, $profilImage);
        $administrateur->photo = $profilImage;

        $administrateur->save();
        return redirect()->route('administrateurs.index');
    }

    // Afficher les détails d'un administrateur spécifique
    public function showAdministrateur($id)
    {
        $administrateur = User::where('role', 'Admin')->find($id);
        return view('administrateurs.show', ['administrateur' => $administrateur]);
    }

    // Afficher le formulaire de modification d'un administrateur spécifique
    public function editAdministrateur($id)
    {
        $administrateur = User::where('role', 'Admin')->find($id);
        return view('administrateurs.edit', ['administrateur' => $administrateur]);
    }

    // Mettre à jour les informations d'un administrateur spécifique dans la base de données
    public function updateAdministrateur(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'required|min:8',
            'photo' => 'nullable|image|mimes:jpg,png,gif'
        ]);

        $administrateur = User::find($id);
        $administrateur->name = $request->input('name');
        $administrateur->email = $request->input('email');
        $administrateur->password = Hash::make($request->input('password'));
        $administrateur->role = 'Admin';

        // enregistrement de la photo
        if ($request->hasFile('photo')) {
            $image = $request->file('photo');
            $destinationPath = './img';
            $profilImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $profilImage);
            $administrateur->photo = $profilImage;
        }

        $administrateur->save();
        return redirect()->route('administrateurs.show', ['id' => $id]);
    }



    // Supprimer un administrateur spécifique de la base de données
    public function destroyAdministrateur($id)
    {
        $administrateur = User::where('role', 'Admin')->find($id);
        Storage::delete($administrateur->photo);
        $administrateur->delete();
        return redirect()->route('administrateurs.index');
    }
    public function indexProfesseur()
    {
        $professeurs = User::where('role', 'prof')->get();
        return view('professeurs.index', ['professeurs' => $professeurs]);
    }

    // Afficher le formulaire de création d'un nouveau professeur
    public function createProfesseur()
    {
        return view('professeurs.create');
    }

    // Enregistrer un nouveau professeur dans la base de données
    public function storeProfesseur(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'specialite' => 'required',
            'photo' => 'required|image|mimes:jpg,png,gif'
        ]);

        $professeur= new User();
        $professeur->name = $request->input('name');
        $professeur->email = $request->input('email');
        $professeur->password = Hash::make($request->input('password'));
        $professeur->role = 'prof';
        $professeur->specialite= $request->input('specialite');
        

        // enregistrement de la photo
        $image = $request->file('photo');
        $destinationPath = './img';
        $profilImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
        $image->move($destinationPath, $profilImage);
        $professeur->photo = $profilImage;

        $professeur->save();
        return redirect()->route('professeurs.index');

    }

    // Afficher les détails d'un professeur spécifique
    public function showProfesseur($id)
    {
        $professeur = User::where('role', 'prof')->find($id);
        return view('professeurs.show', ['professeur' => $professeur]);
    }

    // Afficher le formulaire de modification d'un professeur spécifique
    public function editProfesseur($id)
    {
        $professeur = User::where('role', 'prof')->find($id);
        return view('professeurs.edit', ['professeur' => $professeur]);
    }


    // Mettre à jour les informations d'un professeur spécifique dans la base de données
    public function updateProfesseur(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'required|min:8',
            'specialite' => 'required',
            'photo' => 'nullable|image|mimes:jpg,png,gif'
        ]);

        $professeur = User::find($id);
        $professeur->name = $request->input('name');
        $professeur->email = $request->input('email');
        $professeur->password = Hash::make($request->input('password'));
        $professeur->specialite = $request->input('specialite');
        $professeur->role = 'prof';

        // enregistrement de la photo
        if ($request->hasFile('photo')) {
            $image = $request->file('photo');
            $destinationPath = './img';
            $profilImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $profilImage);
            $professeur->photo = $profilImage;
        }

        $professeur->save();
        return redirect()->route('professeurs.show', ['id' => $id]);
    }


    public function destroyProfesseur($id)
    {
        $professeur = User::where('role', 'prof')->find($id);
        Storage::delete($professeur->photo);
        $professeur->delete();
        return redirect()->route('professeurs.index');
    }
    public function getStudentCount()
{
    $nombre_etudiants = User::where('role', 'etudiant')->count();
    $nombre_administrateurs = User::where('role', 'admin')->count();
    $nombre_professeurs= User::where('role', 'prof')->count();

    return view('backend.user.administrateur' ,compact('nombre_etudiants', 'nombre_professeurs', 'nombre_administrateurs'));
}
// UserController.php

public function getElementModuleByTeacher($id)
{
    $professeur = User::where('role', 'prof')->find($id);
    $element_modules = Element_Module::whereHas('user', function ($query) use ($professeur) {
        $query->where('user_id', $professeur->id);
    })->get();

    return view('professeurs.E-module', compact('professeur', 'element_modules'));
}






}