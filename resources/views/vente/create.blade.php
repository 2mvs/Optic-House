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


<div class="row mt-4">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h6 class="card-title">Ajouter une vente</h6>
                <form action="{{route('vente.store')}}" method="POST" class=" vstack gap-3">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <label for="client_id">Client</label>
                            <select name="client_id" id="client_id" class="form-select select2 @error('client_id') is-invalid @enderror">
                                @foreach($clients as $client)
                                    <option value="{{$client->id}}">{{$client->nom}}</option>
                                @endforeach
                            </select>
                            @error('client_id')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            
                        </div>
                    </div>    
                    <div class="row">
                        <div class="col-md-6">

                        </div>
                    </div>    
                    <div class="row">
                        <div class="col-md-6">

                        </div>
                    </div>
                    <button class="btn btn-primary btn-sm flex-grow-0 col-md-4">Enregistrer</button>    
                </form>
            </div>
        </div>
    </div>
</div>
    
@endsection