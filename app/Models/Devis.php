<?php

namespace App\Models;

use App\Models\Client;
use App\Models\Opticien;
use App\Models\Prescription;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Devis extends Model
{
    use HasFactory;
    protected $fillable = [
        'client_id',
        'opticien_id',
        'date',
        'numero_devis',
        'sous_total_ht',
        'remise',
        'total_ht',
        'tva',
        'total_ttc',
        'modalites_paiement',
        'validite_devis',
        'status',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    // Un devis est généré/validé par un opticien
    public function opticien()
    {
        return $this->belongsTo(Opticien::class);
    }

    // Un devis peut être basé sur une prescription
    public function prescription()
    {
        return $this->belongsTo(Prescription::class);
    }
}
