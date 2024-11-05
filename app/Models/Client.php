<?php

namespace App\Models;

use App\Models\Devis;
use App\Models\Assurance;
use App\Models\Prescription;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'telephone',
        'adresse',
    ];

    public function assurances()
    {
        return $this->hasMany(Assurance::class);
    }

    public function prescriptions()
    {
        return $this->hasMany(Prescription::class);
    }

    // Un client peut avoir plusieurs devis
    public function devis()
    {
        return $this->hasMany(Devis::class);
    }
}
