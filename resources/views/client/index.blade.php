@extends('app')

@section('title', 'Tableau de Bord')

@section('content')

    <div class="pagetitle">
        <h1>Gestion des clients</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">accueil</a></li>
                <li class="breadcrumb-item active">Client</li>
            </ol>
        </nav>
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <h4 class="card-title">Gérer les Clients</h4>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Action</h6>

                    <button class="btn btn-primary bts-sm mt-3" data-bs-toggle="modal"
                        data-bs-target="#addClientModal">Ajouter un client</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Liste des clients -->
    <div class="row mt-4">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h1 class="card-title"> Liste des clients</h1>
                </div>
                <div class="card-body">
                    <table class="table datatable">
                        <thead>
                            <tr>
                                <th>Nom</th>
                                <th>Prénom</th>
                                <th>Email</th>
                                <th>Téléphone</th>
                                <th>adresse</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($clients as $client)
                                <tr>
                                    <td>{{ $client->nom }}</td>
                                    <td>{{ $client->prenom }}</td>
                                    <td>{{ $client->email }}</td>
                                    <td>{{ $client->telephone }}</td>
                                    <td>{{ $client->adresse }}</td>
                                    <td class="text-end">
                                        <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editClientModal{{ $client->id }}">
                                            <i class="bi bi-pencil-fill"></i> 
                                        </button>
                                        <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteClientModal{{ $client->id }}">
                                            <i class="bi bi-trash-fill"></i> 
                                        </button>
                                    </td>
                                </tr>

                                <!-- Modal pour la modification -->
                                <div class="modal fade" id="editClientModal{{ $client->id }}" tabindex="-1"
                                    aria-labelledby="editClientLabel{{ $client->id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editClientLabel{{ $client->id }}">Modifier
                                                    Client</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('client.update', $client->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="mb-3">
                                                        <label for="nom" class="form-label">Nom</label>
                                                        <input type="text" name="nom" class="form-control"
                                                            value="{{ $client->nom }}" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="prenom" class="form-label">Prénom</label>
                                                        <input type="text" name="prenom" class="form-control"
                                                            value="{{ $client->prenom }}" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="email" class="form-label">Email</label>
                                                        <input type="email" name="email" class="form-control"
                                                            value="{{ $client->email }}" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="telephone" class="form-label">Téléphone</label>
                                                        <input type="text" name="telephone" class="form-control"
                                                            value="{{ $client->telephone }}" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="adresse" class="form-label">Adresse</label>
                                                        <input type="text" name="adresse" class="form-control"
                                                            value="{{ $client->adresse }}" required>
                                                    </div>
                                                    <button type="submit" class="btn btn-success">Enregistrer</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Modal pour la suppression -->
                                <div class="modal fade" id="deleteClientModal{{ $client->id }}" tabindex="-1"
                                    aria-labelledby="deleteClientLabel{{ $client->id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="deleteClientLabel{{ $client->id }}">Supprimer
                                                    Client</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Voulez-vous vraiment supprimer ce client ?</p>
                                                <form action="{{ route('client.destroy', $client->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">Supprimer</button>
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Annuler</button>
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

    <!-- Modal pour ajouter un client -->
    <div class="modal fade" id="addClientModal" tabindex="-1" aria-labelledby="addClientLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addClientLabel">Ajouter un Client</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('client.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="nom" class="form-label">Nom</label>
                            <input type="text" name="nom" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="prenom" class="form-label">Nom</label>
                            <input type="text" name="prenom" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="telephone" class="form-label">Téléphone</label>
                            <input type="text" name="telephone" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="adresse" class="form-label">Adresse</label>
                            <input type="text" name="adresse" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-success">Ajouter</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
