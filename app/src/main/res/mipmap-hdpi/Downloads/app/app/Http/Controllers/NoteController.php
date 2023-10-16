<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Module;
use App\Models\Note;
use  App\Models\User;
class NoteController extends Controller
{
    public function index(Module $module)
    {
        $notes = Note::where('module_id', $module->id)->get();
        return view('notes.index', compact('notes', 'module'));
    }
    public function update(Module $module, Request $request)
{
    $notesToUpdate = $request->input('notes');

    foreach ($notesToUpdate as $userId => $note) {
        $existingNote = Note::where('user_id', $userId)
            ->where('module_id', $module->id)
            ->where('session', $request->input('session'))
            ->first();

        if ($existingNote) {
            $existingNote->note = $note;
            $existingNote->save();
        } else {
            $newNote = new Note();
            $newNote->user_id = $userId;
            $newNote->module_id = $module->id;
            $newNote->note = $note;
            $newNote->session = $request->input('session');
            $newNote->annee_universitaire = $request->input('annee_universitaire');
            $newNote->save();
        }
    }

    // Envoyer un message aux étudiants
    $message = "Votre note pour le module " . $module->nom . " a été mise à jour pour la session " . $request->input('session');
    foreach ($notesToUpdate as $userId => $note) {
        $user = User::find($userId);
        //$user->notify(new NoteUpdatedNotification($message));
    }

    return redirect()->route('modules.index')->with('success', 'Les notes ont été mises à jour avec succès !');
}

    
}
