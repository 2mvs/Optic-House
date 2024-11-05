<?php

namespace App\Models;

use App\Models\Category;
use App\Models\Fournisseur;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Produit extends Model
{
    use HasFactory;

    protected $fillable = [
        "name",
        "description",
        "price",
        "stock_quantity",
        "category_id",
        "fournisseur_id",
    ];
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    
    public function fournisseur()
    {
        return $this->belongsTo(Fournisseur::class);
    }
    
}
