<?php

namespace App\Http\Controllers\opticient;

use App\Models\Client;
use App\Models\Opticien;
use App\Models\Prescription;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class OpticienController extends Controller
{
    public function index()
    {
        $opticiens = Opticien::all();
        return view('opticien.index', compact('opticiens'));
    }

    public function dashboardOpticien()
    {
        $clients = Client::count();
        $countPrescription = Prescription::count();
        return view('opticien.dashboard', [
            'clients' => $clients,
            'countPrescription' => $countPrescription,
        ]);
    }

    public function accountOpticien()
    {
        $opticien = Auth::user();
        return view('opticien.compte', compact('opticien'));
    }

    /**
     * Affiche le formulaire de création d'un nouvel opticien.
     */
    public function create()
    {
        return view('opticien.create');
    }

    /**
     * Enregistre un nouvel opticien dans la base de données.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|unique:opticiens,email',
            'telephone' => 'nullable|string|regex:/^\+?[0-9]{7,15}$/',
            'password' => 'required|string|min:4|confirmed',

        ]);

       $opticien = Opticien::create([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'email' => $request->email,
            'telephone' => $request->telephone,
            'password' => Hash::make($request->password),

        ]);

        Auth::guard('opticien')->login($opticien);
        return redirect()->intended('/dashboard/opticien')->with('success', 'Votre compte a bien été crée');    
    }

    public function downloadPdf()
    {
        $opticiens = Opticien::all();
        
        // Générer le PDF à partir d'une vue
        $pdf = Pdf::loadView('opticien.pdf', compact('opticiens'));

        // Télécharger le PDF avec un nom de fichier approprié
        return $pdf->download('liste_opticiens.pdf');
    }

    /**
     * Affiche un opticien spécifique (si nécessaire).
     */
    public function show($id)
    {
        $opticien = Opticien::findOrFail($id);
        return view('opticien.show', compact('opticien'));
    }

    /**
     * Affiche le formulaire d'édition pour un opticien spécifique.
     */
    public function edit($id)
    {
        $opticien = Opticien::findOrFail($id);
        return view('opticien.update', compact('opticien'));
    }

    /**
     * Met à jour un opticien spécifique dans la base de données.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|unique:opticiens,email,' . $id,
            'telephone' => 'required|string|max:20',
        ]);

        $opticien = Opticien::findOrFail($id);
        $opticien->update([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'email' => $request->email,
            'telephone' => $request->telephone,
        ]);

        return redirect()->route('opticien.index')->with('success', 'Opticien mis à jour avec succès');
    }

    /**
     * Supprime un opticien spécifique de la base de données.
     */
    public function destroy($id)
    {
        $opticien = Opticien::findOrFail($id);
        $opticien->delete();

        return redirect()->route('opticien.index')->with('success', 'Opticien supprimé avec succès');
    }

    public function loginForm()
    {
        return view('opticien.login');
    }
    public function registerForm()
    {
        return view('opticien.register');
    }

    public function authOpticien(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::guard('opticien')->attempt($credentials)) {
            return redirect()->intended('/dashboard/opticien');
        }

        return back()->withErrors([
            'email' => 'Ces identifiants ne correspondent pas.',
        ]);
    }

    public function logoutOpticient(Request $request)
    {
        Auth::guard('opticien')->logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('opticien.login');
    }
}
