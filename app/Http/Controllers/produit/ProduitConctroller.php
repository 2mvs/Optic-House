<?php

namespace App\Http\Controllers\produit;

use App\Models\Produit;
use App\Models\Category;
use App\Models\Fournisseur;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProduitConctroller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Produit::with('category', 'fournisseur')->get();        
        $categories = Category::all();
        $fournisseurs = Fournisseur::all();
        return view('product.index', compact('products','categories', 'fournisseurs'));
    }

    /**
     * Afficher le formulaire de création d'un nouveau produit.
     */
    public function create()
    {
        $categories = Category::all();
        $fournisseurs = Fournisseur::all();
        return view('product.create', compact('categories', 'fournisseurs'));
    }

    /**
     * Enregistrer un nouveau produit dans la base de données.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'stock_quantity' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'fournisseur_id' => 'required|exists:fournisseurs,id',
        ]);

        Produit::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'stock_quantity' => $request->stock_quantity,
            'category_id' => $request->category_id,
            'fournisseur_id' => $request->fournisseur_id,
        ]);

        return redirect()->route('product.index')->with('success', 'Produit ajouté avec succès');
    }

    /**
     * Afficher un produit spécifique (si nécessaire).
     */
    public function show($id)
    {
        $product = Produit::with(['category', 'fournisseur'])->findOrFail($id);
        return view('product.show', compact('product'));
    }

    /**
     * Afficher le formulaire pour éditer un produit spécifique.
     */
    public function edit($id)
    {
        $product = Produit::findOrFail($id);
        $categories = Category::all();
        $fournisseurs = Fournisseur::all();
        return view('product.edit', compact('product', 'categories', 'fournisseurs'));
    }

    /**
     * Mettre à jour un produit spécifique dans la base de données.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'stock_quantity' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'fournisseur_id' => 'required|exists:fournisseurs,id',
        ]);


        $product = Produit::findOrFail($id);
        $product->update([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'stock_quantity' => $request->stock_quantity,
            'category_id' => $request->category_id,
            'fournisseur_id' => $request->fournisseur_id,
        ]);

        return redirect()->route('product.index')->with('success', 'Produit modifié avec succès');
    }

    /**
     * Supprimer un produit spécifique de la base de données.
     */
    public function destroy($id)
    {
        $product = Produit::findOrFail($id);
        $product->delete();

        return redirect()->route('product.index')->with('success', 'Produit supprimé avec succès');
    }
}
