@extends('opticien.app')

@section('title', 'Gestion des Prescriptions')

@section('content')

    <div class="pagetitle">
        <h4 class="card-title">Gestion des Prescriptions</h4>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Accueil</a></li>
                <li class="breadcrumb-item active">Prescriptions</li>
            </ol>
        </nav>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
    </div>

    {{-- <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Action</h6>
                    <button class="btn btn-primary bts-sm mt-3" data-bs-toggle="modal"
                        data-bs-target="#addPrescriptionModal">
                        Ajouter une prescription
                    </button>
                </div>
            </div>
        </div>
    </div> --}}
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Effectuer une prescription au client</h6>
                    <form action="{{ route('prescription.store') }}" method="POST">
                        @csrf
                        <div class="row d-flex justify-content-around">
                            <div class="col-lg-4">
                                <div class="mb-3">
                                    <label for="client_id" class="form-label">Client</label>
                                    <select name="client_id" class="form-control select2 @error('client_id') is-invalid @enderror" required>
                                        @foreach ($clients as $client)
                                            <option value="{{ $client->id }}">{{ $client->nom }} {{ $client->prenom }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('client_id')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="mb-3">
                                    <input type="hidden" id="opticien_id" name='opticien_id'
                                        value="{{ auth('opticien')->user()->id }}">
                                </div>
                            </div>
                        </div>
                        <div class="row d-flex justify-content-around">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="spherique_od" class="form-label">Sphère (OD) </label>
                                    <input type="text" name="spherique_od" class="form-control @error('spherique_od') is-invalid @enderror">
                                    @error('spherique_od')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="spherique_og" class="form-label">Sphère (OG) </label>
                                    <input type="text" name="spherique_og" class="form-control @error('spherique_og') is-invalid @enderror">
                                    @error('spherique_og')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row d-flex justify-content-around">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="distance_pupillaire" class="form-label">Distance Pupillaire</label>
                                    <input type="text" name="distance_pupillaire" class="form-control @error('distance_pupillaire') is-invalid @enderror">
                                    @error('distance_pupillaire')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="notes" class="form-label">Notes</label>
                                    <textarea name="notes" class="form-control @error('notes') is-invalid @enderror" rows="3"></textarea>
                                </div>
                                @error('notes')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-primary">Ajouter</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Liste des prescriptions -->
    <div class="row mt-4">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Liste des Prescriptions</h6>
                    <table class="table datatable">
                        <thead>
                            <tr>
                                <th>Client</th>
                                <th>Opticien</th>
                                <th>Date Examen</th>
                                <th>Notes</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($prescriptions as $prescription)
                                <tr>
                                    <td>{{ $prescription->client->nom }} {{ $prescription->client->prenom }}</td>
                                    <td>{{ $prescription->opticien->nom }} {{ $prescription->opticien->prenom }}</td>
                                    <td>{{ $prescription->date_examen }}</td>
                                    <td>{{ $prescription->notes }}</td>
                                    <td class="text-end">
                                        <button class="btn btn-warning" data-bs-toggle="modal"
                                            data-bs-target="#editPrescriptionModal{{ $prescription->id }}">
                                            <i class="bi bi-pencil-fill"></i>
                                        </button>
                                        <button class="btn btn-danger" data-bs-toggle="modal"
                                            data-bs-target="#deletePrescriptionModal{{ $prescription->id }}">
                                            <i class="bi bi-trash-fill"></i>
                                        </button>
                                        <a href="{{ route('prescription.download', $prescription->id) }}"
                                            class="btn btn-secondary">
                                            <i class="bi bi-download"></i> Télécharger
                                        </a>
                                    </td>
                                </tr>

                                <!-- Modal pour la modification de la prescription -->
                                <div class="modal fade" id="editPrescriptionModal{{ $prescription->id }}" tabindex="-1"
                                    aria-labelledby="editPrescriptionLabel{{ $prescription->id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editPrescriptionLabel{{ $prescription->id }}">
                                                    Modifier Prescription
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
                                                <form action="{{ route('prescription.update', $prescription->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="mb-3">
                                                        <label for="client_id" class="form-label">Client</label>
                                                        <select name="client_id" class="form-control" required>
                                                            @foreach ($clients as $client)
                                                                <option value="{{ $client->id }}"
                                                                    {{ $client->id == $prescription->client_id ? 'selected' : '' }}>
                                                                    {{ $client->nom }} {{ $client->prenom }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="opticien_id" class="form-label">Opticien</label>
                                                        <select name="opticien_id" class="form-control" required>
                                                            @foreach ($opticiens as $opticien)
                                                                <option value="{{ $opticien->id }}"
                                                                    {{ $opticien->id == $prescription->opticien_id ? 'selected' : '' }}>
                                                                    {{ $opticien->nom }} {{ $opticien->prenom }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="spherique_od" class="form-label">Sphère (OD) </label>
                                                        <input type="text" name="spherique_od" class="form-control"
                                                            value="{{ $prescription->spherique_od }}" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="spherique_og" class="form-label">Sphère (OG) </label>
                                                        <input type="text" name="spherique_og" class="form-control"
                                                            value="{{ $prescription->spherique_og }}" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="distance_pupillaire" class="form-label">Distance
                                                            Pupillaire</label>
                                                        <input type="text" name="distance_pupillaire"
                                                            class="form-control"
                                                            value="{{ $prescription->distance_pupillaire }}" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="notes" class="form-label">Notes</label>
                                                        <textarea name="notes" class="form-control" rows="3">{{ $prescription->notes }}</textarea>
                                                    </div>
                                                    <button type="submit" class="btn btn-success">Enregistrer</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Modal pour la suppression de la prescription -->
                                <div class="modal fade" id="deletePrescriptionModal{{ $prescription->id }}"
                                    tabindex="-1" aria-labelledby="deletePrescriptionLabel{{ $prescription->id }}"
                                    aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title"
                                                    id="deletePrescriptionLabel{{ $prescription->id }}">
                                                    Supprimer Prescription
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Voulez-vous vraiment supprimer cette prescription ?</p>
                                                <form action="{{ route('prescription.destroy', $prescription->id) }}"
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

    <!-- Modal pour ajouter une prescription -->
    <div class="modal fade" id="addPrescriptionModal" tabindex="-1" aria-labelledby="addPrescriptionLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addPrescriptionLabel">Ajouter une prescription</h5>
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
                    <form action="{{ route('prescription.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="client_id" class="form-label">Client</label>
                            <select name="client_id" class="form-control" required>
                                @foreach ($clients as $client)
                                    <option value="{{ $client->id }}">{{ $client->nom }} {{ $client->prenom }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="opticien_id" class="form-label">Opticien</label>
                            <select name="opticien_id" class="form-control" required>
                                @foreach ($opticiens as $opticien)
                                    <option value="{{ $opticien->id }}">{{ $opticien->nom }} {{ $opticien->prenom }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="spherique_od" class="form-label">Sphère (OD) </label>
                            <input type="text" name="spherique_od" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="spherique_og" class="form-label">Sphère (OG) </label>
                            <input type="text" name="spherique_og" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="distance_pupillaire" class="form-label">Distance Pupillaire</label>
                            <input type="text" name="distance_pupillaire" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="notes" class="form-label">Notes</label>
                            <textarea name="notes" class="form-control" rows="3"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Ajouter</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
