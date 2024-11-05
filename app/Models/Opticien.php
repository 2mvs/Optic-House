<?php

namespace App\Models;

use App\Models\Devis;
use App\Models\Prescription;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
class Opticien extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $guard = 'opticien';

    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'telephone',
        'password'
    ];
    public function prescriptions()
    {
        return $this->hasMany(Prescription::class);
    }

    // Un opticien peut générer plusieurs devis
    public function devis()
    {
        return $this->hasMany(Devis::class);
    }


    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

}
