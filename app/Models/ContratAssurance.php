<?php

namespace App\Models;

use App\Models\Client;
use App\Models\Assurance;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ContratAssurance extends Model
{
    use HasFactory;

    protected $fillable = ['client_id', 'assurance_id', 'montant_couvert', 'date_debut', 'date_fin'];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function assurance()
    {
        return $this->belongsTo(Assurance::class);
    }
}
