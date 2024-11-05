<?php

namespace App\Http\Controllers;

use App\Models\Vente;
use App\Models\Client;
use App\Models\Produit;
use App\Models\Prescription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $clients = Client::count();
        $countproducts = Produit::count();
        $countPrescription = Prescription::count();
        $countVente = Vente::count();
        $countTotalVente = Vente::sum('total');

        $ventesParJour = Vente::selectRaw('DATE(created_at) as date, COUNT(*) as total')
            ->groupBy('date')
            ->orderBy('date', 'ASC')
            ->get();

        $dates = $ventesParJour->pluck('date');
        $totals = $ventesParJour->pluck('total');

        $topSellingProducts = Produit::select('name', DB::raw('SUM(ventes.quantite) as total_sales'))
        ->join('ventes', 'produits.id', '=', 'ventes.produit_id') // Assuming 'order_product' is your pivot table
        ->groupBy('produits.name')
        ->orderBy('total_sales', 'DESC')
        ->limit(5) // Limite aux 5 produits les plus vendus
        ->get();

        // Récupérer les produits en faible stock (<= 50)
        $lowStockProducts = Produit::where('stock_quantity', '<=', 50)->get();

        $products = Produit::with('category', 'fournisseur')->get();

        return view('dashboard.index', compact('clients', 'products', 'countproducts', 'countPrescription', 'countVente', 'countTotalVente', 'dates', 'totals', 'lowStockProducts', 'topSellingProducts'));
    }
}
