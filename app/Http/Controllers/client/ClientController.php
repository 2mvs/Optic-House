<?php

namespace App\Http\Controllers\client;

use App\Models\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Récupérer tous les clients par ordre de création
        $clients = Client::orderBy('created_at', 'desc')->get();
        return view('client.index', compact('clients'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Retourner la vue pour créer un nouveau client
        return view('client.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validation des données
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|unique:clients,email',
            'telephone' => 'nullable|string|max:15|regex:/^\+?[0-9]{7,15}$/',
            'adresse' => 'nullable|string|max:255',
        ]);

        // Création du client dans la base de données
        Client::create([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'email' => $request->email,
            'telephone' => $request->telephone,
            'adresse' => $request->adresse,
        ]);

        // Rediriger vers la liste des clients avec un message de succès
        return redirect()->route('client.index')->with('success', 'Client ajouté avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Récupérer un client spécifique et afficher les détails
        $client = Client::findOrFail($id);
        return view('client.show', compact('client'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // Récupérer un client spécifique pour l'édition
        $client = Client::findOrFail($id);
        return view('client.edit', compact('client'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validation des données mises à jour
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|unique:clients,email,' . $id,
            'telephone' => 'nullable|string|max:15|regex:/^\+?[0-9]{7,15}$/',
            'adresse' => 'nullable|string|max:255',
        ]);

        // Récupérer et mettre à jour le client dans la base de données
        $client = Client::findOrFail($id);
        $client->update([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'email' => $request->email,
            'telephone' => $request->telephone,
            'adresse' => $request->adresse,
        ]);

        // Rediriger avec un message de succès
        return redirect()->route('client.index')->with('success', 'Client mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Récupérer le client et le supprimer
        $client = Client::findOrFail($id);
        $client->delete();

        // Rediriger avec un message de succès
        return redirect()->route('client.index')->with('success', 'Client supprimé avec succès.');
    }
}
