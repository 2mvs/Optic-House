@extends('opticien.app')

@section('title', 'Modifier Profil')

@section('content')

<div class="pagetitle">
    <h1>Modifier le Profil</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Accueil</a></li>
            <li class="breadcrumb-item active">Modifier Profil</li>
        </ol>
    </nav>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Informations du Profil</h5>

                <!-- Formulaire de modification du profil -->
                <form method="POST" action="{{ route('opticien.update', $opticien->id) }}">
                    @csrf
                    @method('PUT')

                    <div class="row mb-3">
                        <label for="nom" class="col-md-4 col-form-label text-md-end">Nom</label>
                        <div class="col-md-6">
                            <input id="nom" type="text" class="form-control @error('nom') is-invalid @enderror" name="nom" value="{{ old('nom', $opticien->nom) }}" required autofocus>
                            @error('nom')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="prenom" class="col-md-4 col-form-label text-md-end">Prénom</label>
                        <div class="col-md-6">
                            <input id="prenom" type="text" class="form-control @error('prenom') is-invalid @enderror" name="prenom" value="{{ old('prenom', $opticien->prenom) }}" required>
                            @error('prenom')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="email" class="col-md-4 col-form-label text-md-end">Email</label>
                        <div class="col-md-6">
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email', $opticien->email) }}" required>
                            @error('email')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="telephone" class="col-md-4 col-form-label text-md-end">Téléphone</label>
                        <div class="col-md-6">
                            <input id="telephone" type="text" class="form-control @error('telephone') is-invalid @enderror" name="telephone" value="{{ old('telephone', $opticien->telephone) }}" required>
                            @error('telephone')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="password" class="col-md-4 col-form-label text-md-end">Mot de passe</label>
                        <div class="col-md-6">
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" autocomplete="new-password">
                            @error('password')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-0">
                        <div class="col-md-6 offset-md-4">
                            <button type="submit" class="btn btn-primary">
                                Modifier le profil
                            </button>
                        </div>
                    </div>
                </form>
                <!-- Fin du formulaire -->

            </div>
        </div>
    </div>
</div>

@endsection
