<?php

namespace App\Models;

use App\Models\Produit;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Fournisseur extends Model
{
    use HasFactory;

    protected $fillable = ['nom', 'contact', 'telephone', 'email', 'adresse'];

    public function products()
    {
        return $this->hasMany(Produit::class);
    }
}
