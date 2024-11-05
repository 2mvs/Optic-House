@extends('app')

@section('title', 'Gestion des Produits')

@section('content')

    <div class="pagetitle">
        <h4 class="card-title">Gestion des Produits</h4>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Accueil</a></li>
                <li class="breadcrumb-item active">Produits</li>
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
                <div class="card-header">
                    <h6 class="card-title">Action</h6>
                </div>
                <div class="card-body">
                    <button class="btn btn-primary bts-sm mt-3" data-bs-toggle="modal" data-bs-target="#addProductModal">
                        Ajouter un produit
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Liste des produits -->
    <div class="row mt-4">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title">Liste des Produits</h6>
                </div>
                <div class="card-body">
                    <table class="table datatable">
                        <thead>
                            <tr>
                                <th>Nom</th>
                                <th>Description</th>
                                <th>Prix</th>
                                <th>Quantité en stock</th>
                                <th>Catégorie</th>
                                <th>Fournisseur</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $product)
                                <tr>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ $product->description }}</td>
                                    <td>{{ $product->price }} €</td>
                                    <td>{{ $product->stock_quantity }}</td>
                                    <td>{{ $product->category->name }}</td>
                                    <td>{{ $product->fournisseur->nom }}</td>
                                    <td class="text-end">
                                        <button class="btn btn-warning" data-bs-toggle="modal"
                                            data-bs-target="#editProductModal{{ $product->id }}">
                                            <i class="bi bi-pencil-fill"></i>
                                        </button>
                                        <button class="btn btn-danger" data-bs-toggle="modal"
                                            data-bs-target="#deleteProductModal{{ $product->id }}">
                                            <i class="bi bi-trash-fill"></i>
                                        </button>
                                    </td>
                                </tr>

                                <!-- Modal pour la modification du produit -->
                                <div class="modal fade" id="editProductModal{{ $product->id }}" tabindex="-1"
                                    aria-labelledby="editProductLabel{{ $product->id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editProductLabel{{ $product->id }}">
                                                    Modifier Produit
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
                                                <form action="{{ route('product.update', $product->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="mb-3">
                                                        <label for="name" class="form-label">Nom</label>
                                                        <input type="text" name="name" class="form-control"
                                                            value="{{ $product->name }}" required>
                                                            @error('name')
                                                                {{$message}}
                                                            @enderror
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="description" class="form-label">Description</label>
                                                        <textarea name="description" class="form-control">{{ $product->description }}</textarea>
                                                        @error('description')
                                                            {{$message}}
                                                        @enderror
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="price" class="form-label">Prix</label>
                                                        <input type="number" name="price" class="form-control"
                                                            value="{{ $product->price }}" required>
                                                            @error('price')
                                                                {{$message}}
                                                            @enderror
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="stock_quantity" class="form-label">Quantité en
                                                            stock</label>
                                                        <input type="number" name="stock_quantity" class="form-control"
                                                            value="{{ $product->stock_quantity }}" required>
                                                            @error('stock_quantity')
                                                                {{$message}}
                                                            @enderror
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="category_id" class="form-label">Catégorie</label>
                                                        <select name="category_id" class="form-select" required>
                                                            @foreach ($categories as $category)
                                                                <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>
                                                                    {{ $category->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        @error('category_id')
                                                            <div class="text-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="fournisseur_id" class="form-label">Fournisseur</label>
                                                        <select name="fournisseur_id" class="form-select" required>
                                                            @foreach ($fournisseurs as $fournisseur)
                                                                <option value="{{ $fournisseur->id }}" {{ $product->fournisseur_id == $fournisseur->id ? 'selected' : '' }}>
                                                                    {{ $fournisseur->nom }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        @error('fournisseur_id')
                                                            <div class="text-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <button type="submit" class="btn btn-success">Enregistrer</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Modal pour la suppression du produit -->
                                <div class="modal fade" id="deleteProductModal{{ $product->id }}" tabindex="-1"
                                    aria-labelledby="deleteProductLabel{{ $product->id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="deleteProductLabel{{ $product->id }}">
                                                    Supprimer Produit
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Voulez-vous vraiment supprimer ce produit ?</p>
                                                <form action="{{ route('product.destroy', $product->id) }}"
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

    <!-- Modal pour ajouter un produit -->
    <div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="addProductLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addProductLabel">Ajouter un produit</h5>
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
                    <form action="{{ route('product.store') }}" method="POST">
                        @csrf

                        <div class="d-flex justify-content-around gap-2">
                            <div class="mb-3 d-flex flex-column">
                                <label for="category_id" class="form-label">Catégorie</label>
                                <select name="category_id" class="" required>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3d d-flex flex-column mb-2">
                                <label for="fournisseur_id" class="form-label">Fournisseur</label>
                                <select name="fournisseur_id" class="" required>
                                    @foreach ($fournisseurs as $fournisseur)
                                        <option value="{{ $fournisseur->id }}">{{ $fournisseur->nom }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">Nom</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea name="description" class="form-control"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="price" class="form-label">Prix</label>
                            <input type="number" name="price" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="stock_quantity" class="form-label">Quantité en stock</label>
                            <input type="number" name="stock_quantity" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-success">Ajouter</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
