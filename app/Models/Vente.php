<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vente extends Model
{
    use HasFactory;

    protected $table = 'ventes';
    protected $fillable = [
        'client_id', 
        'produit_id', 
        'quantite', 
        'prix_unitaire', 
        'total', 
        'date_vente'
    ];
    protected $casts = [
        'date_vente' => 'datetime',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    /**
     * Relation avec le modèle Produit
     * Une vente peut contenir un ou plusieurs produits.
     */
    public function produit()
    {
        return $this->belongsTo(Produit::class);
    }

    /**
     * Calculer le total de la vente en fonction de la quantité et du prix unitaire.
     *
     * @return float
     */
    public function calculerTotal()
    {
        return $this->quantite * $this->prix_unitaire;
    }

    /**
     * Retourner le prix formaté avec la devise.
     *
     * @return string
     */
    public function getPrixFormatteAttribute()
    {
        return number_format($this->prix_unitaire, 2) . ' Fcfa';
    }

    /**
     * Retourner le total formaté avec la devise.
     *
     * @return string
     */
    public function getTotalFormatteAttribute()
    {
        return number_format($this->total, 2) . ' Fcfa';
    }
}
