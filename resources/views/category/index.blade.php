@extends('app')

@section('title', 'Gestion des Catégories')

@section('content')
    <div class="pagetitle">
        <h4 class="card-title">Gestion des Catégories</h4>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Accueil</a></li>
                <li class="breadcrumb-item active">Catégorie</li>
            </ol>
        </nav>

        <h4 class="card-title">Gérer les Catégories</h4>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title">Action</h6>
                </div>
                <div class="card-body">
                    <button class="btn btn-primary bts-sm mt-3" data-bs-toggle="modal"
                        data-bs-target="#addCategoryModal">Ajouter une catégorie</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Liste des catégories -->
    <div class="row mt-4">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title">Liste des catégories</h6>
                </div>
                <div class="card-body">
                    <table class="table datatable">
                        <thead>
                            <tr>
                                <th>Nom</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($categories as $category)
                                <tr>
                                    <td>{{ $category->name }}</td>
                                    <td class="text-end">
                                        <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editCategoryModal{{ $category->id }}">
                                            <i class="bi bi-pencil-fill"></i> 
                                        </button>
                                        <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteCategoryModal{{ $category->id }}">
                                            <i class="bi bi-trash-fill"></i> 
                                        </button>
                                    </td>
                                </tr>

                                <!-- Modal pour la modification -->
                                <div class="modal fade" id="editCategoryModal{{ $category->id }}" tabindex="-1"
                                    aria-labelledby="editCategoryLabel{{ $category->id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editCategoryLabel{{ $category->id }}">Modifier Catégorie</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('category.update', $category->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="mb-3">
                                                        <label for="name" class="form-label">Nom</label>
                                                        <input type="text" name="name" class="form-control"
                                                            value="{{ $category->name }}" required>
                                                    </div>
                                                    <button type="submit" class="btn btn-success">Enregistrer</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Modal pour la suppression -->
                                <div class="modal fade" id="deleteCategoryModal{{ $category->id }}" tabindex="-1"
                                    aria-labelledby="deleteCategoryLabel{{ $category->id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="deleteCategoryLabel{{ $category->id }}">Supprimer Catégorie</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Voulez-vous vraiment supprimer cette catégorie ?</p>
                                                <form action="{{ route('category.destroy', $category->id) }}" method="POST">
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

    <!-- Modal pour ajouter une catégorie -->
    <div class="modal fade" id="addCategoryModal" tabindex="-1" aria-labelledby="addCategoryLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addCategoryLabel">Ajouter une Catégorie</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('category.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Nom</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-success">Ajouter</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
