@extends('app')

@section('title', 'Gestion des Fournisseurs')

@section('content')
<div class="pagetitle">
    <h1>Gestion des Fournisseurs</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Accueil</a></li>
            <li class="breadcrumb-item active">Fournisseur</li>
        </ol>
    </nav>
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <h4 class="card-title">Gérer les Fournisseurs</h4>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h6 class="card-title">Action</h6>
            </div>
            <div class="card-body">
                <button class="btn btn-primary bts-sm mt-3" data-bs-toggle="modal"
                    data-bs-target="#addFournisseurModal">Ajouter un fournisseur</button>
            </div>
        </div>
    </div>
</div>

<!-- Liste des fournisseurs -->
<div class="row mt-4">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h1 class="card-title"> Liste des fournisseurs</h1>
            </div>
            <div class="card-body">
                <table class="table datatable">
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Téléphone</th>
                            <th>Email</th>
                            <th>Adresse</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($fournisseurs as $fournisseur)
                            <tr>
                                <td>{{ $fournisseur->nom }}</td>
                                <td>{{ $fournisseur->telephone }}</td>
                                <td>{{ $fournisseur->email }}</td>
                                <td>{{ $fournisseur->adresse }}</td>
                                <td class="text-end">
                                    <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editFournisseurModal{{ $fournisseur->id }}">
                                        <i class="bi bi-pencil-fill"></i> 
                                    </button>
                                    <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteFournisseurModal{{ $fournisseur->id }}">
                                        <i class="bi bi-trash-fill"></i> 
                                    </button>
                                </td>
                            </tr>

                            <!-- Modal pour la modification -->
                            <div class="modal fade" id="editFournisseurModal{{ $fournisseur->id }}" tabindex="-1"
                                aria-labelledby="editFournisseurLabel{{ $fournisseur->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editFournisseurLabel{{ $fournisseur->id }}">Modifier Fournisseur</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('fournisseur.update', $fournisseur->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="mb-3">
                                                    <label for="nom" class="form-label">Nom</label>
                                                    <input type="text" name="nom" class="form-control"
                                                        value="{{ $fournisseur->nom }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="contact" class="form-label">Contact</label>
                                                    <input type="text" name="contact" class="form-control"
                                                        value="{{ $fournisseur->contact }}">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="telephone" class="form-label">Téléphone</label>
                                                    <input type="text" name="telephone" class="form-control"
                                                        value="{{ $fournisseur->telephone }}">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="email" class="form-label">Email</label>
                                                    <input type="email" name="email" class="form-control"
                                                        value="{{ $fournisseur->email }}">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="adresse" class="form-label">Adresse</label>
                                                    <input type="text" name="adresse" class="form-control"
                                                        value="{{ $fournisseur->adresse }}">
                                                </div>
                                                <button type="submit" class="btn btn-success">Enregistrer</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Modal pour la suppression -->
                            <div class="modal fade" id="deleteFournisseurModal{{ $fournisseur->id }}" tabindex="-1"
                                aria-labelledby="deleteFournisseurLabel{{ $fournisseur->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="deleteFournisseurLabel{{ $fournisseur->id }}">Supprimer Fournisseur</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p>Voulez-vous vraiment supprimer ce fournisseur ?</p>
                                            <form action="{{ route('fournisseur.destroy', $fournisseur->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Supprimer</button>
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal pour ajouter un fournisseur -->
<div class="modal fade" id="addFournisseurModal" tabindex="-1" aria-labelledby="addFournisseurLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addFournisseurLabel">Ajouter un Fournisseur</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('fournisseur.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="nom" class="form-label">Nom</label>
                        <input type="text" name="nom" class="form-control" placeholder="Mon nom..." required>
                    </div>
                    <div class="mb-3">
                        <label for="telephone" class="form-label">Téléphone</label>
                        <input type="text" name="telephone" class="form-control" placeholder="+241 ...." required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" placeholder="monadresse@gmail.com" required>
                    </div>
                    <div class="mb-3">
                        <label for="adresse" class="form-label">Adresse</label>
                        <input type="text" name="adresse" class="form-control" placeholder="Rue Boulevard" required>
                    </div>
                    <button type="submit" class="btn btn-success">Ajouter</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
