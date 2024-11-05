<?php

namespace App\Models;

use App\Models\Devis;
use App\Models\Client;
use App\Models\Opticien;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Prescription extends Model
{
    use HasFactory;
    protected $fillable = [
        'client_id',
        'opticien_id',
        'date_examen',
        'spherique_od',
        'spherique_og',
        'cylindrique_od',
        'cylindrique_og',
        'axe_od',
        'axe_og',
        'addition',
        'distance_pupillaire',
        'notes',
    ];

    protected $casts = [
        'date' => 'date_examen',
    ];
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    // Une prescription est rédigée par un opticien
    public function opticien()
    {
        return $this->belongsTo(Opticien::class);
    }

    // Une prescription peut être liée à plusieurs devis
    public function devis()
    {
        return $this->hasMany(Devis::class);
    }
}
