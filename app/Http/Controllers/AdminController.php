<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    
    public function adminLogin()
    {
        return view('admin.login');
    }
    public function adminRegister()
    {
        return view('admin.register');
    }


    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|unique:opticiens,email',
            'telephone' => 'nullable|string|regex:/^\+?[0-9]{7,15}$/',
            'password' => 'required|string|min:4|confirmed',

        ]);

       $admin = Admin::create([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'email' => $request->email,
            'telephone' => $request->telephone,
            'password' => Hash::make($request->password),
        ]);

        Auth::guard('admin')->login($admin);
        return redirect()->intended('/dashboard/admin')->with('success', 'Votre compte a bien été crée');    
    }


    public function authAdmin(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::guard('admin')->attempt($credentials)) {
            return redirect()->intended('/dashboard/admin');
        }

        return back()->withErrors([
            'email' => 'Ces identifiants ne correspondent pas.',
        ]);
    }

    public function logoutAdmin(Request $request)
    {
        Auth::guard('admin')->logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
}
