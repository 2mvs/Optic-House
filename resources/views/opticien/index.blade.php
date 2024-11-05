@extends('app')

@section('title', 'Gestion des Opticiens')

@section('content')

    <div class="pagetitle">
        <h4 class="card-title">Gestion des Opticiens</h4>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Accueil</a></li>
                <li class="breadcrumb-item active">Opticiens</li>
            </ol>
        </nav>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Action</h6>
                    <a href="{{ route('opticien.downloadPdf') }}" class="btn btn-outline-danger bts-sm mt-3">
                        Télécharger la liste en PDF
                    </a>
                </div>
                
            </div>
        </div>
    </div>

    <!-- Liste des opticiens -->
    <div class="row mt-4">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Liste des Opticiens</h6>
                    <table class="table datatable">
                        <thead>
                            <tr>
                                <th>Nom</th>
                                <th>Prénom</th>
                                <th>Email</th>
                                {{-- <th>Téléphone</th> --}}
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($opticiens as $opticien)
                                <tr>
                                    <td>{{ $opticien->nom }}</td>
                                    <td>{{ $opticien->prenom }}</td>
                                    <td>{{ $opticien->email }}</td>
                                    {{-- <td>{{ $opticien->telephone }}</td> --}}
                                    <td class="text-end">
                                        {{-- <button class="btn btn-warning" data-bs-toggle="modal"
                                            data-bs-target="#editOpticienModal{{ $opticien->id }}">
                                            <i class="bi bi-pencil-fill"></i>
                                        </button> --}}
                                        <button class="btn btn-danger" data-bs-toggle="modal"
                                            data-bs-target="#deleteOpticienModal{{ $opticien->id }}">
                                            <i class="bi bi-trash-fill"></i>
                                        </button>
                                    </td>
                                </tr>

                                <!-- Modal pour la modification de l'opticien -->
                                {{-- <div class="modal fade" id="editOpticienModal{{ $opticien->id }}" tabindex="-1"
                                    aria-labelledby="editOpticienLabel{{ $opticien->id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editOpticienLabel{{ $opticien->id }}">
                                                    Modifier Opticien
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                @if ($errors->any())
                                                    <div class="alert alert-danger">
                                                        <ul>
                                                            @foreach ($errors->all() as $error)
                                                                <li>{{ $error }}</li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                @endif
                                                <form action="{{ route('opticien.update', $opticien->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="mb-3">
                                                        <label for="nom" class="form-label">Nom</label>
                                                        <input type="text" name="nom" class="form-control"
                                                            value="{{ $opticien->nom }}" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="prenom" class="form-label">Prénom</label>
                                                        <input type="text" name="prenom" class="form-control"
                                                            value="{{ $opticien->prenom }}" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="email" class="form-label">Email</label>
                                                        <input type="email" name="email" class="form-control"
                                                            value="{{ $opticien->email }}" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="telephone" class="form-label">Téléphone</label>
                                                        <input type="text" name="telephone" class="form-control"
                                                            value="{{ $opticien->telephone }}" required>
                                                    </div>
                                                    <button type="submit" class="btn btn-success">Enregistrer</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div> --}}

                                <!-- Modal pour la suppression de l'opticien -->
                                <div class="modal fade" id="deleteOpticienModal{{ $opticien->id }}" tabindex="-1"
                                    aria-labelledby="deleteOpticienLabel{{ $opticien->id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="deleteOpticienLabel{{ $opticien->id }}">
                                                    Supprimer Opticien
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Voulez-vous vraiment supprimer cet opticien ?</p>
                                                <form action="{{ route('opticien.destroy', $opticien->id) }}"
                                                    method="POST">
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

    <!-- Modal pour ajouter un opticien -->
    {{-- <div class="modal fade" id="addOpticienModal" tabindex="-1" aria-labelledby="addOpticienLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addOpticienLabel">Ajouter un opticien</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form action="{{ route('opticien.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="nom" class="form-label">Nom</label>
                            <input type="text" name="nom" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="prenom" class="form-label">Prénom</label>
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
                        <button type="submit" class="btn btn-success">Ajouter</button>
                    </form>
                </div>
            </div>
        </div>
    </div> --}}

@endsection
