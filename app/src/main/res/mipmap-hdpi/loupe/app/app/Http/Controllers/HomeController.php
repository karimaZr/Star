<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;


class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function showuser()
    {
        $user = User::where('role', auth()->user()->role)->find(auth()->user()->id);

        $element = DB::table('element__modules')
            ->where('user_id', auth()->user()->id)
            ->get();

        return view('backend.layouts.profil', ['user' => $user, 'element' => $element]);
    }
    public function edit()
    {
        return view('backend.layouts.parametre');
    }
    public function update(Request $request)
    {
        $user = Auth()->user();
    
        // Validate the form data
        $this->validate($request, [
            'current_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ]);
    
        // Check if the current password is correct
        if (Hash::check($request->current_password, $user->password)) {
            // Update the user's password
            $user->password = Hash::make($request->new_password);
            $user->save();
    
            return redirect()->back()->with('success', 'Mot de passe modifié avec succès.');
        }
    
        return redirect()->back()->withErrors(['current_password' => 'Le mot de passe actuel est incorrect.']);
    }
    

}    