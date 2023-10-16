<?php

namespace App\Http\Controllers\backend;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function noteSemestre()
    { // Get the notes and module count for semester 1

        $notesS1 = DB::table('notes')
            ->join('users', 'notes.user_id', '=', 'users.id')
            ->join('element__modules', 'notes.element_id', '=', 'element__modules.id')
            ->join('modules', 'element__modules.module_id', '=', 'modules.id')
            ->join('filieres', 'modules.filiere_id', '=', 'filieres.id')
            ->where('users.id', '=', auth()->user()->id)
            ->where('modules.semestre', '=', 'S1')
            ->select('modules.Nom as module_name', 'notes.annee_universitaire as annee', 'filieres.Nom as filiere', DB::raw('SUM(notes.note * element__modules.coifficent) AS module_note'), 'notes.session as session')
            ->groupBy('modules.id', 'modules.Nom', 'notes.session', 'filiere', 'annee')
            ->get();
        $moduleCountS1 = DB::table('notes')
            ->join('users', 'notes.user_id', '=', 'users.id')
            ->join('element__modules', 'notes.element_id', '=', 'element__modules.id')
            ->join('modules', 'element__modules.module_id', '=', 'modules.id')
            ->where('users.id', '=', auth()->user()->id)
            ->where('modules.semestre', '=', 'S1')
            ->select(DB::raw('COUNT(DISTINCT modules.id) as count'))
            ->first();

        $user = DB::table('notes')
            ->join('users', 'notes.user_id', '=', 'users.id')
            ->join('element__modules', 'notes.element_id', '=', 'element__modules.id')
            ->join('modules', 'element__modules.module_id', '=', 'modules.id')
            ->join('filieres', 'modules.filiere_id', '=', 'filieres.id')
            ->where('users.id', '=', auth()->user()->id)
            ->select('notes.annee_universitaire as annee', 'filieres.abriviation as filiere')
            ->get();

        // Get the notes and module count for semester 2
        $notesS2 = DB::table('notes')
            ->join('users', 'notes.user_id', '=', 'users.id')
            ->join('element__modules', 'notes.element_id', '=', 'element__modules.id')
            ->join('modules', 'element__modules.module_id', '=', 'modules.id')
            ->join('filieres', 'modules.filiere_id', '=', 'filieres.id')
            ->where('users.id', '=', auth()->user()->id)
            ->where('modules.semestre', '=', 'S2')
            ->select('modules.Nom as module_name', 'notes.annee_universitaire as annee', 'filieres.Nom as filiere', DB::raw('SUM(notes.note * element__modules.coifficent) AS module_note'), 'notes.session as session')
            ->groupBy('modules.id', 'modules.Nom', 'notes.session', 'filiere', 'annee')
            ->get();
        $moduleCountS2 = DB::table('notes')
            ->join('users', 'notes.user_id', '=', 'users.id')
            ->join('element__modules', 'notes.element_id', '=', 'element__modules.id')
            ->join('modules', 'element__modules.module_id', '=', 'modules.id')
            ->where('users.id', '=', auth()->user()->id)
            ->where('modules.semestre', '=', 'S2')
            ->select(DB::raw('COUNT(DISTINCT modules.id) as count'))
            ->first();


        return view('backend.user.noteSemestre', compact('notesS1', 'notesS2', 'moduleCountS1', 'moduleCountS2', 'user'))
        ;


    }


    public function Allstudent($id)
    {

        $notes = DB::table('users')
            ->join('filieres', 'users.filiere_id', '=', 'filieres.id')
            ->join('modules', 'filieres.id', '=', 'modules.filiere_id')
            ->join('element__modules', 'modules.id', '=', 'element__modules.module_id')
            ->leftJoin('notes', function ($join) use ($id) {
                $join->on('notes.user_id', '=', 'users.id')
                    ->where('notes.element_id', '=', $id);
            })
            ->where('element__modules.id', '=', $id)
            ->select(

                'users.id as id_user',
                'element__modules.id as id_element',
                'filieres.abriviation as filiere'
                ,
                'notes.note',
                'users.name as user',
                'users.CNE as CNE'
            )
            ->distinct()
            ->get();

        return view('backend.user.prof', compact('notes'));
    }
    public function export($id)
    {
        $notes = DB::table('users')
            ->join('filieres', 'users.filiere_id', '=', 'filieres.id')
            ->join('modules', 'filieres.id', '=', 'modules.filiere_id')
            ->join('element__modules', 'modules.id', '=', 'element__modules.module_id')
            ->leftJoin('notes', function ($join) use ($id) {
                $join->on('notes.user_id', '=', 'users.id')
                    ->where('notes.element_id', '=', $id);
            })
            ->where('element__modules.id', '=', $id)
            ->select(
                'users.id as id_user',
                'element__modules.id as id_element',
                'filieres.abriviation as filiere'
                ,
                'users.name as user',
                'users.CNE as CNE',
                'notes.note'
            )->get();

        $note = DB::table('users')
            ->join('filieres', 'users.filiere_id', '=', 'filieres.id')
            ->join('modules', 'filieres.id', '=', 'modules.filiere_id')
            ->join('element__modules', 'modules.id', '=', 'element__modules.module_id')
            ->leftJoin('notes', function ($join) use ($id) {
                $join->on('notes.user_id', '=', 'users.id')
                    ->where('notes.element_id', '=', $id);
            })
            ->where('element__modules.id', '=', $id)
            ->select(
                'filieres.abriviation as filiere',
                'element__modules.nom as element'
            )->first();

        return view('backend.user.export', compact('notes', 'note'))->with('id', $id);
    }

    public function noteEtud($id_S)
    {
        $notes = DB::table('notes')
            ->join('users', 'notes.user_id', '=', 'users.id')
            ->join('element__modules', 'notes.element_id', '=', 'element__modules.id')
            ->join('modules', 'element__modules.module_id', '=', 'modules.id')
            ->join('filieres', 'modules.filiere_id', '=', 'filieres.id')
            ->where('users.id', '=', auth()->user()->id)
            ->where('modules.semestre', '=', $id_S)
            ->select(
                'modules.Nom as module_name',
                'notes.annee_universitaire as annee',
                'filieres.Nom as filiere', DB::raw('SUM(notes.note * element__modules.coifficent) AS module_note'),
                'notes.session as session'
            )
            ->groupBy('modules.id', 'modules.Nom', 'notes.session', 'filiere', 'annee')
            ->get();
        $moduleCount = DB::table('notes')
            ->join('users', 'notes.user_id', '=', 'users.id')
            ->join('element__modules', 'notes.element_id', '=', 'element__modules.id')
            ->join('modules', 'element__modules.module_id', '=', 'modules.id')
            ->where('users.id', '=', auth()->user()->id)
            ->where('modules.semestre', '=', $id_S)
            ->select(DB::raw('COUNT(DISTINCT modules.id) as count'))
            ->first();


        return view('backend.user.student', compact('notes', 'moduleCount'))
            ->with('id', $id_S);
    }
    public function editNote($iduser, $idelement)
    {
        $edit = DB::table('users')
        ->join('filieres', 'users.filiere_id', '=', 'filieres.id')
        ->join('modules', 'filieres.id', '=', 'modules.filiere_id')
        ->join('element__modules', 'modules.id', '=', 'element__modules.module_id')
        ->leftJoin('notes', function ($join) use ($iduser, $idelement) {
            $join->on('notes.user_id', '=', 'users.id')
                ->where('notes.element_id', '=', $idelement)
                ->where('notes.user_id', '=', $iduser);
        })
        ->where('element__modules.id', '=', $idelement)
        ->where('users.id', '=', $iduser)
        ->select('users.id as id_user', 'filieres.abriviation as filiere', 'users.name as user', 'element__modules.id as id_element', 'notes.note', 'users.CNE as CNE')
        ->first();
        return view("backend.user.add_Note", compact('edit'));

    }
    public function addNote(Request $request, $idelement, $iduser)
    {
        $data = array();
        $data['element_id'] = $idelement;
        $data['user_id'] = $iduser;
        $data['note'] = $request->note;
        $data['semestre'] = $request->semestre;
        $data['session'] = $request->session;
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = date('Y-m-d H:i:s');
        $insert = DB::table('notes')->insert($data);
        if ($insert) {
            $notification = array(
                'messege' => 'note ajouté avec succés',
                'alert-type' => 'success'
            );
            return redirect()->route('note', ['id' => $idelement])->with($notification);

        } else {
            $notification = array(
                'messege' => 'note non ajouté,ressayez!',
                'alert-type' => 'error'
            );
            return redirect()->route('note', ['id' => $idelement])->with($notification);
        }


    }
    public function modify($iduser, $idelement)
    {
        $edit = DB::table('users')
            ->join('filieres', 'users.filiere_id', '=', 'filieres.id')
            ->join('modules', 'filieres.id', '=', 'modules.filiere_id')
            ->join('element__modules', 'modules.id', '=', 'element__modules.module_id')
            ->leftJoin('notes', function ($join) use ($iduser, $idelement) {
                $join->on('notes.user_id', '=', 'users.id')
                    ->where('notes.element_id', '=', $idelement)
                    ->where('notes.user_id', '=', $iduser);
            })
            ->where('element__modules.id', '=', $idelement)
            ->where('users.id', '=', $iduser)
            ->select('users.id as id_user', 'filieres.abriviation as filiere', 'users.name as user', 'element__modules.id as id_element', 'notes.note', 'users.CNE as CNE')
            ->first();


        return view("backend.user.edit_note", compact('edit'));
    }
    public function updateNote(Request $request, $iduser, $id_element)
    {


        $update = DB::table('notes')
            ->where('user_id', $iduser)
            ->where('element_id', $id_element)
            ->update(['note' => $request->note]);
        if ($update) {
            $notification = array(
                'messege' => 'note modifié avec succés',
                'alert-type' => 'success'
            );
            return redirect()->route('note', ['id' => $id_element])->with($notification);

        } else {
            $notification = array(
                'messege' => 'note non modifié,ressayez!',
                'alert-type' => 'error'
            );
            return redirect()->route('note', ['id' => $id_element])->with($notification);
        }

    }
}