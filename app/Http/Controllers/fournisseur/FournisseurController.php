<?php

namespace App\Http\Controllers\fournisseur;

use App\Models\Fournisseur;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FournisseurController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $fournisseurs = Fournisseur::orderBy('created_at', 'desc')->get();
        return view('fournisseur.index', compact('fournisseurs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function store(Request $request)
    {
        // Validation des données
        $request->validate([
            'nom' => 'required|string|max:255',
            'contact' => 'nullable|string|max:255',
            'telephone' => 'nullable|string|max:15|regex:/^\+?[0-9]{7,15}$/',
            'email' => 'nullable|email|max:255|unique:fournisseurs,email',
            'adresse' => 'nullable|string|max:255',
        ]);

        // Création du fournisseur dans la base de données
        Fournisseur::create([
            'nom' => $request->nom,
            'contact' => $request->contact,
            'telephone' => $request->telephone,
            'email' => $request->email,
            'adresse' => $request->adresse,
        ]);

        // Rediriger vers la liste des fournisseurs avec un message de succès
        return redirect()->route('fournisseur.index')->with('success', 'Fournisseur ajouté avec succès.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // Récupérer un fournisseur spécifique pour l'édition
        $fournisseur = Fournisseur::findOrFail($id);
        return view('fournisseur.edit', compact('fournisseur'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validation des données mises à jour
        $request->validate([
            'nom' => 'required|string|max:255',
            'contact' => 'nullable|string|max:255',
            'telephone' => 'nullable|string|max:15|regex:/^\+?[0-9]{7,15}$/',
            'email' => 'nullable|email|max:255|unique:fournisseurs,email,' . $id,
            'adresse' => 'nullable|string|max:255',
        ]);

        // Récupérer et mettre à jour le fournisseur dans la base de données
        $fournisseur = Fournisseur::findOrFail($id);
        $fournisseur->update([
            'nom' => $request->nom,
            'contact' => $request->contact,
            'telephone' => $request->telephone,
            'email' => $request->email,
            'adresse' => $request->adresse,
        ]);

        // Rediriger avec un message de succès
        return redirect()->route('fournisseur.index')->with('success', 'Fournisseur mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Récupérer le fournisseur et le supprimer
        $fournisseur = Fournisseur::findOrFail($id);
        $fournisseur->delete();

        // Rediriger avec un message de succès
        return redirect()->route('fournisseur.index')->with('success', 'Fournisseur supprimé avec succès.');
    }}
