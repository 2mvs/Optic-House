@extends('app')

@section('title', 'Vente')

@section('content')

<div class="pagetitle">
    <h4 class="card-title">Caisse</h4>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Accueil</a></li>
            <li class="breadcrumb-item active">Vente</li>
        </ol>
    </nav>
</div>

@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<div class="row mt-4">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h6 class="card-title">Ajouter une vente</h6>
                <form action="{{ route('vente.store') }}" method="POST" class="vstack gap-3">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <label for="client_id">Client</label>
                            <select name="client_id" id="client_id" class="form-select select2 @error('client_id') is-invalid @enderror">
                                @foreach ($clients as $client)
                                    <option value="{{ $client->id }}">{{ $client->nom }}</option>
                                @endforeach
                            </select>
                            @error('client_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="produit_id">Produit</label>
                            <select name="produit_id" id="produit_id" class="form-select select2 @error('produit_id') is-invalid @enderror">
                                <option value="" name=''>Sélectionner un produit</option>
                                @foreach ($produits as $produit)
                                    <option value="{{ $produit->id }}">{{ $produit->name }}</option>
                                @endforeach
                            </select>
                            @error('produit_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="quantite">Quantité</label>
                            <input type="number" name="quantite" id="quantite" class="form-control @error('quantite') is-invalid @enderror" placeholder="Ajouter la quantité">
                            @error('quantite')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="prix_unitaire">Prix unitaire</label>
                            <input type="number" name="prix_unitaire" id="prix_unitaire" class="form-control @error('prix_unitaire') is-invalid @enderror" placeholder="Ajouter le prix unitaire">
                            @error('prix_unitaire')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <button class="btn btn-primary btn-sm flex-grow-0 col-md-4">Enregistrer</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h6 class="card-title">Liste des Ventes</h6>
                <table class="table datatable">
                    <thead>
                        <tr>
                            <th>Client</th>
                            <th>Produit</th>
                            <th>Prix</th>
                            <th>Quantité</th>
                            <th>Date de vente</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($ventes as $vente)
                            <tr>
                                <td>{{ $vente->client->nom }}</td>
                                <td>{{ $vente->produit->name }}</td>
                                <td>{{ $vente->produit->price }}</td>
                                <td>{{ $vente->quantite }}</td>
                                <td>{{ $vente->date_vente }}</td>
                                <td class="text-end">
                                    <!-- Button Modifier (Ouvrir Modal) -->
                                    <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editModal{{ $vente->id }}">
                                        <i class="bi bi-pencil-fill"></i>
                                    </button>

                                    <!-- Button Supprimer (Ouvrir Modal) -->
                                    <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $vente->id }}">
                                        <i class="bi bi-trash-fill"></i>
                                    </button>

                                    <!-- Button Générer la facture -->
                                    <a href="{{ route('vente.facture', $vente->id) }}" class="btn btn-info btn-sm">
                                        Facture
                                    </a>
                                </td>
                            </tr>

                            <!-- Modal Modifier -->
                            <div class="modal fade" id="editModal{{ $vente->id }}" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form action="{{ route('vente.update', $vente->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editModalLabel">Modifier Vente</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label for="client_id">Client</label>
                                                    <select name="client_id" class="form-select">
                                                        @foreach ($clients as $client)
                                                            <option value="{{ $client->id }}" {{ $vente->client_id == $client->id ? 'selected' : '' }}>{{ $client->nom }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="produit_id">Produit</label>
                                                    <select name="produit_id" class="form-select">
                                                        @foreach ($produits as $produit)
                                                            <option value="{{ $produit->id }}" {{ $vente->produit_id == $produit->id ? 'selected' : '' }}>{{ $produit->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="quantite">Quantité</label>
                                                    <input type="number" name="quantite" class="form-control" value="{{ $vente->quantite }}">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="prix_unitaire">Prix unitaire</label>
                                                    <input type="number" name="prix_unitaire" class="form-control" value="{{ $vente->produit->price }}">
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                                <button type="submit" class="btn btn-primary">Enregistrer</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- Modal Supprimer -->
                            <div class="modal fade" id="deleteModal{{ $vente->id }}" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="deleteModalLabel">Supprimer Vente</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            Êtes-vous sûr de vouloir supprimer cette vente ?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                            <form action="{{ route('vente.destroy', $vente->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Supprimer</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        <tr>
                            <td colspan="6" class="font-weight-600">
                                Vente total = <span class="text-primary">{{ $countTotalVente }}</span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#produit_id').change(function() {
            var produit_id = $(this).val();
            if (produit_id) {
                $.ajax({
                    url: '/produit/getPrice/' + produit_id,
                    type: 'GET',
                    success: function(response) {
                        $('#prix_unitaire').val(response.price);
                    }
                });
            } else {
                $('#prix_unitaire').val('');
            }
        });
    });
</script>

@endsection
