<?php

namespace App\Http\Controllers\vente;

use App\Models\Vente;
use App\Models\Client;
use App\Models\Produit;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;

class VenteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Récupérer toutes les ventes avec les clients et les produits associés
        $ventes = Vente::with(['client', 'produit'])->get();
        $clients = Client::all();
        $produits = Produit::all();

        $countTotalVente = Vente::sum('total');


        // Retourner la vue avec les ventes
        return view('vente.index', compact('ventes', 'clients', 'produits', 'countTotalVente'));
    }

    /**
     * Affiche le formulaire pour créer une nouvelle vente.
     */
    public function create()
    {
        // Récupérer la liste des clients et des produits pour le formulaire
        $clients = Client::all();
        $produits = Produit::all();

        // Retourner la vue pour créer une vente
        return view('vente.create', compact('clients', 'produits'));
    }


    public function getProduitPrix($id)
    {
        $produit = Produit::find($id);

        if ($produit) {
            return response()->json([
                'prix_unitaire' => $produit->price
            ]);
        }

        return response()->json(['message' => 'Produit non trouvé'], 404);
    }


    /**
     * Enregistre une nouvelle vente dans la base de données.
     */
    public function store(Request $request)
    {
        // Valider les données de la requête
        $request->validate([
            'client_id' => 'required|exists:clients,id',
            'produit_id' => 'required|exists:produits,id',
            'quantite' => 'required|integer|min:1',
            'prix_unitaire' => 'required|numeric|min:0.01',
        ]);

        // Récupérer le produit
        $produit = Produit::findOrFail($request->produit_id);

        // Vérifier que la quantité en stock est suffisante
        if ($produit->stock_quantity < $request->quantite) {
            return redirect()->back()->withErrors(['quantite' => 'Quantité insuffisante en stock pour ce produit.']);
        }

        // Créer une nouvelle vente
        $vente = new Vente();
        $vente->client_id = $request->client_id;
        $vente->produit_id = $request->produit_id;
        $vente->quantite = $request->quantite;
        $vente->prix_unitaire = $request->prix_unitaire;
        $vente->total = $vente->calculerTotal();
        $vente->date_vente = now(); // Enregistre la date actuelle
        $vente->save();

        // Mettre à jour la quantité du produit dans le stock
        $produit->stock_quantity -= $request->quantite;
        $produit->save();

        // Redirection avec un message de succès
        return redirect()->route('vente.index')->with('success', 'Vente ajoutée avec succès.');
    }

    public function facture($id)
    {
        // Récupérer la vente par son ID
        $vente = Vente::with('client', 'produit')->findOrFail($id);

        // Générer le PDF avec Dompdf
        $pdf = Pdf::loadView('vente.pdf', compact('vente'));

        // Télécharger la facture
        return $pdf->download('facture_' . $vente->id . '.pdf');
    }

    /**
     * Affiche les détails d'une vente spécifique.
     */
    public function show($id)
    {
        // Récupérer la vente avec les informations liées
        $vente = Vente::with(['client', 'produit'])->findOrFail($id);

        // Retourner la vue avec les détails de la vente
        return view('vente.show', compact('vente'));
    }

    /**
     * Affiche le formulaire pour modifier une vente existante.
     */
    public function edit($id)
    {
        $vente = Vente::findOrFail($id);
        $clients = Client::all();
        $produits = Produit::all();
        return view('ventes.edit', compact('vente', 'clients', 'produits'));
    }

    /**
     * Met à jour une vente dans la base de données.
     */
    public function update(Request $request, $id)
    {
        // Valider les données de la requête
        $request->validate([
            'client_id' => 'required|exists:clients,id',
            'produit_id' => 'required|exists:produits,id',
            'quantite' => 'required|integer|min:1',
            'prix_unitaire' => 'required|numeric|min:0.01',
        ]);
    
        // Récupérer la vente existante et le produit lié
        $vente = Vente::findOrFail($id);
        $produit = Produit::findOrFail($request->produit_id);
    
        // Calculer la différence entre l'ancienne et la nouvelle quantité
        $differenceQuantite = $request->quantite - $vente->quantite;
    
        // Vérifier si la nouvelle quantité demandée est disponible dans le stock
        if ($produit->stock_quantity < $differenceQuantite) {
            return redirect()->back()->withErrors(['quantite' => 'Quantité insuffisante en stock pour ce produit.']);
        }
    
        // Mettre à jour la vente
        $vente->client_id = $request->client_id;
        $vente->produit_id = $request->produit_id;
        $vente->quantite = $request->quantite;
        $vente->prix_unitaire = $request->prix_unitaire;
        $vente->total = $vente->calculerTotal();
        $vente->save();
    
        // Mettre à jour la quantité du produit dans le stock
        $produit->stock_quantity -= $differenceQuantite;
        $produit->save();
    
        // Redirection avec un message de succès
        return redirect()->route('vente.index')->with('success', 'Vente mise à jour et stock ajusté avec succès.');
    }
    

    /**
     * Supprime une vente de la base de données.
     */
    public function destroy($id)
    {
        // Récupérer la vente et la supprimer
        $vente = Vente::findOrFail($id);
        $vente->delete();

        // Redirection avec un message de succès
        return redirect()->route('vente.index')->with('success', 'Vente supprimée avec succès.');
    }
}
