@extends('opticien.app')

@section('title', 'Mon Compte')

@section('content')

<div class="pagetitle">
    <h1>Mon Compte</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Accueil</a></li>
            <li class="breadcrumb-item active">Mon Compte</li>
        </ol>
    </nav>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Informations du Compte</h5>

                <!-- Informations du profil de l'opticien -->
                <div class="row mb-3">
                    <label class="col-md-4 col-form-label text-md-end">Nom</label>
                    <div class="col-md-6">
                        <p class="form-control-plaintext">{{ $opticien->nom }}</p>
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-md-4 col-form-label text-md-end">Prénom</label>
                    <div class="col-md-6">
                        <p class="form-control-plaintext">{{ $opticien->prenom }}</p>
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-md-4 col-form-label text-md-end">Email</label>
                    <div class="col-md-6">
                        <p class="form-control-plaintext">{{ $opticien->email }}</p>
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-md-4 col-form-label text-md-end">Téléphone</label>
                    <div class="col-md-6">
                        <p class="form-control-plaintext">{{ $opticien->telephone }}</p>
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-md-4 col-form-label text-md-end">Mot de passe</label>
                    <div class="col-md-6">
                        <p class="form-control-plaintext">**********</p>
                    </div>
                </div>

                <div class="row mb-0">
                    <div class="col-md-6 offset-md-4">
                        <a href="{{ route('opticien.edit', $opticien->id) }}" class="btn btn-primary">
                            Modifier mes informations
                        </a>
                    </div>
                </div>
                <!-- Fin des informations du profil -->

            </div>
        </div>
    </div>
</div>

@endsection
